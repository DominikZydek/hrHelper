<?php

namespace App\GraphQL\Mutations;

use App\Models\ApprovalProcess;
use App\Models\ApprovalStepsHistory;
use App\Models\CompanyHoliday;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveRequestMutator
{
    public function createLeaveRequest($root, array $args)
    {
        try {
            DB::beginTransaction();

            // get info about chosen leave type
            $leaveType = LeaveType::findOrFail($args['leave_type']);

            $dateFrom = Carbon::parse($args['date_from']);
            $dateTo = Carbon::parse($args['date_to']);

            $leaveRequests = LeaveRequest::where('user_id', Auth::user()->id)->get();
            $holidays = CompanyHoliday::where('organization_id', Auth::user()->organization_id)->get();

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

            // sum this year's 'active' requests of chosen type
            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now()->endOfYear();
            $usedLeaveDaysOfType = LeaveRequest::where('user_id', Auth::user()->id)
                ->where('leave_type_id', $args['leave_type'])
                ->whereNotIn('status', ['REJECTED', 'CANCELLED'])
                ->whereBetween('date_from', [$startOfYear, $endOfYear])
                ->sum('days_count');

            // check if it exceeds leaveType->limit_per_year * Auth::user()->working_time (etat)
            $typeLimit = $leaveType->limit_per_year * Auth::user()->working_time;
            // round up to count full days
            $typeLimitRounded = ceil($typeLimit);
            if (($usedLeaveDaysOfType + $daysCount) > $typeLimitRounded) {
                $remaining = $typeLimitRounded - $usedLeaveDaysOfType;
                throw new \Exception("Exceeded yearly limit for this leave type. Available: {$remaining}, Used: {$usedLeaveDaysOfType}, Requested: {$daysCount}");
            }

            // sum this year's 'active' requests
            $totalUsedLeaveDays = LeaveRequest::where('user_id', Auth::user()->id)
                ->whereNotIn('status', ['REJECTED', 'CANCELLED'])
                ->whereBetween('date_from', [$startOfYear, $endOfYear])
                ->sum('days_count');

            // check if it exceeds Auth::user()->paid_time_off_days * Auth::user()->working_time (etat)
            $totalLimit = Auth::user()->paid_time_off_days * Auth::user()->working_time;
            // round up to count full days
            $totalLimitRounded = ceil($totalLimit);
            if (($totalUsedLeaveDays + $daysCount) > $totalLimitRounded) {
                $remaining = $totalLimitRounded - $totalUsedLeaveDays;
                throw new \Exception("Exceeded yearly total leave limit. Available: {$remaining}, Used: {$totalUsedLeaveDays}, Requested: {$daysCount}");
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
                'user_id' => Auth::user()->id,
                'leave_type_id' => $args['leave_type'],
                'approval_process_id' => Auth::user()->approval_process_id,
                'date_from' => $args['date_from'],
                'date_to' => $args['date_to'],
                'days_count' => $daysCount,
                'reason' => $args['reason'],
                'comment' => isset($args['comment']) ? $args['comment'] : null,
                'status' => 'DRAFT',
                'current_approval_step' => 0,
                'replacement_id' => isset($args['replacement']) ? $args['replacement'] : null,
            ]);

            // create a history entry
            ApprovalStepsHistory::create([
                'leave_request_id' => $leaveRequest->id,
                'step' => 0,
                'status' => 'DRAFT',
                'approver_id' => null,
                'comment' => null,
                'date' => Carbon::now(),
            ]);

            DB::commit();

            return $leaveRequest;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Failed to create request: ' . $e->getMessage());
        }
    }
}
