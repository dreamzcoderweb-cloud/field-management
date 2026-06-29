@php
    use App\Classes\AddonHelper;
    $title = 'Addons';
    $addonHelper = new AddonHelper();
    $allAddons = $addonHelper->getAllModulesWithVersion();

    //Addon Status

    $isDocumentAddonInstalled =  $addonHelper->isDocumentModuleInstalled();
    $isDocumentAddonEnabled =  $addonHelper->isDocumentModuleEnabled();

    $isNoticeAddonEnabled =  $addonHelper->isNoticeModuleEnabled();
    $isNoticeAddonInstalled =  $addonHelper->isNoticeModuleInstalled();

    $isProductOrderAddonEnabled =  $addonHelper->isProductOrderModuleEnabled();
    $isProductOrderAddonInstalled =  $addonHelper->isProductOrderModuleInstalled();

    $isDynamicFormAddonEnabled =  $addonHelper->isDynamicFormModuleEnabled();
    $isDynamicFormAddonInstalled =  $addonHelper->isDynamicFormModuleInstalled();

    $isTaskAddonEnabled =  $addonHelper->isTaskModuleEnabled();
    $isTaskAddonInstalled =  $addonHelper->isTaskModuleInstalled();

    $isLoanAddonEnabled =  $addonHelper->isLoanModuleEnabled();
    $isLoanAddonInstalled =  $addonHelper->isLoanModuleInstalled();

    $isPaymentCollectionAddonEnabled =  $addonHelper->isPaymentCollectionModuleEnabled();
    $isPaymentCollectionAddonInstalled =  $addonHelper->isPaymentCollectionModuleInstalled();

    $isOfflineTrackingAddonEnabled =  $addonHelper->isOfflineTrackingModuleEnabled();
    $isOfflineTrackingAddonInstalled =  $addonHelper->isOfflineTrackingModuleInstalled();

    $isGeoFenceAddonEnabled =  $addonHelper->isGeofenceAttendanceModuleEnabled();
    $isGeoFenceAddonInstalled =  $addonHelper->isGeofenceAttendanceModuleInstalled();

    $isIpAttendanceAddonEnabled =  $addonHelper->isIpAttendanceModuleEnabled();
    $isIpAttendanceAddonInstalled =  $addonHelper->isIpAttendanceModuleInstalled();

    $isUidLoginAddonEnabled =  $addonHelper->isUidLoginModuleEnabled();
    $isUidLoginAddonInstalled =  $addonHelper->isUidLoginModuleInstalled();

    $isSiteAttendanceAddonEnabled =  $addonHelper->isSiteModuleEnabled();
    $isSiteAttendanceAddonInstalled =  $addonHelper->isSiteModuleInstalled();

    $isQrCodeAttendanceAddonEnabled =  $addonHelper->isQrAttendanceModuleEnabled();
    $isQrCodeAttendanceAddonInstalled =  $addonHelper->isQrAttendanceModuleInstalled();

    $isBreakAddonEnabled =  $addonHelper->isBreakModuleEnabled();
    $isBreakAddonInstalled =  $addonHelper->isBreakModuleInstalled();

    $isClientVisitAddonEnabled =  $addonHelper->isClientVisitModuleEnabled();

    $isChatAddonEnabled =  $addonHelper->isChatModuleEnabled();

    $isLeaveAddonEnabled =  $addonHelper->isLeaveModuleEnabled();

    $isExpenseAddonEnabled =  $addonHelper->isExpenseModuleEnabled();

    $isBiometricAddonEnabled =  $addonHelper->isBiometricModuleEnabled();
@endphp
@section('title')
    {{$title}}
