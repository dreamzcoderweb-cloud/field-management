<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name');
            $table->string('app_version');
            $table->string('country');
            $table->string('phone_country_code');
            $table->string('timezone');
            $table->string('currency');
            $table->string('currency_symbol');
            $table->enum('distance_unit', ['km', 'miles'])->default('km');

            //Checking
            $table->enum('offline_check_time_type', ['minutes', 'seconds'])->default('minutes');
            $table->integer('offline_check_time')->default(15);

            //Mobile App Settings
            $table->string('m_app_version');
            $table->enum('m_location_update_time_type', ['minutes', 'seconds'])->default('minutes');
            $table->integer('m_location_update_interval');
            $table->string('privacy_policy_url');

            //Map Settings
            $table->string('map_provider')->default('google');
            $table->integer('map_zoom_level');
            $table->decimal('center_latitude', 10, 8);
            $table->decimal('center_longitude', 11, 8);

            $table->boolean('verify_client_number')->default(false);
            $table->boolean('is_audit_log_enabled')->default(false);

            $table->string('employee_code_prefix')->default('EMP');
            $table->string('order_prefix')->default('FM_ORD');

            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();


            //Addons
            $table->boolean('is_ai_chat_enabled')->default(false);
            $table->boolean('is_product_order_module_enabled')->default(false);
            $table->boolean('is_task_module_enabled')->default(false);
            $table->boolean('is_notice_module_enabled')->default(false);
            $table->boolean('is_dynamic_form_module_enabled')->default(false);
            $table->boolean('is_expense_module_enabled')->default(false);
            $table->boolean('is_leave_module_enabled')->default(false);
            $table->boolean('is_document_module_enabled')->default(false);
            $table->boolean('is_chat_module_enabled')->default(false);
            $table->boolean('is_loan_module_enabled')->default(false);
            $table->boolean('is_payment_collection_module_enabled')->default(false);
            $table->boolean('is_geofence_attendance_module_enabled')->default(false);
            $table->boolean('is_ip_attendance_module_enabled')->default(false);
            $table->boolean('is_uid_login_module_enabled')->default(false);
            $table->boolean('is_client_visit_module_enabled')->default(false);
            $table->boolean('is_offline_tracking_module_enabled')->default(false);
            $table->boolean('is_data_import_export_module_enabled')->default(false);
            $table->boolean('is_site_module_enabled')->default(false);
            $table->boolean('is_qr_attendance_module_enabled')->default(false);
            $table->boolean('is_dynamic_qr_attendance_module_enabled')->default(false);
            $table->boolean('is_break_module_enabled')->default(false);
            $table->boolean('is_sales_target_module_enabled')->default(false);
            $table->boolean('is_ai_chat_module_enabled')->default(false);
            $table->boolean('is_biometric_verification_module_enabled')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
