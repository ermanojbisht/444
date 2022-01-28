<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'ce_office_create',
            ],
            [
                'id'    => 18,
                'title' => 'ce_office_edit',
            ],
            [
                'id'    => 19,
                'title' => 'ce_office_show',
            ],
            [
                'id'    => 20,
                'title' => 'ce_office_delete',
            ],
            [
                'id'    => 21,
                'title' => 'ce_office_access',
            ],
            [
                'id'    => 22,
                'title' => 'se_office_create',
            ],
            [
                'id'    => 23,
                'title' => 'se_office_edit',
            ],
            [
                'id'    => 24,
                'title' => 'se_office_show',
            ],
            [
                'id'    => 25,
                'title' => 'se_office_delete',
            ],
            [
                'id'    => 26,
                'title' => 'se_office_access',
            ],
            [
                'id'    => 27,
                'title' => 'our_office_access',
            ],
            [
                'id'    => 28,
                'title' => 'ee_office_create',
            ],
            [
                'id'    => 29,
                'title' => 'ee_office_edit',
            ],
            [
                'id'    => 30,
                'title' => 'ee_office_show',
            ],
            [
                'id'    => 31,
                'title' => 'ee_office_delete',
            ],
            [
                'id'    => 32,
                'title' => 'ee_office_access',
            ],
            [
                'id'    => 33,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 34,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 35,
                'title' => 'asset_access',
            ],
            [
                'id'    => 36,
                'title' => 'road_basicdatum_create',
            ],
            [
                'id'    => 37,
                'title' => 'road_basicdatum_edit',
            ],
            [
                'id'    => 38,
                'title' => 'road_basicdatum_show',
            ],
            [
                'id'    => 39,
                'title' => 'road_basicdatum_delete',
            ],
            [
                'id'    => 40,
                'title' => 'road_basicdatum_access',
            ],
            [
                'id'    => 41,
                'title' => 'road_div_create',
            ],
            [
                'id'    => 42,
                'title' => 'road_div_edit',
            ],
            [
                'id'    => 43,
                'title' => 'road_div_show',
            ],
            [
                'id'    => 44,
                'title' => 'road_div_delete',
            ],
            [
                'id'    => 45,
                'title' => 'road_div_access',
            ],
            [
                'id'    => 46,
                'title' => 'alerts_for_proj_admin_access',
            ],
            [
                'id'    => 47,
                'title' => 'alert_project_create',
            ],
            [
                'id'    => 48,
                'title' => 'alert_project_edit',
            ],
            [
                'id'    => 49,
                'title' => 'alert_project_show',
            ],
            [
                'id'    => 50,
                'title' => 'alert_project_delete',
            ],
            [
                'id'    => 51,
                'title' => 'alert_project_access',
            ],
            [
                'id'    => 52,
                'title' => 'alert_type_create',
            ],
            [
                'id'    => 53,
                'title' => 'alert_type_edit',
            ],
            [
                'id'    => 54,
                'title' => 'alert_type_show',
            ],
            [
                'id'    => 55,
                'title' => 'alert_type_delete',
            ],
            [
                'id'    => 56,
                'title' => 'alert_type_access',
            ],
            [
                'id'    => 57,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