@endsection
@extends('layout')
@section('main-content')
    <div class="row mb-3">
        <div class="col">
            <div class="float-start">
                <h4 class="mt-2">{{$title}}</h4>
            </div>
        </div>
        <div class="col">
        </div>
    </div>
    <div class="mb-2">
        <div class="alert alert-outline-warning d-flex align-items-center" role="alert">
            <span class="fas fa-info-circle text-warning me-3"></span>
            <p class="mb-0 flex-1 fw-bold">We have over 16+ premium modules</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>{{--
        {{json_encode($addonHelper->getAllModuleStatus())}}
        <br>
        <hr>
        <h5>getAllModulesWithVersion</h5>
        {{json_encode($addonHelper->getAllModulesWithVersion(),JSON_PRETTY_PRINT)}}
        <br>
        <hr>
        <h5>Modules</h5>
        {{json_encode(Module::all())}}--}}
        <div class="row">
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isDocumentAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Document Management</h3>
                        <p class="text-body-tertiary fw-semibold">Create and manage document types and requests from
                            employees.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isDocumentAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::documentRequestAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('document')" {{$isDocumentAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->documentManagementVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::documentRequestAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isProductOrderAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Product &amp; Order System</h3>
                        <p class="text-body-tertiary fw-semibold">Create and manager products categories, products and
                            employee can place order against a client.</p>
                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isProductOrderAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::productOrderAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('product')" {{$isProductOrderAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->productOrderModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::productOrderAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isDynamicFormAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Custom Forms</h3>
                        <p class="text-body-tertiary fw-semibold">Create a custom forms with unlimited fields and
                            options(text,number,dropdown,yes,no) and assign to employees to collect data.</p>
                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isDynamicFormAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::dynamicFormAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('dynamicForm')" {{$isDynamicFormAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->dynamicFormsVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::dynamicFormAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isTaskAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Task System</h3>
                        <p class="text-body-tertiary fw-semibold">Create location based tasks and assign to employees.
                            Employee can start, hold and update task details.</p>
                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isTaskAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::taskSystemAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('task')" {{$isTaskAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->taskSystemVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::taskSystemAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isNoticeAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Notice Board</h3>
                        <p class="text-body-tertiary fw-semibold">Create and manage document types and requests from
                            employees.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isNoticeAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::noticeBoardAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('notice')" {{$isNoticeAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->noticeModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::noticeBoardAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isLoanAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Loan Management</h3>
                        <p class="text-body-tertiary fw-semibold">Employee loan management and approvals.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isLoanAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::loanAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('loan')" {{$isLoanAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->loanManagementVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::loanAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isPaymentCollectionAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Payment Collection</h3>
                        <p class="text-body-tertiary fw-semibold">Payment Collection entries from field employees.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isPaymentCollectionAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::paymentCollectionAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('paymentCollection')" {{$isPaymentCollectionAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->paymentCollectionModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::paymentCollectionAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isOfflineTrackingAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Offline Tracking</h3>
                        <p class="text-body-tertiary fw-semibold">Offline Tracking for employee mobile application.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isOfflineTrackingAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::offlineTrackingAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('offlineTracking')" {{$isOfflineTrackingAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->offlineTrackingModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::offlineTrackingAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isGeoFenceAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Geofence System</h3>
                        <p class="text-body-tertiary fw-semibold">Create geofence group and add locations under it and
                            assign it to employees for Geofence based attendance.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isGeoFenceAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::geofenceAttendanceAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('geofence')" {{$isGeoFenceAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->geofenceSystemModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::geofenceAttendanceAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isIpAttendanceAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">IP Based Attendance</h3>
                        <p class="text-body-tertiary fw-semibold">Create IP address group and add ip addresses under it
                            and assign it to employees for IP Address Based Attendance.</p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isIpAttendanceAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::ipAttendanceAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('ipAttendance')" {{$isIpAttendanceAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->ipAddressModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::ipAttendanceAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isUidLoginAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">UID Based Login</h3>
                        <p class="text-body-tertiary fw-semibold">Login employees based on device UID. <strong>Supports
                                Android &amp; IOS.</strong></p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isUidLoginAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::uidLoginAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('uidLogin')" {{$isUidLoginAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->uidLoginModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::uidLoginAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isSiteAttendanceAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Sites & Attendances</h3>
                        <p class="text-body-tertiary fw-semibold">Create client sites and enable qr code, geofence, and
                            ip address based attendance based on a site. </p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isSiteAttendanceAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::siteAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('site')" {{$isSiteAttendanceAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->siteModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::siteAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isQrCodeAttendanceAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Static QR Code Based Attendance</h3>
                        <p class="text-body-tertiary fw-semibold">Static QR Code based attendance for site based
                            attendances. </p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isQrCodeAttendanceAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::qrAttendanceAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('qrAttendance')" {{$isQrCodeAttendanceAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->qrAttendanceModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::qrAttendanceAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-3 pt-3">
                <div
                    class="card border {{$isBreakAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                    <div class="card-body px-5 position-relative">
                        <h3 class="mb-5">Break System</h3>
                        <p class="text-body-tertiary fw-semibold">Enable disable breaks for employees. </p>

                        <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                            <span class="fw-bold">Premium Addon</span>
                            <span class="fa-solid fa-award ms-1"></span>
                        </div>
                        @if (!$isBreakAddonInstalled)
                            <div class="row text-center">
                                <p>Module not installed</p>
                                <a class="btn btn-block btn-phoenix-success me-1 mb-1  text-center"
                                   href="{{Constants::breakAddonBuyNowLink}}" target="_blank">Buy
                                    Now</a>
                            </div>
                        @else
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('break')" {{$isBreakAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                            <div class="card shadow p-2">
                                <div class="row mt-2">
                                    <div class="col">
                                        <p class="text-body-tertiary fw-semibold"><i class="fa fa-bolt"></i> Addon
                                        </p>
                                    </div>
                                    <div class="col text-end">
                                        <p class="text-body-tertiary fw-semibold">
                                            {{$addonHelper->breakSystemModuleVersion()}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (env('DEMO_MODE'))
                        <a class="btn btn-block btn-phoenix-success me-1 ms-1 mb-1  text-center"
                           href="{{Constants::breakAddonBuyNowLink}}" target="_blank">Buy Now</a>

                    @endif
                    <div class="card-footer border-0 py-0 px-5 z-1">
                        <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Free addons-->
    <div class="mb-2">
        <div class="d-flex mb-5 pt-8">
     <span class="fa-stack me-2 ms-n1">
         <i class="fas fa-circle fa-stack-2x text-primary"></i>
         <i class="fa-inverse fa-stack-1x text-primary-subtle fas fa-percentage"></i>
     </span>
            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold">
                    <span class="bg-body pe-2">Included Addons</span>

                </h3>
                <p class="mb-0">12+ included Addons.</p>
            </div>
        </div>
        <div class="px-3 mb-3">
            <div class="row">
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div
                        class="card border {{$isClientVisitAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Client Visits</h3>
                            <p class="text-body-tertiary fw-semibold">Mark client visits with location information and
                                proof and you can generate excel reports for visits as well. </p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('clientVisit')" {{$isClientVisitAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-0 px-5 z-1">
                            <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                    href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div
                        class="card border {{$isChatAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Chat System</h3>
                            <p class="text-body-tertiary fw-semibold">Chat with teammates, supports text, image.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('chat')" {{$isChatAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-0 px-5 z-1">
                            <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                    href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div
                        class="card border {{$isLeaveAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Leave Management</h3>
                            <p class="text-body-tertiary fw-semibold">Employee leave request management and
                                approvals.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('leave')" {{$isLeaveAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-0 px-5 z-1">
                            <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                    href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div
                        class="card border {{$isExpenseAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Expense Management</h3>
                            <p class="text-body-tertiary fw-semibold">Employee expense request management and
                                approvals.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('expense')" {{$isExpenseAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-0 px-5 z-1">
                            <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                    href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div
                        class="card border {{$isBiometricAddonEnabled ? "border-success" : "border-danger"}} h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Biometric verification for In Out</h3>
                            <p class="text-body-tertiary fw-semibold">Employee has to verify with fingerprint / face id
                                to check in and out.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox"
                                       onchange="updateAddonStatus('biometricVerification')" {{$isBiometricAddonEnabled ? 'checked' : '' }}/>
                                <label class="form-check-label" for="IsDocumentModuleEnabled">Status</label>
                            </div>
                        </div>
                        <div class="card-footer border-0 py-0 px-5 z-1">
                            <p class="text-body-tertiary fw-semibold">View Tutorial on how to use this feature <a
                                    href="#">Click here </a>at <br class="d-none d-xxl-block"/>Youtube.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Monitoring Tools</h3>
                            <p class="text-body-tertiary fw-semibold">Card View, Map Live Location View, Time Line
                                View.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Device Verification System</h3>
                            <p class="text-body-tertiary fw-semibold">Employee device registration and verification
                                system based on UID. <strong>Supports Android &amp; IOS.</strong></p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Teams</h3>
                            <p class="text-body-tertiary fw-semibold">Create teams and add employees under it for chats
                                and more.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Shift Management</h3>
                            <p class="text-body-tertiary fw-semibold">Create many shifts and assign to employees.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Holiday Management</h3>
                            <p class="text-body-tertiary fw-semibold">Create and manage holidays.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Client Management</h3>
                            <p class="text-body-tertiary fw-semibold">Create clients.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Attendance Management</h3>
                            <p class="text-body-tertiary fw-semibold">Check in out and tracking.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Realtime Tracking System</h3>
                            <p class="text-body-tertiary fw-semibold">Employee realtime tracking <strong>Supports
                                    Android &amp; IOS</strong>.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Realtime Notification System</h3>
                            <p class="text-body-tertiary fw-semibold">All types of notifications.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-success mb-4">
                                <span class="fw-bold">Included</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End free addon-->
    <div class="mb-3">
        <div class="d-flex mb-5 pt-8">
      <span class="fa-stack me-2 ms-n1">
          <i class="fas fa-circle fa-stack-2x text-primary"></i>
          <i class="fa-inverse fa-stack-1x text-primary-subtle fas fa-percentage"></i>
      </span>
            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold">
                    <span class="bg-body pe-2">Upcoming Modules</span>

                </h3>
                <p class="mb-0">more useful modules coming soon.</p>
            </div>
        </div>
        <div class="px-3 mb-3">
            <div class="row">
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Data Import / Export</h3>
                            <p class="text-body-tertiary fw-semibold">Excel import of Employees, Sales target, teams,
                                shifts, holidays, products, categories.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Dynamic QR Code Based Attendance</h3>
                            <p class="text-body-tertiary fw-semibold">EDynamic QR Code based attendance for site based
                                attendances.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Sales Targets</h3>
                            <p class="text-body-tertiary fw-semibold">Set Monthly sales targets for employees.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Facial Recognition based attendance</h3>
                            <p class="text-body-tertiary fw-semibold">Check in / out using employees face.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">SOS</h3>
                            <p class="text-body-tertiary fw-semibold">SOS alert for emergency situations.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Contract Management &amp; Staffs</h3>
                            <p class="text-body-tertiary fw-semibold">Create and manage contracts for clients and add
                                employees under it.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Digital ID Card</h3>
                            <p class="text-body-tertiary fw-semibold">Employee can access their official digital ID from
                                mobile app.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">Ai Chat</h3>
                            <p class="text-body-tertiary fw-semibold">Ai Chat in admin panel <strong>Powered by
                                    ChatGPT</strong>.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">CZ HR Core Integration</h3>
                            <p class="text-body-tertiary fw-semibold">Sync employees, shifts, leaves, expense,
                                attendance and clients and more to our HRMS Solution.</p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-xxl-3 pt-3">
                    <div class="card border border-success h-100 w-100 overflow-hidden shadow-lg">
                        <div class="card-body px-5 position-relative">
                            <h3 class="mb-5">More coming soon...</h3>
                            <p class="text-body-tertiary fw-semibold"></p>

                            <div class="badge badge-phoenix fs-10 badge-phoenix-warning mb-4">
                                <span class="fw-bold">Coming Soon</span>
                                <span class="fa-solid fa-award ms-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateAddonStatus(status) {
            $.ajax({
                url: '{{route('settings.updateAddonStatus')}}',
                type: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    addon: status
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        notyf.success('Addon status updated successfully');
                        location.reload();
                    } else if (response.status === 'error') {
                        notyf.error(response.message);
                    } else {
                        notyf.error('Something went wrong');
                    }
                }
                ,
                error: function (error) {
                    console.log(error);
                }
            });
        }

    </script>
@endsection
