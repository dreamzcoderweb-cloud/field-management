<?php

namespace App\Classes;

use App\Models\Settings;
use Module;

class AddonHelper
{
    protected Settings $settings;

    protected array $allModuleStatus = [];

    public function __construct()
    {
        $this->settings = Settings::first();
        $this->allModuleStatus = $this->getAllModulesWithVersion();
    }

    public function getAllModuleStatus(): array
    {

        return [
            'is_product_order_module_enabled' => $this->isProductOrderModuleEnabled(),
            'is_task_module_enabled' => $this->isTaskModuleEnabled(),
            'is_notice_module_enabled' => $this->isNoticeModuleEnabled(),
            'is_dynamic_form_module_enabled' => $this->isDynamicFormModuleEnabled(),
            'is_expense_module_enabled' => $this->isExpenseModuleEnabled(),
            'is_leave_module_enabled' => $this->isLeaveModuleEnabled(),
            'is_document_module_enabled' => $this->isDocumentModuleEnabled(),
            'is_chat_module_enabled' => $this->isChatModuleEnabled(),
            'is_loan_module_enabled' => $this->isLoanModuleEnabled(),
            'is_audit_log_enabled' => $this->isAuditLogEnabled(),
            'is_payment_collection_module_enabled' => $this->isPaymentCollectionModuleEnabled(),
            'is_geofence_attendance_module_enabled' => $this->isGeofenceAttendanceModuleEnabled(),
            'is_ip_attendance_module_enabled' => $this->isIpAttendanceModuleEnabled(),
            'is_uid_login_module_enabled' => $this->isUidLoginModuleEnabled(),
            'is_client_visit_module_enabled' => $this->isClientVisitModuleEnabled(),
            'is_offline_tracking_module_enabled' => $this->isOfflineTrackingModuleEnabled(),
            'is_data_import_export_module_enabled' => $this->isDataImportExportModuleEnabled(),
            'is_site_module_enabled' => $this->isSiteModuleEnabled(),
            'is_qr_attendance_module_enabled' => $this->isQrAttendanceModuleEnabled(),
            'is_dynamic_qr_attendance_module_enabled' => $this->isDynamicQrAttendanceModuleEnabled(),
            'is_break_module_enabled' => $this->isBreakModuleEnabled(),
            'is_sales_target_module_enabled' => $this->isSalesTargetModuleEnabled(),
            'is_ai_chat_module_enabled' => $this->isAiChatModuleEnabled(),
        ];

    }

    public function getAllModulesWithVersion()
    {
        $noticeBoard = [
            'name' => config('noticeboard.name'),
            'version' => $this->noticeModuleVersion(),
            'is_enabled' => $this->isNoticeModuleEnabled(),
            'is_installed' => Module::find('NoticeBoard') != null,
        ];

        $productOrder = [
            'name' => config('productorder.name'),
            'version' => $this->productOrderModuleVersion(),
            'is_enabled' => $this->isProductOrderModuleEnabled(),
            'is_installed' => Module::find('ProductOrder') != null,
        ];

        $taskSystem = [
            'name' => config('tasksystem.name'),
            'version' => $this->taskSystemVersion(),
            'is_enabled' => $this->isTaskModuleEnabled(),
            'is_installed' => Module::find('TaskSystem') != null,
        ];

        $dynamicForms = [
            'name' => config('dynamicforms.name'),
            'version' => $this->dynamicFormsVersion(),
            'is_enabled' => $this->isDynamicFormModuleEnabled(),
            'is_installed' => Module::find('DynamicForms') != null,
        ];

        $documentManagement = [
            'name' => config('documentmanagement.name'),
            'version' => $this->documentManagementVersion(),
            'is_enabled' => $this->isDocumentModuleEnabled(),
            'is_installed' => Module::find('DocumentManagement') != null,
        ];

        $loanManagement = [
            'name' => config('loanmanagement.name'),
            'version' => $this->loanManagementVersion(),
            'is_enabled' => $this->isLoanModuleEnabled(),
            'is_installed' => Module::find('LoanManagement') != null,
        ];

        $paymentCollection = [
            'name' => config('paymentcollection.name'),
            'version' => $this->paymentCollectionModuleVersion(),
            'is_enabled' => $this->isPaymentCollectionModuleEnabled(),
            'is_installed' => Module::find('PaymentCollection') != null,
        ];

        $offlineTracking = [
            'name' => config('offlinetracking.name'),
            'version' => $this->offlineTrackingModuleVersion(),
            'is_enabled' => $this->isOfflineTrackingModuleEnabled(),
            'is_installed' => Module::find('OfflineTracking') != null,
        ];


        $geofenceSystem = [
            'name' => config('geofencesystem.name'),
            'version' => $this->geofenceSystemModuleVersion(),
            'is_enabled' => $this->isGeofenceAttendanceModuleEnabled(),
            'is_installed' => Module::find('GeofenceSystem') != null,
        ];

        $ipAddressAttendance = [
            'name' => config('ipaddressattendance.name'),
            'version' => $this->ipAddressModuleVersion(),
            'is_enabled' => $this->isIpAttendanceModuleEnabled(),
            'is_installed' => Module::find('IpAddressAttendance') != null,
        ];

        $uidLogin = [
            'name' => config('uidlogin.name'),
            'version' => $this->uidLoginModuleVersion(),
            'is_enabled' => $this->isUidLoginModuleEnabled(),
            'is_installed' => Module::find('UidLogin') != null,
        ];

        return [
            $noticeBoard,
            $productOrder,
            $taskSystem,
            $dynamicForms,
            $documentManagement,
            $loanManagement,
            $paymentCollection,
            $offlineTracking,
            $geofenceSystem,
            $ipAddressAttendance,
            $uidLogin,
        ];
    }

