<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Przypisania uprawnień do ról
        $rolePermissions = [
            'admin' => [
                // Admin ma wszystkie uprawnienia
                'view_users', 'create_users', 'edit_users', 'edit_own_profile',
                'change_user_roles', 'delete_users', 'create_leave_requests',
                'view_own_leave_requests', 'view_all_leave_requests',
                'approve_leave_requests', 'cancel_own_leave_requests',
                'cancel_any_leave_requests', 'manage_groups',
                'manage_approval_processes', 'manage_company_holidays'
            ],
            'hr' => [
                'view_users', 'create_users', 'edit_users', 'edit_own_profile',
                'view_all_leave_requests', 'approve_leave_requests',
                'create_leave_requests', 'view_own_leave_requests',
                'cancel_own_leave_requests', 'manage_company_holidays',
                'manage_groups', 'manage_approval_processes',
            ],
            'supervisor' => [
                'view_users', 'edit_own_profile', 'view_all_leave_requests',
                'approve_leave_requests', 'create_leave_requests',
                'view_own_leave_requests', 'cancel_own_leave_requests'
            ],
            'employee' => [
                'edit_own_profile', 'create_leave_requests',
                'view_own_leave_requests', 'cancel_own_leave_requests'
            ]
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $permissionIds = Permission::whereIn('name', $permissions)
                    ->pluck('id')
                    ->toArray();

                $role->permissions()->attach($permissionIds);
            }
        }
    }
}
