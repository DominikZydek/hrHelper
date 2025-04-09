<?php

namespace App\GraphQL\Mutations;

use App\Models\ApprovalProcess;
use App\Models\ApprovalStep;
use App\Models\ApprovalStepsHistory;
use App\Models\CompanyHoliday;
use App\Models\LeaveRequest;
use App\Models\LeaveRequestReplacement;
use App\Models\LeaveType;
use App\Models\User;
use App\Notifications\LeaveRequestNotification;
use Carbon\Carbon;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeaveRequestMutator
{
    public function createLeaveRequest($root, array $args)
    {
        $user = Auth::user();

        if (!$user->hasPermission('create_leave_requests')) {
            throw new Error('You can not create leave requests.');
        }

        try {
            DB::beginTransaction();

            // get info about chosen leave type
            $leaveType = LeaveType::findOrFail($args['leave_type']);

            $dateFrom = Carbon::parse($args['date_from']);
            $dateTo = Carbon::parse($args['date_to']);

            $leaveRequests = LeaveRequest::where('user_id', $user->id)->get();
            $holidays = CompanyHoliday::where('organization_id', $user->organization_id)->get();

            $daysCount = 0;
            $currentDate = clone $dateFrom;

            // this loops through each day and checks if it's counted
            while ($currentDate->lte($dateTo)) {
                $skipDay = false;

                if ($currentDate->isWeekend()) {
                    $skipDay = true;
                }

                foreach ($holidays as $holiday) {
                    $holidayDate = Carbon::parse($holiday->date);
                    if ($currentDate->isSameDay($holidayDate)) {
                        $skipDay = true;
                        break;
                    }
                }

                foreach ($leaveRequests as $request) {
                    $requestStart = Carbon::parse($request->date_from);
                    $requestEnd = Carbon::parse($request->date_to);

                    if ($currentDate->between($requestStart, $requestEnd) && $request->status != 'REJECTED') {
                        throw new \Exception('Leave request overlaps with another leave request.');
                    }
                }

                if (!$skipDay) {
                    $daysCount++;
                }

                $currentDate->addDay();
            }

            // Check if request exceeds the leave type limit
            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now()->endOfYear();

            // Get leave requests of this type that are currently active or pending
            $usedLeaveDaysOfType = LeaveRequest::where('user_id', $user->id)
                ->where('leave_type_id', $args['leave_type'])
                ->whereNotIn('status', ['REJECTED', 'CANCELLED'])
                ->whereBetween('date_from', [$startOfYear, $endOfYear])
                ->sum('days_count');

            // Calculate the limit for this leave type based on working time
            $typeLimit = $leaveType->limit_per_year * $user->working_time;
            $typeLimitRounded = ceil($typeLimit);

            if ($typeLimitRounded != 0 && (($usedLeaveDaysOfType + $daysCount) > $typeLimitRounded)) {
                $remaining = $typeLimitRounded - $usedLeaveDaysOfType;
                throw new \Exception("Exceeded yearly limit for this leave type. Available: {$remaining}, Used: {$usedLeaveDaysOfType}, Requested: {$daysCount}");
            }

            // Need to check total available days (not just those assigned to this leave type)
            // First check pending + used days against total allowed
            $totalAllowedDays = $user->paid_time_off_days * $user->working_time;
            $usedAndPendingDays = $totalAllowedDays - $user->available_pto - $user->transferred_pto;

            // Then check if user has enough available days for this request
            if (($user->available_pto + $user->transferred_pto) < $daysCount) {
                $availableDays = $user->available_pto + $user->transferred_pto;
                throw new \Exception("Not enough available leave days. Available: {$availableDays}, Requested: {$daysCount}");
            }

            // check if leaveType->min_notice_days is respected
            $minNoticeDays = $leaveType->min_notice_days;
            $daysBeforeLeave = Carbon::now()->diffInDays($dateFrom, false);
            if ($daysBeforeLeave < $minNoticeDays) {
                throw new \Exception("Leave request must be submitted at least {$minNoticeDays} days in advance. Currently {$daysBeforeLeave} days in advance.");
            }

            // check if leaveType->requires_replacement and if so, is replacement in $args
            if ($leaveType->requires_replacement && (!isset($args['replacement']) || empty($args['replacement']))) {
                throw new \Exception("This leave type requires a replacement.");
            }

            // create a leave request
            $leaveRequest = LeaveRequest::create([
                'user_id' => $user->id,
                'leave_type_id' => $args['leave_type'],
                'approval_process_id' => $user->approval_process_id,
                'date_from' => $args['date_from'],
                'date_to' => $args['date_to'],
                'days_count' => $daysCount,
                'reason' => $args['reason'],
                'comment' => isset($args['comment']) ? $args['comment'] : null,
                'status' => 'DRAFT',
                'current_approval_step' => 0,
                'replacement_id' => isset($args['replacement']) ? $args['replacement'] : null,
            ]);

            // create a replacement entry if replacement is mandatory
            if ($leaveType->requires_replacement && isset($args['replacement'])) {
                LeaveRequestReplacement::create([
                    'leave_request_id' => $leaveRequest->id,
                    'user_id' => $args['replacement'],
                    'status' => 'IN_PROGRESS',
                    'comment' => null
                ]);
            }

            // create a history entry
            ApprovalStepsHistory::create([
                'leave_request_id' => $leaveRequest->id,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => null,
                'date' => Carbon::now(),
            ]);

            // if the request is meant to be sent and not saved as draft
            if (!$args['save_as_draft']) {
                // Update only the pending_pto counter, not the available_pto
                // Available PTO will be reduced only after final approval
                $user->pending_pto += $daysCount;
                $user->save();

                $leaveRequest->update([
                    'status' => 'IN_PROGRESS',
                    'current_approval_step' => 1,
                ]);

                $firstApproverStep = ApprovalStep::where('approval_process_id', $user->approval_process_id)
                    ->where('order', 1)
                    ->first();

                if ($firstApproverStep) {
                    $firstApprover = User::find($firstApproverStep->approver_id);
                    if ($firstApprover) {
                        $firstApprover->notify(new LeaveRequestNotification(
                            $leaveRequest,
                            'new_approval'
                        ));
                    }
                }
            }

            DB::commit();

            return $leaveRequest;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create request: ' . $e->getMessage());
        }
    }

    public function setLeaveRequestStatus($root, array $args)
    {
        $leaveRequest = LeaveRequest::findOrFail($args['leave_request']);
        $user = User::findOrFail($leaveRequest->user_id);

        // get approval process with associated approval steps
        $approvalSteps = ApprovalProcess::with('steps')->findOrFail($user->approval_process_id)->steps;
        $currentApprovalStep = $approvalSteps[$leaveRequest->current_approval_step - 1];

        // check if auth user is supposed to be accepting the request right now
        $currentUser = Auth::user();

        // throw error if current user is not who they are supposed to be
        if ($currentUser->id != $currentApprovalStep->approver_id) {
            throw new Error('You are not permitted to approve/reject this leave request.');
        }

        try {
            if ($args['status'] == 'APPROVED') {
                // if currently approving user is not the last in the process
                if ($currentApprovalStep->order != $approvalSteps->last()->order) {
                    // add history entry
                    ApprovalStepsHistory::create([
                        'leave_request_id' => $leaveRequest->id,
                        'step' => $leaveRequest->current_approval_step,
                        'status' => 'APPROVED',
                        'approver_id' => ApprovalStep::where('approval_process_id', ApprovalProcess::findOrFail($user->approval_process_id)->id)
                            ->where('order', $leaveRequest->current_approval_step)->first()->approver_id,
                        'comment' => $args['comment'],
                        'date' => Carbon::now(),
                    ]);

                    // increment order, to pass it to the next person in the process
                    $leaveRequest->current_approval_step += 1;
                    $leaveRequest->save();

                    // Powiadom kolejnego approver'a
                    $nextStep = $approvalSteps->firstWhere('order', $leaveRequest->current_approval_step);
                    if ($nextStep) {
                        $nextApprover = User::find($nextStep->approver_id);
                        if ($nextApprover) {
                            $nextApprover->notify(new LeaveRequestNotification(
                                $leaveRequest,
                                'next_approval'
                            ));
                        }
                    }
                } else {
                    // change status to approved, deduct days, etc.
                    $user->pending_pto -= $leaveRequest->days_count;
                    $leaveRequest->status = 'APPROVED';

                    $user->save();
                    $leaveRequest->save();

                    // add history entry
                    ApprovalStepsHistory::create([
                        'leave_request_id' => $leaveRequest->id,
                        'step' => $leaveRequest->current_approval_step,
                        'status' => 'APPROVED',
                        'approver_id' => ApprovalStep::where('approval_process_id', ApprovalProcess::findOrFail($user->approval_process_id)->id)
                            ->where('order', $leaveRequest->current_approval_step)->first()->approver_id,
                        'comment' => $args['comment'],
                        'date' => Carbon::now(),
                    ]);

                    $user->notify(new LeaveRequestNotification(
                        $leaveRequest,
                        'approved',
                        $args['comment']
                    ));
                }
            } else {
                // return pending days, set status
                $user->pending_pto -= $leaveRequest->days_count;
                $user->available_pto += $leaveRequest->days_count;
                $leaveRequest->status = 'REJECTED';

                $user->save();
                $leaveRequest->save();

                // add history entry
                ApprovalStepsHistory::create([
                    'leave_request_id' => $leaveRequest->id,
                    'step' => $leaveRequest->current_approval_step,
                    'status' => 'REJECTED',
                    'approver_id' => ApprovalStep::where('approval_process_id', ApprovalProcess::findOrFail($user->approval_process_id)->id)
                        ->where('order', $leaveRequest->current_approval_step)->first()->approver_id,
                    'comment' => $args['comment'],
                    'date' => Carbon::now(),
                ]);
                $user->notify(new LeaveRequestNotification(
                    $leaveRequest,
                    'rejected',
                    $args['comment']
                ));

            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to approve request: ' . $e->getMessage());
        }

        return $leaveRequest;
    }
}
