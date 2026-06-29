<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\CollectionReportController;
use App\Http\Controllers\Admin\DutyController;
use App\Http\Controllers\Admin\ExchangeSalesReport;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Admin\OutstandingCustomerReportController;
use App\Http\Controllers\Admin\SaleReportController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\StaffvehicleController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\StockhistoryController;
use App\Http\Controllers\Admin\TargetController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\VehiclemanagementController;
use App\Http\Controllers\AiChatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSubcategoryController;
use App\Http\Controllers\TaskController;
use App\Models\ProductSubcategory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('server-commands')->group(function () {
    Route::get('optimize', function () {
        \Artisan::call('optimize');
        \Artisan::call('config:clear');
        \Artisan::call('view:clear');
        dd("Done!");
    });

    Route::get('route-cache', function () {
        \Artisan::call('route:cache');
        dd("Route cache cleared!");
    });

    Route::get('route-clear', function () {
        \Artisan::call('route:clear');
        dd("Route cache cleared!");
    });
});

Route::group(['middleware' => 'admin'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('liveLocation', [DashboardController::class, 'liveLocation'])->name('liveLocation');
    Route::get('liveLocationAjax', [DashboardController::class, 'liveLocationAjax'])->name('liveLocationAjax');

    Route::get('cardView', [DashboardController::class, 'cardView'])->name('cardView');
    Route::get('dashboard/cardViewAjax', [DashboardController::class, 'cardViewAjax'])->name('dashboard/cardViewAjax');

    Route::get('dashboard/getTeamWiseCountAjax', [DashboardController::class, 'getTeamWiseCountAjax'])->name('dashboard.getTeamWiseCountAjax');
    Route::get('dashboard/getRecentCheckInsAjax', [DashboardController::class, 'getRecentCheckInsAjax'])->name('dashboard.getRecentCheckInsAjax');
    Route::get('dashboard/getPresentDataAjax', [DashboardController::class, 'getPresentDataAjax'])->name('dashboard.getPresentDataAjax');
    Route::get('dashboard/getTeamWiseAttendanceAjax', [DashboardController::class, 'getTeamWiseAttendanceAjax'])->name('dashboard.getTeamWiseAttendanceAjax');


    Route::post('dashboard/getTimeLineAjax', [DashboardController::class, 'getTimeLineAjax'])->name('dashboard.getTimeLineAjax');
    Route::get('timeLine', [DashboardController::class, 'timeLine'])->name('timeLine');
    Route::post('timeLine/updateLocationAjax', [DashboardController::class, 'updateLocationAjax'])->name('timeLine.updateLocationAjax');

    //Employee
    Route::get('employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('employee/show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
    Route::get('employee/taskadd/{id}', [EmployeeController::class, 'taskadd'])->name('employee.taskadd');
    Route::post('employee/taskstore', [EmployeeController::class, 'taskstore'])->name('employee.taskstore');
    Route::get('/get-client-balance', [EmployeeController::class, 'getClientBalance'])->name('get-client-balance');
    Route::get('/get-client-details', [EmployeeController::class, 'getClientDetails'])->name('get-client-details');

    Route::post('employee/taskupdatestatus/{id}', [EmployeeController::class, 'updateStatus'])->name('employee.taskupdatestatus');
    Route::delete('employee/tasks/{id}', [EmployeeController::class, 'taskdestroy'])->name('employeetasks.destroy');


    Route::get('employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('employee/changeStatus', [EmployeeController::class, 'changeStatus'])->name('employee.changeStatus');
    Route::get('employee/getGeofenceGroups', [EmployeeController::class, 'getGeofenceGroups'])->name('employee.getGeofenceGroups');
    Route::get('employee/getIpGroups', [EmployeeController::class, 'getIpGroups'])->name('employee.getIpGroups');
    Route::get('employee/getQrGroups', [EmployeeController::class, 'getQrGroups'])->name('employee.getQrGroups');
    //Device
    Route::get('device', [DeviceController::class, 'index'])->name('device.index');
    Route::post('device/revoke/{id}', [DeviceController::class, 'revoke'])->name('device.revoke');

    Route::get('team', [TeamController::class, 'index'])->name('team.index');
    Route::get('team/create', [TeamController::class, 'create'])->name('team.create');
    Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
    Route::post('team/update', [TeamController::class, 'update'])->name('team.update');
    Route::get('team/delete/{id}', [TeamController::class, 'delete'])->name('team.delete');
    Route::post('team/changeStatus', [TeamController::class, 'changeStatus'])->name('team.changeStatus');
    Route::post('team/changeChatStatus', [TeamController::class, 'changeChatStatus'])->name('team.changeChatStatus');


    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('chat/getTeamChat', [ChatController::class, 'getTeamChat'])->name('chat.getTeamChat');
    Route::post('chat/sendMessage', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

    Route::get('shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::get('shift/create', [ShiftController::class, 'create'])->name('shift.create');
    Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::get('shift/destroy/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');
    Route::get('shift/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit');
    Route::post('shift/update', [ShiftController::class, 'update'])->name('shift.update');

    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::get('account/create', [AccountController::class, 'create'])->name('account.create');
    Route::post('account/store', [AccountController::class, 'store'])->name('account.store');
    Route::get('account/edit/{id}', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('account/update/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::get('account/show/{id}', [AccountController::class, 'show'])->name('account.show');
    Route::post('account/changePassword', [AccountController::class, 'changePassword'])->name('account.changePassword');
    Route::get('account/changePassword', [AccountController::class, 'changePasswordView'])->name('account.changePasswordView');
    Route::post('account/changeStatus/{id}', [AccountController::class, 'changeStatus'])->name('account.changeStatus');

    Route::get('holiday', [HolidayController::class, 'index'])->name('holiday.index');
    Route::get('holiday/create', [HolidayController::class, 'create'])->name('holiday.create');
    Route::post('holiday/store', [HolidayController::class, 'store'])->name('holiday.store');
    Route::post('holiday/destroy/{id}', [HolidayController::class, 'destroy'])->name('holiday.destroy');
    Route::get('holiday/edit/{id}', [HolidayController::class, 'edit'])->name('holiday.edit');
    Route::post('holiday/update', [HolidayController::class, 'update'])->name('holiday.update');

    Route::get('visit', [VisitController::class, 'index'])->name('visit.index');
    Route::post('visit/delete/{id}', [VisitController::class, 'destroy'])->name('visit.destroy');

    Route::resource('client', ClientController::class);

    Route::resource('leaveType', LeaveTypeController::class);
    Route::post('leaveType.changeStatus', [LeaveTypeController::class, 'changeStatus'])->name('leaveType.changeStatus');

    Route::resource('expenseType', ExpenseTypeController::class);
    Route::post('expenseType.changeStatus', [ExpenseTypeController::class, 'changeStatus'])->name('expenseType.changeStatus');

    Route::resource('expenseRequest', ExpenseRequestController::class);
    Route::post('expenseRequest.action', [ExpenseRequestController::class, 'action'])->name('expenseRequest.action');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('settings/addons', [SettingsController::class, 'addons'])->name('settings.addons');
    Route::post('settings/updateBasicSettings', [SettingsController::class, 'updateBasicSettings'])->name('settings.updateBasicSettings');
    Route::post('settings/updateDashboardSettings', [SettingsController::class, 'updateDashboardSettings'])->name('settings.updateDashboardSettings');
    Route::post('settings/updateMobileAppSettings', [SettingsController::class, 'updateMobileAppSettings'])->name('settings.updateMobileAppSettings');
    Route::post('settings/updateMapSettings', [SettingsController::class, 'updateMapSettings'])->name('settings.updateMapSettings');
    Route::post('settings/updateAddonStatus', [SettingsController::class, 'updateAddonStatus'])->name('settings.updateAddonStatus');

    Route::get('support', [SupportController::class, 'index'])->name('support.index');

    Route::post('leaveRequest.action', [LeaveRequestController::class, 'action'])->name('leaveRequest.action');

    Route::resource('leaveRequest', LeaveRequestController::class);

    Route::get('products', [ProductController::class, 'list'])->name('productList');
    //Route::prefix('product')->group(function () {
    //Route::resource('product', ProductController::class);
    //});
    Route::get('product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('store',[ProductController::class,'store'])->name('product.store');
    
    Route::get('/product/{product}',[ProductController::class,'show'])->name('product.show');
    
    Route::get('/product/{product}/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::post('update',[ProductController::class,'update'])->name('product.update');
    Route::delete('/product/{id}',[ProductController::class,'destroy'])->name('product.destroy');
    
    Route::post('product.changeStatus', [ProductController::class, 'changeStatus'])->name('product.changeStatus');
    Route::resource('productcategory', ProductCategoryController::class)->parameter('productcategory', 'productCategory');
    Route::post('productcategory.changeStatus', [ProductCategoryController::class, 'changeStatus'])->name('productcategory.changeStatus');

    Route::resource('productsubcategory', ProductSubcategoryController::class);
    Route::get('/get-subcategories/{categoryId}', [ProductSubcategoryController::class, 'getSubcategories'])->name('get.subcategories');

    Route::post('productsubcategory.changeStatus', [ProductSubcategoryController::class, 'changeStatus'])->name('productsubcategory.changeStatus');

    Route::get('/get-subcategories', [ClientController::class, 'getSubcategories'])->name('getSubcategories');
    Route::get('/get-products', [ClientController::class, 'getProducts'])->name('getProducts');
    Route::get('/get-product-price', [ClientController::class, 'getProductPrice'])->name('getProductPrice');



    Route::resource('loan', LoanController::class);
    Route::post('loan.changeStatus', [LoanController::class, 'changeStatus'])->name('loan.changeStatus');

    Route::resource('bank', BankController::class);
    Route::post('bank.changeStatus', [BankController::class, 'changeStatus'])->name('bank.changeStatus');

    Route::resource('task', TaskController::class);
    Route::post('task.changeStatus', [TaskController::class, 'changeStatus'])->name('task.changeStatus');


    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::post('report/getAttendanceReport', [ReportController::class, 'getAttendanceReport'])->name('report.getAttendanceReport');
    Route::post('report/getVisitReport', [ReportController::class, 'getVisitReport'])->name('report.getVisitReport');
    Route::post('report/getLeaveReport', [ReportController::class, 'getLeaveReport'])->name('report.getLeaveReport');
    Route::post('report/getExpenseReport', [ReportController::class, 'getExpenseReport'])->name('report.getExpenseReport');

    Route::post('aiChat/sendMessage', [AiChatController::class, 'sendMessage'])->name('aiChat.sendMessage');

    Route::resource('sale', SalesController::class);
    Route::resource('collections', CollectionController::class)->parameter('collections', 'collection');
    Route::post('collections/{collection}/transactions', [CollectionController::class, 'storeTransaction'])->name('collections.transactions.store');
    Route::delete('collection-transactions/{transaction}', [CollectionController::class, 'destroyTransaction'])->name('collections.transactions.destroy');
    Route::get('productAmount', [SalesController::class, 'productAmount'])->name('productAmount');
    Route::get('add/advance/{sale}', [SalesController::class, 'getaddadvance'])->name('getaddadvance');
    Route::post('store/advance/{sale}', [SalesController::class, 'addadvance'])->name('storeaddadvance');
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::resource('staffvehicle', StaffvehicleController::class)->only('index', 'edit', 'update', 'destroy');
        Route::resource('task', DutyController::class)->parameter('task', 'duty');
        Route::get('updateTaskStatus', [DutyController::class, 'updateTaskStatus'])->name('updateTaskStatus');
        Route::resource('salereport', SaleReportController::class)->parameter('salereport', 'sale');
        Route::resource('exchangesale', ExchangeSalesReport::class)->parameter('exchangesale', 'sale');
        Route::post('salereport/export', [SaleReportController::class, 'export'])->name('salereport.export');
        Route::post('exchangesale/export', [ExchangeSalesReport::class, 'export'])->name('exchangesale.export');
        Route::get('outstanding-report', [OutstandingCustomerReportController::class, 'index'])->name('outstandingreport.index');
        Route::post('outstanding-report/export', [OutstandingCustomerReportController::class, 'export'])->name('outstandingreport.export');
        Route::resource('vehicle', VehicleController::class)->except('show', 'destroy');
        Route::get('updateVehicleStatus', [VehicleController::class, 'updateVehicleStatus'])->name('updateVehicleStatus');
        Route::resource('vehiclemanagement', VehiclemanagementController::class)->except('show');
        Route::resource('brand', BrandController::class)->except('show');
        Route::get('brands-category', [BrandController::class, 'brandscategory'])->name('brandscategory');
        Route::resource('stock', StockController::class)->only('index');
        Route::resource('stockhistory', StockhistoryController::class)->only('index', 'create', 'store');
        Route::resource('payroll', PayrollController::class)->only('index');
        Route::resource('lead', LeadController::class)->only('index', 'create');
        Route::resource('target', TargetController::class)->only('index', 'create', 'store');
        Route::get('productdetails', [TargetController::class, 'productdetails'])->name('productdetails');
        Route::get('checktarget', [TargetController::class, 'checktarget'])->name('checktarget');
        Route::get('team-members', [TeamController::class, 'getMembers'])->name('teamMembers');
    });
    Route::get('completeSale', [SalesController::class, 'CompleteSale'])->name('completeSale');
    Route::get('clientDetails', [DutyController::class, 'clientDetails'])->name('clientDetails');
    Route::get('getAmount', [DutyController::class, 'getAmount'])->name('getAmount');
});
Route::get('auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::group(['as' => 'auth.', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
