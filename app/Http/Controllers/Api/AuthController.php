<?php

namespace App\Http\Controllers\Api;

use App\Api\Shared\Responses\Error;
use App\Api\Shared\Responses\Success;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Carbon\Carbon;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'loginWithUid', 'register', 'checkUserName', 'checkPhoneNumber']]);
    }

    public function login(Request $request)
    {
        $employeeId = $request->employeeId;

        $password = $request->password;

        if ($employeeId == null || $employeeId == '') {
            return Error::response('Employee Id is required');
        }

        if (strlen($employeeId) < 6) {
            return Error::response('Employee Id must be at least 6 characters');
        }

        if ($password == null || $password == '') {
            return Error::response('Password is required');
        }
        if (strlen($password) < 6) {
            return Error::response('Password must be at least 6 characters');
        }

        $isManager = $request->isManager ?? false;

        $user = User::where('user_name', $request->employeeId)
            ->with('roles')
            ->first();

        if ($user == null) {
            return Error::response('User not found.');
        }

        if ($user->status != 'active') {
            return Error::response('User is inactive.');
        }

        $userRole = $user->roles()->first();

        if ($userRole == null) {
            return Error::response('You are not authorized to login.');
        }

        if (!$isManager && $userRole->slug != 'user') {
            return Error::response('You are not authorized to login.');
        }

        if ($isManager && $userRole->slug != 'manager') {
            return Error::response('You are not authorized to login.');
        }

        if (!(new BcryptHasher)->check($request->input('password'), $user->password)) {
            return Error::response('Email or password is incorrect. Authentication failed.');
        }

        $credentials = ['email' => $user->email, 'password' => $request->password];
        try {
            JWTAuth::factory()->setTTL(40320); // Expired Time 28days
            if (!$token = JWTAuth::attempt($credentials, ['exp' => Carbon::now()->addDays(28)->timestamp])) {
                return Error::response('Invalid Credentials');
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        //return response()->json(['user' => $user,'token'=>$token,'status'=>200], 200);

        $response = [
            'token' => $token,
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'emailId' => $user->email,
            'employeeId' => $user->user_name,
            'phoneNumber' => $user->phone_number,
            'Gender' => 'male',
            'Avatar' => $user->profile_picture ?? '',
            'status' => $user->status,
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response
        ], 200);
    }

    public function loginWithUid(Request $request)
    {
        $input = $request->all();
        if ($input == null || $input == '' || count($input) == 0) {
            return Error::response('Invalid request');
        }

        $uid = $input[0];

        if ($uid == null || $uid == '') {
            return Error::response('uid is required');
        }

        $device = UserDevice::where('device_id', $uid)->first();

        if ($device == null) {
            return Error::response('Device not found');
        }

        $user = User::where('id', $device->user_id)
            ->with('roles')
            ->first();

        if ($user == null) {
            return Error::response('User not found.');
        }

        if ($user->status == 'inactive') {
            return Error::response('User is inactive.');
        }

        $userRole = $user->roles()->first();

        if ($userRole == null || $userRole->slug != 'user') {
            return Error::response('You are not authorized to login.');
        }
        try {
            JWTAuth::factory()->setTTL(40320); // Expired Time 28days
            if (!$token = JWTAuth::fromUser($user, ['exp' => Carbon::now()->addDays(28)->timestamp])) {
                return Error::response('Unable to create token');
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $response = [
            'token' => $token,
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'emailId' => $user->email,
            'employeeId' => $user->user_name,
            'phoneNumber' => $user->phone_number,
            'Gender' => 'male',
            'Avatar' => $user->profile_picture ?? '',
            'status' => $user->status,
        ];

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'data' => $response
        ], 200);
    }

    public function checkPhoneNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string'
        ]);

        if ($validator->fails()) {
            return Error::response('Invalid request');
        }

        if (User::where('phone_number', '=', $request->phoneNumber)->exists()) {
            return Success::response('Number Exists');
        } else {
            return Error::response('Number not found');
        }
    }

    public function checkUserName(Request $request)
    {
        $userName = $request->all();
        if ($userName == null) {
            return Error::response('Invalid request');
        }

        $user = User::where('user_name', '=', $userName)
            ->with('roles')
            ->first();

        if ($user == null) {
            return Error::response('Username not found');
        }

        $role = $user->roles()->first();

        if ($role == null || ($role->slug != 'user' && $role->slug != 'manager')) {
            return Error::response('Username not found');
        }

        return Success::response('Username Exists');
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function changePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return Error::response($validator->messages());
        }

        $user = User::find(auth()->user()->id);

        if ($user == null) {
            return Error::response('User not found');
        }

        if (!(new BcryptHasher)->check($request->input('oldPassword'), $user->password)) {
            return Error::response('Old password is incorrect.');
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return Success::response('Password changed successfully');

    }

    /*
        public function refresh()
        {
            return response()->json([
                'status' => 'success',
                'user' => auth::user(),
                'authorisation' => [
                    'token' => auth::refresh(),
                    'type' => 'bearer',
                ]
            ]);
        }*/

    public function test()
    {
        return Success::response('Test');
    }
}
