<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\LedgerController;
use App\Http\Controllers\Api\OutstandingClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\StaffvehicleController;
use App\Http\Controllers\Api\TargetController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisitController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'V1'], function () {
    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
    ], function ($router) {
        Route::get('test', [AuthController::class, 'test'])->name('test');
        Route::post('checkPhoneNumber', [AuthController::class, 'checkPhoneNumber'])->name('checkPhoneNumber');
        Route::post('checkUsername', [AuthController::class, 'checkUserName'])->name('checkUsername');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('loginWithUid', [AuthController::class, 'loginWithUid'])->name('loginWithUid');
        Route::post('changePassword', [AuthController::class, 'changePassword'])->name('changePassword');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
    ], function ($router) {
        Route::get('getLeaveTypes', [LeaveController::class, 'getLeaveTypes'])->name('getLeaveTypes');
        Route::post('createLeaveRequest', [LeaveController::class, 'createLeaveRequest'])->name('createLeaveRequest');
        Route::get('getLeaveRequests', [LeaveController::class, 'getLeaveRequests'])->name('getLeaveRequests');
        Route::post('uploadLeaveDocument', [LeaveController::class, 'uploadLeaveDocument'])->name('uploadLeaveDocument');
        Route::post('deleteLeaveRequest', [LeaveController::class, 'deleteLeaveRequest'])->name('deleteLeaveRequest');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'attendance'
    ], function ($router) {
        Route::get('checkStatus', [AttendanceController::class, 'checkStatus'])->name('checkStatus');
        Route::post('checkInOut', [AttendanceController::class, 'checkInOut'])->name('checkInOut');
        Route::post('statusUpdate', [AttendanceController::class, 'statusUpdate'])->name('statusUpdate');
        Route::get('canCheckOut', [AttendanceController::class, 'canCheckOut'])->name('canCheckOut');
        Route::post('setEarlyCheckoutReason', [AttendanceController::class, 'setEarlyCheckoutReason'])->name('setEarlyCheckoutReason');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
    ], function ($router) {

        Route::get('checkDevice', [DeviceController::class, 'checkDevice'])->name('checkDevice');
        Route::post('registerDevice', [DeviceController::class, 'registerDevice'])->name('registerDevice');
        Route::post('messagingToken', [DeviceController::class, 'messagingToken'])->name('messagingToken');
        Route::post('updateDeviceStatus', [DeviceController::class, 'updateDeviceStatus'])->name('updateDeviceStatus');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
    ], function ($router) {
        Route::get('getDashboardData', [UserController::class, 'getDashboardData'])->name('getDashboardData');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'settings'
    ], function ($router) {
        Route::get('getAppSettings ', [SettingsController::class, 'getAppSettings'])->name('getAppSettings');
        Route::get('getModuleSettings', [SettingsController::class, 'getModuleSettings'])->name('getModuleSettings');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'visit'
    ], function ($router) {
        Route::post('create ', [VisitController::class, 'create'])->name('create');
        Route::get('getVisitsCount', [VisitController::class, 'getVisitsCount'])->name('getVisitsCount');
        Route::get('getHistory', [VisitController::class, 'getHistory'])->name('getHistory');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'chat'
    ], function ($router) {
        Route::post('postChat ', [ChatController::class, 'postChat'])->name('postChat');
        Route::get('getChats', [ChatController::class, 'getChats'])->name('getChats');
        Route::post('postImageChat', [ChatController::class, 'postImageChat'])->name('postImageChat');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'client'
    ], function ($router) {
        Route::get('getAllClients ', [ClientController::class, 'getAllClients'])->name('getAllClients');
        Route::post('create', [ClientController::class, 'create'])->name('create');
        Route::get('search', [ClientController::class, 'search'])->name('search');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
    ], function ($router) {
        Route::resource('task', TaskController::class)->parameter('task', 'duty')->only('index', 'edit', 'update');
        Route::resource('product', ProductController::class)->only('index', 'show');
        Route::resource('lead', LeadController::class)->only('index', 'store', 'update');
        Route::resource('target', TargetController::class)->only('index');
        Route::resource('staffvehicle', StaffvehicleController::class)->only('index', 'store');
        Route::resource('outstandingclient', OutstandingClientController::class)->only('index', 'show', 'create')->parameter('outstandingclient', 'client');
        Route::resource('ledger', LedgerController::class)->only('index');
        Route::resource('sale', SaleController::class)->only('index', 'create', 'store');
    });

    Route::group([
        'middleware' => 'api',
        'as' => 'api.',
        'prefix' => 'expense'
    ], function ($router) {
        Route::get('getExpenseTypes ', [ExpenseController::class, 'getExpenseTypes'])->name('getExpenseTypes');
        Route::post('createExpenseRequest', [ExpenseController::class, 'createExpenseRequest'])->name('createExpenseRequest');
        Route::get('getExpenseRequests', [ExpenseController::class, 'getExpenseRequests'])->name('getExpenseRequests');
        Route::post('uploadExpenseDocument', [ExpenseController::class, 'uploadExpenseDocument'])->name('uploadExpenseDocument');
        Route::post('deleteExpenseRequest', [ExpenseController::class, 'deleteExpenseRequest'])->name('deleteExpenseRequest');
    });
});
