<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('settings')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Settings::create([
            'app_name' => 'Field Manager',
            'app_version' => '3.1.2',
            'country' => 'USA',
            'phone_country_code' => '+1',
            'timezone' => 'America/New_York',
            'currency' => 'USD',
            'currency_symbol' => '$',
            'distance_unit' => 'km',
            'offline_check_time_type' => 'minutes',
            'offline_check_time' => 15,
            'm_app_version' => '3.0.0',
            'm_location_update_time_type' => 'seconds',
            'm_location_update_interval' => 15,
            'privacy_policy_url' => 'https://czappstudio.com/privacy-policy/',
            'map_provider' => 'google',
            'map_zoom_level' => 3,
            'center_latitude' => 18.418983770139405,
            'center_longitude' => 49.67194361588897,
            'employee_code_prefix' => 'EMP',
            'order_prefix' => 'FM_ORD',
            'is_product_order_module_enabled' => false,
            'is_task_module_enabled' => true,
            'is_notice_module_enabled' => true,
            'is_dynamic_form_module_enabled' => false,
            'is_expense_module_enabled' => true,
            'is_leave_module_enabled' => true,
            'is_document_module_enabled' => true,
            'is_chat_module_enabled' => true,
            'is_loan_module_enabled' => true,
            'is_payment_collection_module_enabled' => true,
            'is_geofence_attendance_module_enabled' => true,
            'is_ip_attendance_module_enabled' => true,
            'is_uid_login_module_enabled' => true,
            'is_client_visit_module_enabled' => true,
            'is_offline_tracking_module_enabled' => true,
            'is_data_import_export_module_enabled' => false,
            'is_site_module_enabled' => false,
            'is_qr_attendance_module_enabled' => true,
            'is_dynamic_qr_attendance_module_enabled' => false,
            'is_break_module_enabled' => true,
            'is_sales_target_module_enabled' => false,
            'is_ai_chat_module_enabled' => false,

        ]);
    }
}
