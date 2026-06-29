<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::first();

        return view('settings.index', compact('settings'));
    }

    public function addons()
    {
        return view('settings.addons');
    }

    public function updateBasicSettings(Request $request)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('settings.index')->with('error', 'This action is disabled in demo mode');
        }

        $appName = $request->appName;
        $appVersion = $request->appVersion;
        $country = $request->country;
        $phoneCountryCode = $request->phoneCountryCode;
        $currency = $request->currency;
        $currencySymbol = $request->currencySymbol;
        $distanceUnit = $request->distanceUnit;

        if ($appName == null) {
            return redirect()->route('settings.index')->with('error', 'App Name is required');
        }

        if ($appVersion == null) {
            return redirect()->route('settings.index')->with('error', 'App Version is required');
        }

        if ($country == null) {
            return redirect()->route('settings.index')->with('error', 'Country is required');
        }

        if ($phoneCountryCode == null) {
            return redirect()->route('settings.index')->with('error', 'Phone Country Code is required');
        }

        if ($currency == null) {
            return redirect()->route('settings.index')->with('error', 'Currency is required');
        }

        if ($currencySymbol == null) {
            return redirect()->route('settings.index')->with('error', 'Currency Symbol is required');
        }

        if ($distanceUnit == null) {
            return redirect()->route('settings.index')->with('error', 'Distance Unit is required');
        }


        $settings = Settings::first();
        $settings->app_name = $appName;
        $settings->app_version = $appVersion;
        $settings->country = $country;
        $settings->phone_country_code = $phoneCountryCode;
        $settings->currency = $currency;
        $settings->currency_symbol = $currencySymbol;
        $settings->distance_unit = $distanceUnit == 'KM' ? 'km' : 'miles';
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings Updated Successfully');
    }

    public function updateDashboardSettings(Request $request)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('settings.index')->with('error', 'This action is disabled in demo mode');
        }

        $offlineCheckTimeType = $request->offlineCheckTimeType;
        $offlineCheckTime = $request->offlineCheckTime;

        if ($offlineCheckTimeType == null) {
            return redirect()->route('settings.index')->with('error', 'Offline Check Time Type is required');
        }

        if ($offlineCheckTime == null) {
            return redirect()->route('settings.index')->with('error', 'Offline Check Time is required');
        }

        $settings = Settings::first();
        $settings->offline_check_time_type = $offlineCheckTimeType;
        $settings->offline_check_time = $offlineCheckTime;
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings Updated Successfully');
    }

    public function updateMobileAppSettings(Request $request)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('settings.index')->with('error', 'This action is disabled in demo mode');
        }
        $mobileAppVersion = $request->mobileAppVersion;
        $privacyPolicyLink = $request->privacyPolicyLink;
        $locationUpdateIntervalType = $request->locationUpdateIntervalType;
        $locationUpdateInterval = $request->locationUpdateInterval;

        if ($mobileAppVersion == null) {
            return redirect()->route('settings.index')->with('error', 'Mobile App Version is required');
        }

        if ($privacyPolicyLink == null) {
            return redirect()->route('settings.index')->with('error', 'Privacy Policy Link is required');
        }

        if ($locationUpdateIntervalType == null) {
            return redirect()->route('settings.index')->with('error', 'Location Update Interval Type is required');
        }

        if ($locationUpdateInterval == null) {
            return redirect()->route('settings.index')->with('error', 'Location Update Interval is required');
        }

        $settings = Settings::first();
        $settings->m_app_version = $mobileAppVersion;
        $settings->privacy_policy_url = $privacyPolicyLink;
        $settings->m_location_update_time_type = $locationUpdateIntervalType;
        $settings->m_location_update_interval = intval($locationUpdateInterval);
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings Updated Successfully');
    }

    public function updateMapSettings(Request $request)
    {

        if (env('DEMO_MODE')) {
            return redirect()->route('settings.index')->with('error', 'This action is disabled in demo mode');
        }
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $mapZoomLevel = $request->mapZoomLevel;

        if ($latitude == null) {
            return redirect()->route('settings.index')->with('error', 'Latitude is required');
        }

        if ($longitude == null) {
            return redirect()->route('settings.index')->with('error', 'Longitude is required');
        }

        if ($mapZoomLevel == null) {
            return redirect()->route('settings.index')->with('error', 'Map Zoom Level is required');
        }

        $settings = Settings::first();
        $settings->center_latitude = $latitude;
        $settings->center_longitude = $longitude;
        $settings->map_zoom_level = $mapZoomLevel;
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings Updated Successfully');
    }


    public function updateAddonStatus(Request $request)
    {
        if (env('DEMO_MODE'))
            return response()->json([
                'status' => 'error',
                'statusCode' => 400,
                'message' => 'This action is disabled in demo mode'
            ]);

        $addon = $request->addon;

        if ($addon == null || $addon == '')
            return response()->json([
                'status' => 'error',
                'statusCode' => 400,
                'message' => 'Addon name is required'
            ]);

        $settings = Settings::first();

        switch ($addon) {
            case 'product':
                $settings->is_product_order_module_enabled = !$settings->is_product_order_module_enabled;
                break;
            case 'task':
                $settings->is_task_module_enabled = !$settings->is_task_module_enabled;
                break;
            case 'notice':
                $settings->is_notice_module_enabled = !$settings->is_notice_module_enabled;
                break;
            case 'dynamicForm':
                $settings->is_dynamic_form_module_enabled = !$settings->is_dynamic_form_module_enabled;
                break;
            case 'expense':
                $settings->is_expense_module_enabled = !$settings->is_expense_module_enabled;
                break;
            case 'leave':
                $settings->is_leave_module_enabled = !$settings->is_leave_module_enabled;
                break;
            case 'document':
                $settings->is_document_module_enabled = !$settings->is_document_module_enabled;
                break;
            case 'chat':
                $settings->is_chat_module_enabled = !$settings->is_chat_module_enabled;
                break;
            case 'loan':
                $settings->is_loan_module_enabled = !$settings->is_loan_module_enabled;
                break;
            case 'paymentCollection':
                $settings->is_payment_collection_module_enabled = !$settings->is_payment_collection_module_enabled;
                break;
            case 'geofence':
                $settings->is_geofence_attendance_module_enabled = !$settings->is_geofence_attendance_module_enabled;
                break;
            case 'ipAttendance':
                $settings->is_ip_attendance_module_enabled = !$settings->is_ip_attendance_module_enabled;
                break;
            case 'uidLogin':
                $settings->is_uid_login_module_enabled = !$settings->is_uid_login_module_enabled;
                break;
            case 'clientVisit':
                $settings->is_client_visit_module_enabled = !$settings->is_client_visit_module_enabled;
                break;
            case 'offlineTracking':
                $settings->is_offline_tracking_module_enabled = !$settings->is_offline_tracking_module_enabled;
                break;
            case 'dataImportExport':
                $settings->is_data_import_export_module_enabled = !$settings->is_data_import_export_module_enabled;
                break;
            case 'site':
                $settings->is_site_module_enabled = !$settings->is_site_module_enabled;
                break;
            case 'qrAttendance':
                $settings->is_qr_attendance_module_enabled = !$settings->is_qr_attendance_module_enabled;
                break;
            case 'dynamicQrAttendance':
                $settings->is_dynamic_qr_attendance_module_enabled = !$settings->is_dynamic_qr_attendance_module_enabled;
                break;
            case 'break':
                $settings->is_break_module_enabled = !$settings->is_break_module_enabled;
                break;
            case 'salesTarget':
                $settings->is_sales_target_module_enabled = !$settings->is_sales_target_module_enabled;
                break;
            case 'aiChat':
                $settings->is_ai_chat_module_enabled = !$settings->is_ai_chat_module_enabled;
                break;
            case 'biometricVerification':
                $settings->is_biometric_verification_module_enabled = !$settings->is_biometric_verification_module_enabled;
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'statusCode' => 400,
                    'message' => 'Invalid addon name'
                ]);
        }

        $settings->save();

        return response()->json([
            'status' => 'success',
            'statusCode' => 200,
            'message' => 'Addon status updated successfully'
        ]);
    }
}
