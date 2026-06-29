<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Settings;

class SettingsController extends Controller
{
    /*    public function __construct()
        {
            $this->middleware('auth:api');
        }*/

    public function getAppSettings()
    {
        $settings = Settings::first();

        $response = [
            'appVersion' => $settings->app_version,
            'locationUpdateIntervalType' => $settings->m_location_update_time_type == 'seconds' ? 's' : 'm',
            'locationUpdateInterval' => $settings->m_location_update_interval,
            'privacyPolicyUrl' => $settings->privacy_policy_url,
            'currency' => $settings->currency,
            'currencySymbol' => $settings->currency_symbol,
            'distanceUnit' => $settings->distance_unit,
            'countryPhoneCode' => $settings->phone_country_code
        ];

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'data' => $response
        ]);
    }

    public function getModuleSettings()
    {
        $settings = Settings::first();
        $response = [
            'isProductModuleEnabled' => (bool)$settings->is_product_order_module_enabled,
            'isTaskModuleEnabled' => (bool)$settings->is_task_module_enabled,
            'isNoticeModuleEnabled' => (bool)$settings->is_notice_module_enabled,
            'isDynamicFormModuleEnabled' => (bool)$settings->is_dynamic_form_module_enabled,
            'isExpenseModuleEnabled' => (bool)$settings->is_expense_module_enabled,
            'isLeaveModuleEnabled' => (bool)$settings->is_leave_module_enabled,
            'isDocumentModuleEnabled' => (bool)$settings->is_document_module_enabled,
            'isChatModuleEnabled' => (bool)$settings->is_chat_module_enabled,
            'isLoanModuleEnabled' => (bool)$settings->is_loan_module_enabled,
            'isAiChatModuleEnabled' => (bool)$settings->is_ai_chat_module_enabled,
            'isPaymentCollectionModuleEnabled' => (bool)$settings->is_payment_collection_module_enabled,
            'isGeofenceModuleEnabled' => (bool)$settings->is_geofence_attendance_module_enabled,
            'isIpBasedAttendanceModuleEnabled' => (bool)$settings->is_ip_attendance_module_enabled,
            'isUidLoginModuleEnabled' => (bool)$settings->is_uid_login_module_enabled,
            'isClientVisitModuleEnabled' => (bool)$settings->is_client_visit_module_enabled,
            'isOfflineTrackingModuleEnabled' => (bool)$settings->is_offline_tracking_module_enabled,
            'isBiometricVerificationModuleEnabled' => (bool)$settings->is_biometric_verification_module_enabled,
            'isQrCodeAttendanceModuleEnabled' => (bool)$settings->is_qr_attendance_module_enabled,
            'isDynamicQrCodeAttendanceEnabled' => (bool)$settings->is_dynamic_qr_attendance_module_enabled,
            'isBreakModuleEnabled' => (bool)$settings->is_break_module_enabled,
            'isSiteModuleEnabled' => (bool)$settings->is_site_module_enabled,
            'isDataImportExportModuleEnabled' => (bool)$settings->is_data_import_export_module_enabled,
        ];
        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'data' => $response
        ]);
    }

}
