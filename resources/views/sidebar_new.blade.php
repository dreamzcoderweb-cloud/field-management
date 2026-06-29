<?php

use App\Models\Settings;

$settings = Settings::first();
?>
<nav class="navbar navbar-vertical navbar-expand-lg">
    <script>
        var navbarStyle = window.config.config.phoenixNavbarStyle;
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li>
                    <p class="navbar-vertical-label">
                        Monitoring
                    </p>
                    <hr class="navbar-vertical-line" />
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('index') ? 'active' : '' }}"
                            href="{{ route('index') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-house"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Dashboard</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('liveLocation') ? 'active' : '' }}"
                            href="{{ route('liveLocation') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-pin-map-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Live Location</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('timeLine') ? 'active' : '' }}"
                            href="{{ route('timeLine') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fa fa-route"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Time Line</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('cardView') ? 'active' : '' }}"
                            href="{{ route('cardView') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-card-heading"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Card View</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.lead.index') ? 'active' : '' }}"
                            href="{{ route('admin.lead.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-person-lines-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Enquiry</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                @if ($settings->is_task_module_enabled)
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link label-1 {{ Route::is('taskView') ? 'active' : '' }}"
                                href="{{ route('taskView') }}" role="button" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="bi bi-card-checklist"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Task View @if (env('DEMO_MODE'))
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </li>
                @endif
                <!-- Employee Management -->
                <div class="nav-item-wrapper">
                    <a class="nav-link dropdown-indicator label-1" href="#nv-email" role="button"
                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-email">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div>
                            <span class="nav-link-icon"> <i class="bi bi-people"></i></span><span
                                class="nav-link-text">Employee Management</span>
                        </div>
                    </a>
                    <div class="parent-wrapper label-1">
                        <ul class="nav collapse parent {{ Route::is('team.index') || Route::is('employee.index') || Route::is('device.index') || Route::is('admin.payroll.*') || Route::is('admin.target.*') ? 'show' : '' }}"
                            data-bs-parent="#navbarVerticalCollapse" id="nv-email">
                            <li class="collapsed-nav-item-title d-none">
                                Employee Management
                            </li>
                            <li class="nav-item">
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 {{ Route::is('employee.index') ? 'active' : '' }}"
                                        href="{{ route('employee.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text-wrapper">
                                                <span class="nav-link-text">Employees</span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 {{ Route::is('team.index') ? 'active' : '' }}"
                                        href="{{ route('team.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text-wrapper">
                                                <span class="nav-link-text">Teams</span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 {{ Route::is('device.index') ? 'active' : '' }}"
                                        href="{{ route('device.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text-wrapper">
                                                <span class="nav-link-text">Device Management</span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 {{ Route::is('admin.payroll.index') ? 'active' : '' }}"
                                        href="{{ route('admin.payroll.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text-wrapper">
                                                <span class="nav-link-text">Payroll</span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <div class="nav-item-wrapper">
                                    <a class="nav-link label-1 {{ Route::is('admin.target.*') ? 'active' : '' }}"
                                        href="{{ route('admin.target.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text-wrapper">
                                                <span class="nav-link-text">Target</span>
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Employee Management End-->
                <!-- Attendance-->
                <div class="nav-item-wrapper">
                    <a class="nav-link dropdown-indicator label-1" href="#nv-attendance" role="button"
                        data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-attendance">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                                <span class="fas fa-caret-right"></span>
                            </div>
                            <span class="nav-link-icon">
                                <span class="bi bi-calendar2-week"></span>
                            </span>
                            <span class="nav-link-text">Attendance Management</span>
                        </div>
                    </a>
                    <div class="parent-wrapper label-1">
                        <ul class="nav collapse parent {{ Route::is('shift.index') ? 'show' : '' }}"
                            data-bs-parent="#navbarVerticalCollapse" id="nv-attendance">
                            <li class="collapsed-nav-item-title d-none">
                                Attendance Management
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('shift.index') ? 'active' : '' }}" data-bs-toggle=""
                                    aria-expanded="false" href="{{ route('shift.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Shifts</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('holiday.index') ? 'active' : '' }}"
                                    data-bs-toggle="" aria-expanded="false" href="{{ route('holiday.index') }}">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Holidays</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            @if ($settings->is_client_visit_module_enabled)
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('visit.index') ? 'active' : '' }}"
                                        data-bs-toggle="" aria-expanded="false" href="{{ route('visit.index') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Visits</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            @endif

                            @if ($settings->is_ip_attendance_module_enabled)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ipgroup.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">IP Groups @if (env('DEMO_MODE'))
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            @endif

                            @if ($settings->is_geofence_attendance_module_enabled)

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('geofencegroup.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Geofence Groups
                                                @if (env('DEMO_MODE'))
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endif

                            @if ($settings->is_qr_attendance_module_enabled)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('qrcode.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">QR Code Groups
                                                @if (env('DEMO_MODE'))
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </li>
                            @endif

                            {{-- @if ($settings->is_dynamic_qr_attendance_module_enabled)
                                 <li class="nav-item">
                                     <a class="nav-link " asp-controller="DynamicQrDevice"
                                        asp-action="Index" data-bs-toggle="" aria-expanded="false">
                                         <div class="d-flex align-items-center">
                                             <span class="nav-link-text">Dynamic Qr Devices</span>
                                         </div>
                                     </a>
                                     <!-- more inner pages-->
                                 </li>
                             @endif --}}
                        </ul>
                    </div>
                </div>
                <!-- Attendance End-->

                @if ($settings->is_product_order_module_enabled)
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-product" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-product">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                    <span class="fas fa-caret-right"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <span class="bi bi-box-seam"></span>
                                </span>
                                <span class="nav-link-text">Products & Orders</span>
                            </div>
                        </a>
                        {{-- <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Route::is('order.index') || Route::is('product.index') || Route::is('productcategory.index') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-product">
                                <li class="collapsed-nav-item-title d-none">
                                    Products & Orders
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('order.index') ? 'active' : '' }}"
                                        href="{{ route('order.index') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Orders</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('product.index') ? 'active' : '' }}"
                                        href="{{ route('product.index') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Products</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('productcategory.index') ? 'active' : '' }}"
                                        href="{{ route('productcategory.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Product Categories</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                @endif
                @if ($settings->is_notice_module_enabled)
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link label-1 {{ Route::is('noticeboard.index') ? 'active' : '' }}"
                                href="{{ route('noticeboard.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="bi bi-clipboard-data"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Notice
                                            @if (env('DEMO_MODE'))
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </li>
                @endif
                @if ($settings->is_payment_collection_module_enabled)
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link label-1 {{ Route::is('paymentcollection.index') ? 'active' : '' }}"
                                href="{{ route('paymentcollection.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="bi bi-cash-stack"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Payment Collections
                                            @if (env('DEMO_MODE'))
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </li>
                @endif

                @if ($settings->is_leave_module_enabled)
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-leave" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-leave">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                    <span class="fas fa-caret-right"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <span class="bi bi-calendar2-week"></span>
                                </span>
                                <span class="nav-link-text">Leave Management</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Route::is('leaveRequest.index') || Route::is('leaveType.index') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-leave">
                                <li class="collapsed-nav-item-title d-none">
                                    Leave Management
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('leaveRequest.index') }}"
                                        href="{{ route('leaveRequest.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Leave Requests</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('leaveType.index') }}"
                                        href="{{ route('leaveType.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Leave Types</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif

                @if ($settings->is_expense_module_enabled)
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-expense" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-leave">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                    <span class="fas fa-caret-right"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <i class="bi bi-cash-coin"></i>
                                </span>
                                <span class="nav-link-text">Expense Management</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Route::is('expenseRequest.index') || Route::is('expenseType.index') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-expense">
                                <li class="collapsed-nav-item-title d-none">
                                    Expense Management
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('expenseRequest.index') }}"
                                        href="{{ route('expenseRequest.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Expense Requests</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('expenseType.index') }}"
                                        href="{{ route('expenseType.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Expense Types</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="nav-item-wrapper">
                    <a class="nav-link dropdown-indicator label-1 {{ Route::is('sale.*') || Route::is('collections.*') ? 'active' : '' }}"
                        href="#nv-sales" role="button" data-bs-toggle="collapse" aria-expanded="true"
                        aria-controls="nv-leave">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                                <span class="fas fa-caret-right"></span>
                            </div>
                            <span class="nav-link-icon">
                                <i class="bi bi-graph-up"></i>
                            </span>
                            <span class="nav-link-text">Sales Management</span>
                        </div>
                    </a>
                    <div class="parent-wrapper label-1">
                        <ul class="nav collapse parent {{ Route::is('sale.*') || Route::is('collections.*') ? 'show' : '' }}"
                            data-bs-parent="#navbarVerticalCollapse" id="nv-sales">
                            <li class="collapsed-nav-item-title d-none" {{ Route::is('sale.*') || Route::is('collections.*') ? 'active' : '' }}>
                                Sales Management
                            </li>
                            <li class="nav-item {{ Route::is('sale.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('sale.*') ? 'active' : '' }}"
                                    href="{{ route('sale.index') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Sales</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            <li class="nav-item {{ Route::is('collections.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('collections.*') ? 'active' : '' }}"
                                    href="{{ route('collections.index') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Collections</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="nav-item-wrapper">
                    <a class="nav-link dropdown-indicator label-1 {{ Route::is('admin.stock.*') ? 'active' : '' }}"
                        href="#nv-stocks" role="button" data-bs-toggle="collapse" aria-expanded="true"
                        aria-controls="nv-leave">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                                <span class="fas fa-caret-right"></span>
                            </div>
                            <span class="nav-link-icon">
                                <i class="bi bi-box-seam"></i>
                            </span>
                            <span class="nav-link-text">Stock Management</span>
                        </div>
                    </a>
                    <div class="parent-wrapper label-1">
                        <ul class="nav collapse parent {{ Route::is('admin.stock*') ? 'active' : '' }}"
                            data-bs-parent="#navbarVerticalCollapse" id="nv-stocks">
                            <li class="collapsed-nav-item-title d-none"
                                {{ Route::is('admin.stock*') ? 'active' : '' }}>
                                Stock Management
                            </li>
                            <li class="nav-item {{ Route::is('admin.stockhistory.create') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('admin.stockhistory.create') ? 'active' : '' }}"
                                    href="{{ route('admin.stockhistory.create') }}" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Add Stock</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            <li class="nav-item {{ Route::is('admin.stock.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('admin.stock.*') ? 'active' : '' }}"
                                    href="{{ route('admin.stock.index') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Overall Stock</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>

                        </ul>
                    </div>
                </div>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.task.*') ? 'active' : '' }}"
                            href="{{ route('admin.task.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-clipboard-check"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Task</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.vehiclemanagement.*') ? 'active' : '' }}"
                            href="{{ route('admin.vehiclemanagement.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-car-front"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Vehicle Management</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                @if ($settings->is_document_module_enabled)
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1" href="#nv-doc" role="button"
                            data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-leave">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon">
                                    <span class="fas fa-caret-right"></span>
                                </div>
                                <span class="nav-link-icon">
                                    <i class="bi bi-file-earmark-richtext"></i>
                                </span>
                                <span class="nav-link-text">Document Management</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Route::is('documentmanagement.index') || Route::is('documenttypes.index') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-doc">
                                <li class="collapsed-nav-item-title d-none">
                                    Document Management
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('documentmanagement.index') }}"
                                        href="{{ route('documentmanagement.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Document Requests
                                                @if (env('DEMO_MODE'))
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('documenttypes.index') }}"
                                        href="{{ route('documenttypes.index') }}" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Document Types
                                                @if (env('DEMO_MODE'))
                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="right"
                                                        title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif

                @if ($settings->is_task_module_enabled)
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link label-1 {{ Route::is('tasksystem.index') ? 'active' : '' }}"
                                href="{{ route('tasksystem.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="bi bi-card-checklist"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Tasks
                                            @if (env('DEMO_MODE'))
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </li>
                @endif

                @if ($settings->is_loan_module_enabled)
                    <li class="nav-item">
                        <div class="nav-item-wrapper">
                            <a class="nav-link label-1  {{ Route::is('loan.index') ? 'active' : '' }}"
                                href="{{ route('loan.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span class="bi bi-cash-coin"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">Loan Requests
                                            @if (env('DEMO_MODE'))
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Premium Addon"><i class="fa-solid fa-award"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </li>
                @endif
                <li>
                    <p class="navbar-vertical-label">
                        Utilities
                    </p>
                    <hr class="navbar-vertical-line" />
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('chat.index') ? 'active' : '' }}"
                            href="{{ route('report.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Reports</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.salereport.*') ? 'active' : '' }}"
                            href="{{ route('admin.salereport.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Sales Report</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li> --}}

                <div class="nav-item-wrapper">
                    <a class="nav-link dropdown-indicator label-1"
                        href="#nv-salereport" role="button" data-bs-toggle="collapse" aria-expanded="true"
                        aria-controls="nv-leave">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon">
                                <span class="fas fa-caret-right"></span>
                            </div>
                            <span class="nav-link-icon">
                                <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                            </span>
                            <span class="nav-link-text">Sales Report</span>
                        </div>
                    </a>
                    <div class="parent-wrapper label-1">
                        <ul class="nav collapse parent {{ Route::is('admin.salereport.*') || Route::is('admin.exchangesale*') ? 'show' : '' }}"
                            data-bs-parent="#navbarVerticalCollapse" id="nv-salereport">
                            <li class="collapsed-nav-item-title d-none"
                                {{ Route::is('admin.salereport.*') || Route::is('admin.exchangesale*') ? 'active' : '' }}>
                                Sales Report
                            </li>
                            <li class="nav-item {{ Route::is('admin.salereport.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('admin.salereport.*') ? 'active' : '' }}"
                                    href="{{ route('admin.salereport.index') }}" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Without Exchange</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            <li class="nav-item {{ Route::is('admin.exchangesale.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('admin.exchangesale.*') ? 'active' : '' }}"
                                    href="{{ route('admin.exchangesale.index') }}" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">With Exchange</span>
                                    </div>
                                </a>
                                <!-- more inner pages-->
                            </li>
                            <li class="nav-item {{ Route::is('admin.outstandingreport.*') ? 'active' : '' }}">
                                <a class="nav-link {{ Route::is('admin.outstandingreport.*') ? 'active' : '' }}"
                                    href="{{ route('admin.outstandingreport.index') }}" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Outstanding Customers</span>
                                    </div>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <li>
                    <p class="navbar-vertical-label">
                        Master
                    </p>
                    <hr class="navbar-vertical-line" />
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.brand.*') ? 'active' : '' }}"
                            href="{{ route('admin.brand.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Brand</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('productcategory.index') ? 'active' : '' }}"
                            href="{{ route('productcategory.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Category</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('productsubcategory.index') ? 'active' : '' }}"
                            href="{{ route('productsubcategory.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Sub Category</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('bank.index') ? 'active' : '' }}"
                            href="{{ route('bank.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Bank</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('loan.index') ? 'active' : '' }}"
                            href="{{ route('loan.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Loan</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li> --}}


                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('productList') ? 'active' : '' }}"
                            href="{{ route('productList') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-box"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Product</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('admin.vehicle.*') ? 'active' : '' }}"
                            href="{{ route('admin.vehicle.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-truck"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Vehicle</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>









                <li>
                    <p class="navbar-vertical-label">
                        Other
                    </p>
                    <hr class="navbar-vertical-line" />
                </li>

                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('chat.index') ? 'active' : '' }}"
                            href="{{ route('chat.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-chat-dots"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Chats</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1  {{ Route::is('client.index') ? 'active' : '' }}"
                            href="{{ route('client.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fa fa-building"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Clients</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                {{-- <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 {{ Route::is('task.index') ? 'active' : '' }}"
                           href="{{route('task.index')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                 <span class="nav-link-icon">
                     <span class="bi bi-chat-dots"></span>
                 </span>
                                <span class="nav-link-text-wrapper">
                     <span class="nav-link-text">Task</span>
                 </span>
                            </div>
                        </a>
                    </div>
                </li> --}}
                {{--  <li class="nav-item">
                      <div class="nav-item-wrapper">
                          <a class="nav-link label-1" asp-controller="Report" asp-action="Index" role="button" data-bs-toggle="" aria-expanded="false">
                          <div class="d-flex align-items-center">
                  <span class="nav-link-icon">
                      <span class="bi bi-file-earmark-spreadsheet-fill"></span>
                  </span>
                              <span class="nav-link-text-wrapper">
                      <span class="nav-link-text">Reports</span>
                  </span>
                          </div>
                          </a>
                      </div>
                  </li> --}}
                {{--   <li class="nav-item">
                       <div class="nav-item-wrapper">
                           <a class="nav-link label-1" asp-controller="Notification" asp-action="Index" role="button" data-bs-toggle="" aria-expanded="false">
                           <div class="d-flex align-items-center">
                   <span class="nav-link-icon">
                       <span class="fa fa-bell"></span>
                   </span>
                               <span class="nav-link-text-wrapper">
                       <span class="nav-link-text">Notifications</span>
                   </span>
                           </div>
                           </a>
                       </div>
                   </li> --}}
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1  {{ Route::is('support.index') ? 'active' : '' }}"
                            href="{{ route('support.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="bi bi-info-circle-fill"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Support</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>

                <li>
                    <p class="navbar-vertical-label">
                        Portal Management
                    </p>
                    <hr class="navbar-vertical-line" />
                </li>
                <li class="nav-item">
                    <div class="nav-item-wrapper">
                        <a class="nav-link label-1 " href="{{ route('account') }}" role="button"
                            data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span class="fa fa-users"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">Portal Users</span>
                                </span>
                            </div>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-0"></span><span
                class="uil uil-arrow-from-right fs-0"></span><span class="navbar-vertical-footer-text ms-2">Collapsed
                View</span>
        </button>
    </div>
</nav>
