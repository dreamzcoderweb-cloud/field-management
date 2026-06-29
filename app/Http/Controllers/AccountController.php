<?php

namespace App\Http\Controllers;

use App\Classes\ViewHelper;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use Sentinel;

class AccountController extends Controller
{
    public function index()
    {
        $viewHelper = new ViewHelper();

        $adminRole = Sentinel::findRoleBySlug('admin');

        $admins = $adminRole->users()->with('roles')->get();

        $managerRole = Sentinel::findRoleBySlug('manager');

        $managers = $managerRole->users()->with('roles')->get();

        $users = $admins->merge($managers);

        return view('account.index', compact('users'));
    }

    public function changePasswordView()
    {
        return view('account.changePassword');
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'oldPassword' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ];


        if (env('DEMO_MODE')) {
            return redirect()->route('account')->with('error', 'You can not change status in demo mode');
        }

        $this->validate($request, $rules);

        $user = Sentinel::getUser();

        if (Sentinel::validateCredentials($user, ['password' => request('oldPassword')])) {
            $user->password = bcrypt(request('password'));
            $user->save();

            return redirect()->route('index')->with('success', 'Password changed successfully');
        } else {
            return redirect()->back()->with('error', 'Old password is incorrect');
        }
    }

    public function create()
    {
        $viewHelper = new ViewHelper();

        $roles = $viewHelper->getAdminRoles();

        return view('account.create', compact('roles'));
    }

    public function store()
    {
        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'userName' => 'required|unique:users,user_name',
            'email' => 'required|unique:users',
            'designation' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
            'roleId' => 'required',
            'gender' => 'required',
            'phoneNumber' => 'required|unique:users,phone_number',
        ];

        $this->validate(request(), $rules);

        $user = [
            'first_name' => request('firstName'),
            'last_name' => request('lastName'),
            'user_name' => request('userName'),
            'email' => request('email'),
            'designation' => request('designation'),
            'gender' => request('gender'),
            'phone_number' => request('phoneNumber'),
            'password' => bcrypt(request('password')),
        ];

        $createdUser = User::create($user);

        $sentinelUser = Sentinel::findById($createdUser->id);

        //Activate the user
        $activation = Activation::create($sentinelUser);
        Activation::complete($sentinelUser, $activation->code);

        $role = Sentinel::findRoleById(request('roleId'));

        $role->users()->attach($createdUser);

        return redirect()->route('account')->with('success', 'Account created successfully');
    }

    public function edit($id)
    {
        $viewHelper = new ViewHelper();

        $roles = $viewHelper->getAdminRoles();

        $user = User::with('roles')->find($id);

        return view('account.edit', compact('user', 'roles'));
    }

    public function changeStatus($id)
    {
        $user = User::find($id);

        if (env('DEMO_MODE')) {
            return redirect()->route('account.show', ['id' => $id])->with('error', 'You can not change status in demo mode');
        }

        if ($user->user_name == 'adminuser') {
            return redirect()->route('account.show', ['id' => $id])->with('error', 'You can not change status of this account');
        }

        if ($user->status == 'active') {
            $user->status = 'inactive';
        } else {
            $user->status = 'active';
        }

        $user->save();

        return redirect()->route('account.show', ['id' => $id])->with('success', 'Account status changed successfully');
    }


    public function update(Request $request, $id)
    {

        if (env('DEMO_MODE')) {
            return redirect()->route('account.show', ['id' => $id])->with('error', 'You can not change status in demo mode');
        }

        $rules = [
            'firstName' => 'required',
            'lastName' => 'required',
            'gender' => 'required',
            'phoneNumber' => 'required|unique:users,phone_number,' . $id,
            'designation' => 'required',
            'email' => 'required|unique:users,email,' . $id,
        ];

        $this->validate($request, $rules);

        $user = User::find($id);

        if ($user->email != $request->email) {
            $user->email = $request->email;
        }

        if ($user->phone_number != $request->phoneNumber) {
            $user->phone_number = $request->phoneNumber;
        }

        if ($user->designation != $request->designation) {
            $user->designation = $request->designation;
        }


        if ($user->first_name != $request->firstName) {
            $user->first_name = $request->firstName;
        }

        if ($user->last_name != $request->lastName) {
            $user->last_name = $request->lastName;
        }

        if ($user->gender != $request->gender) {
            $user->gender = $request->gender;
        }

        $user->save();

        return redirect()->route('account')->with('success', 'Account updated successfully');

    }

    public function show($id)
    {
        $user = User::find($id);

        return view('account.show', compact('user'));
    }
}