    public function isProductOrderModuleEnabled()
    {
        //Check addon module is installed
        if (Module::find('ProductOrder') == null) {
            if ($this->settings->is_product_order_module_enabled) {
                $this->settings->update(['is_product_order_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_product_order_module_enabled;
    }

    public function isProductOrderModuleInstalled()
    {
        return Module::find('ProductOrder') != null;
    }

    public function productOrderModuleVersion()
    {
        return 'V' . config('productorder.version');
    }

    public function isTaskModuleEnabled()
    {
        //Check addon module is installed
        if (Module::find('TaskSystem') == null) {
            if ($this->settings->is_task_module_enabled) {
                $this->settings->update(['is_task_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_task_module_enabled;
    }

    public function isTaskModuleInstalled()
    {
        return Module::find('TaskSystem') != null && $this->taskSystemVersion() != 'V';
    }

    public function taskSystemVersion()
    {
        return 'V' . config('tasksystem.version');
    }

    public function isNoticeModuleEnabled()
    {
        //Check addon module is installed
        if (Module::find('NoticeBoard') == null) {
            if ($this->settings->is_notice_module_enabled) {
                $this->settings->update(['is_notice_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_notice_module_enabled;
    }

    public function isNoticeModuleInstalled()
    {
        return Module::find('NoticeBoard') != null && $this->noticeModuleVersion() != 'V';
    }

    public function noticeModuleVersion()
    {
        return 'V' . config('noticeboard.version');
    }

    public function isDynamicFormModuleEnabled()
    {
        if (Module::find('DynamicForms') == null) {
            if ($this->settings->is_dynamic_form_module_enabled) {
                $this->settings->update(['is_dynamic_form_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_dynamic_form_module_enabled;
    }

    public function isDynamicFormModuleInstalled()
    {
        return Module::find('DynamicForms') != null && $this->dynamicFormsVersion() != 'V';
    }

    public function dynamicFormsVersion()
    {
        return 'V' . config('dynamicforms.version');
    }

    public function isExpenseModuleEnabled()
    {
        return (bool)$this->settings->is_expense_module_enabled;
    }

    public function isBiometricModuleEnabled()
    {
        return (bool)$this->settings->is_biometric_verification_module_enabled;
    }

    public function isLeaveModuleEnabled()
    {
        return (bool)$this->settings->is_leave_module_enabled;
    }

    public function isDocumentModuleEnabled()
    {
        //Check addon module is installed
        if (Module::find('DocumentManagement') == null) {
            if ($this->settings->is_document_module_enabled) {
                $this->settings->update(['is_document_module_enabled' => 0]);
                return false;
            }
            return false;
        }

        return (bool)$this->settings->is_document_module_enabled;
    }

    public function isDocumentModuleInstalled()
    {
        return Module::find('DocumentManagement') != null && $this->documentManagementVersion() != 'V';
    }

    public function documentManagementVersion()
    {
        return 'V' . config('documentmanagement.version');
    }

    public function isChatModuleEnabled()
    {
        return (bool)$this->settings->is_chat_module_enabled;
    }

    public function isLoanModuleEnabled()
    {
        //Check addon module is installed
        if (Module::find('LoanManagement') == null) {
            if ($this->settings->is_loan_module_enabled) {
                $this->settings->update(['is_loan_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_loan_module_enabled;
    }

    public function loanManagementVersion()
    {
        return 'V' . config('loanmanagement.version');
    }

    public function isLoanModuleInstalled()
    {
        return Module::find('LoanManagement') != null && $this->loanManagementVersion() != 'V';
    }

    public function isAuditLogEnabled()
    {
        return (bool)$this->settings->is_audit_log_enabled;
    }

    public function isPaymentCollectionModuleEnabled()
    {
        if (Module::find('PaymentCollection') == null) {
            if ($this->settings->is_payment_collection_module_enabled) {
                $this->settings->update(['is_payment_collection_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_payment_collection_module_enabled;
    }

    public function paymentCollectionModuleVersion()
    {
        return 'V' . config('paymentcollection.version');
    }

    public function isPaymentCollectionModuleInstalled()
    {
        return Module::find('PaymentCollection') != null && $this->paymentCollectionModuleVersion() != 'V';
    }

    public function isGeofenceAttendanceModuleEnabled()
    {
        if (Module::find('GeofenceSystem') == null) {
            if ($this->settings->is_geofence_attendance_module_enabled) {
                $this->settings->update(['is_geofence_attendance_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_geofence_attendance_module_enabled;
    }

    public function geofenceSystemModuleVersion()
    {
        return 'V' . config('geofencesystem.version');
    }

    public function isGeofenceAttendanceModuleInstalled()
    {
        return Module::find('GeofenceSystem') != null && $this->geofenceSystemModuleVersion() != 'V';
    }

    public function isIpAttendanceModuleEnabled()
    {
        if (Module::find('IpAddressAttendance') == null) {
            if ($this->settings->is_ip_attendance_module_enabled) {
                $this->settings->update(['is_ip_attendance_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_ip_attendance_module_enabled;
    }

    public function ipAddressModuleVersion()
    {
        return 'V' . config('ipaddressattendance.version');
    }

    public function isIpAttendanceModuleInstalled()
    {
        return Module::find('IpAddressAttendance') != null && $this->ipAddressModuleVersion() != 'V';
    }

    public function isUidLoginModuleEnabled()
    {
        if (Module::find('UidLogin') == null) {
            if ($this->settings->is_uid_login_module_enabled) {
                $this->settings->update(['is_uid_login_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_uid_login_module_enabled;
    }

    public function uidLoginModuleVersion()
    {
        return 'V' . config('uidlogin.version');
    }

    public function isUidLoginModuleInstalled()
    {
        return Module::find('UidLogin') != null && $this->uidLoginModuleVersion() != 'V';
    }

    public function isClientVisitModuleEnabled()
    {
        return (bool)$this->settings->is_client_visit_module_enabled;
    }

    public function isOfflineTrackingModuleEnabled()
    {
        if (Module::find('OfflineTracking') == null) {
            if ($this->settings->is_offline_tracking_module_enabled) {
                $this->settings->update(['is_offline_tracking_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_offline_tracking_module_enabled;
    }

    public function offlineTrackingModuleVersion()
    {
        return 'V' . config('offlinetracking.version');
    }

    public function isOfflineTrackingModuleInstalled()
    {
        return Module::find('OfflineTracking') != null && $this->offlineTrackingModuleVersion() != 'V';
    }

    public function isDataImportExportModuleEnabled()
    {
        return (bool)$this->settings->is_data_import_export_module_enabled;
    }

    public function isSiteModuleEnabled()
    {
        if (Module::find('SiteAttendance') == null) {
            if ($this->settings->is_site_module_enabled) {
                $this->settings->update(['is_site_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_site_module_enabled;
    }

    public function siteModuleVersion()
    {
        return 'V' . config('siteattendance.version');
    }

    public function isSiteModuleInstalled()
    {
        return Module::find('SiteAttendance') != null && $this->siteModuleVersion() != 'V';
    }

    public function isQrAttendanceModuleEnabled()
    {
        if (Module::find('QrAttendance') == null) {
            if ($this->settings->is_qr_attendance_module_enabled) {
                $this->settings->update(['is_qr_attendance_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_qr_attendance_module_enabled;
    }

    public function qrAttendanceModuleVersion()
    {
        return 'V' . config('qrattendance.version');
    }

    public function isQrAttendanceModuleInstalled()
    {
        return Module::find('QrAttendance') != null && $this->qrAttendanceModuleVersion() != 'V';
    }

    public function isDynamicQrAttendanceModuleEnabled()
    {
        return (bool)$this->settings->is_dynamic_qr_attendance_module_enabled;
    }

    public function isBreakModuleEnabled()
    {
        if (Module::find('BreakSystem') == null) {
            if ($this->settings->is_break_module_enabled) {
                $this->settings->update(['is_break_module_enabled' => 0]);
                return false;
            }
            return false;
        }
        return (bool)$this->settings->is_break_module_enabled;
    }

    public function breakSystemModuleVersion()
    {
        return 'V' . config('breaksystem.version');
    }

    public function isBreakModuleInstalled()
    {
        return Module::find('BreakSystem') != null && $this->breakSystemModuleVersion() != 'V';
    }

    public function isSalesTargetModuleEnabled()
    {
        return (bool)$this->settings->is_sales_target_module_enabled;
    }

    public function isAiChatModuleEnabled()
    {
        return (bool)$this->settings->is_ai_chat_module_enabled;
    }

}
