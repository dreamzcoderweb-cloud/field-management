<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\GeofenceGroup;
use App\Models\IpAddressGroup;
use App\Models\QRCodeGroup;
use App\Models\Settings;
use App\Models\Shift;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
// use Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class EmployeeController extends Controller
{
    public function index()
    {
        $role = Sentinel::findRoleBySlug('user');

        $employeeIds = $role->users()->with('roles')
            ->select('id')
            ->get();

        $ids = array_column($employeeIds->toArray(), 'id');

        $employees = User::whereIn('id', $ids)
            ->with('team')
            ->get();

        app('debugbar')->info($role);

        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $managerRole = Sentinel::findRoleBySlug('manager');

        $managers = $managerRole->users()->with('roles')
            ->select('id', 'first_name', 'last_name')
            ->get();

        $shifts = Shift::where('status', '=', 'active')
            ->select('id', 'title')
            ->get();

        $teams = Team::where('status', '=', 'active')
            ->select('id', 'name')
            ->get();

        return view('employee.create', compact('managers', 'shifts', 'teams'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)
            ->with('team')
            ->with('shift')
            ->with('userDevice')
            ->first();

        $managerName = User::where('id', $user->parent_id)
            ->select('first_name', 'last_name')
            ->first();

        return view('employee.show', compact('user', 'managerName'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $managerRole = Sentinel::findRoleBySlug('manager');

        $managers = $managerRole->users()->with('roles')
            ->select('id', 'first_name', 'last_name')
            ->get();

        $managers = $managerRole->users()->with('roles')
            ->select('id', 'first_name', 'last_name')
            ->get();

        $shifts = Shift::where('status', '=', 'active')
            ->select('id', 'title')
            ->get();

        $teams = Team::where('status', '=', 'active')
            ->select('id', 'name')
            ->get();
        return view('employee.edit', compact('user', 'managers', 'shifts', 'teams'));
    }

    public function update(Request $request, $id)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('employee.show', ['id' => $id])->with('error', 'You can not change status in demo mode');
        }
        $rules = [
            'email' => 'email|unique:users,email,' . $id,
            'phoneNumber' => 'required|unique:users,phone_number,' . $id,

            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'parentId' => 'required',
            'shiftId' => 'required',
            'teamId' => 'required',
            'designation' => 'required',
        ];

        $customMessages = [
            'parentId.required' => 'Manager is required',
            'shiftId.required' => 'Shift is required',
            'teamId.required' => 'Team is required',
        ];

        $this->validate($request, $rules, $customMessages);

        $settings = Settings::first();

        $attendanceType = 'none';

        if ($request->attendanceType == '1') {
            if (!$settings->is_geofence_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'Geofence attendance module is not available!');
            }

            if ($request->geofenceGroupId == null || $request->geofenceGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'Geofence group is required!');
            }

            $attendanceType = 'geofence';
        }

        if ($request->attendanceType == '2') {
            if (!$settings->is_ip_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'IP attendance module is not available!');
            }

            if ($request->ipGroupId == null || $request->ipGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'IP group is required!');
            }

            $attendanceType = 'ip_address';
        }

        if ($request->attendanceType == '3') {
            if (!$settings->is_qr_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'QR attendance module is not available!');
            }

            if ($request->qrGroupId == null || $request->qrGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'QR code group is required!');
            }
            $attendanceType = 'static_qr_code';
        }

        $user = User::findOrFail($id);

        if ($user->attendance_type != $attendanceType) {
            $user->attendance_type = $attendanceType;
        }

        if ($attendanceType == 'geofence') {
            if ($user->geofence_group_id != $request->geofenceGroupId) {
                $user->geofence_group_id = $request->geofenceGroupId;
            }
        }

        if ($attendanceType == 'ip_address') {
            if ($user->ip_address_group_id != $request->ipGroupId) {
                $user->ip_address_group_id = $request->ipGroupId;
            }
        }

        if ($attendanceType == 'static_qr_code') {
            if ($user->qr_code_group_id != $request->qrGroupId) {
                $user->qr_code_group_id = $request->qrGroupId;
            }
        }

        if ($user->email != $request->email) {
            $user->email = request()->email;
        }

        if ($user->phone_number != $request->phoneNumber) {
            $user->phone_number = $request->phoneNumber;
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

        if ($user->dob != $request->dob) {
            $user->dob = $request->dob;
        }

        if ($user->unique_id != $request->uniqueId) {
            $user->unique_id = $request->uniqueId;
        }

        if ($user->alternate_number != $request->alternateNumber) {
            $user->alternate_number = $request->alternateNumber;
        }

        if ($user->address != $request->address) {
            $user->address = $request->address;
            $addressDetails = $this->getLatLong($request->address);
            $user->lat = $addressDetails['lat'];
            $user->long = $addressDetails['long'];
        }

        if ($user->parent_id != $request->parentId) {
            $user->parent_id = $request->parentId;
        }

        if ($user->shift_id != $request->shiftId) {
            $user->shift_id = $request->shiftId;
        }

        if ($user->team_id != $request->teamId) {
            $user->team_id = $request->teamId;
        }

        if ($user->date_of_joining != $request->dateOfJoining) {
            $user->date_of_joining = $request->dateOfJoining;
        }

        if ($user->designation != $request->designation) {
            $user->designation = $request->designation;
        }

        if ($user->base_salary != $request->baseSalary) {
            $user->base_salary = $request->baseSalary;
        }


        if ($user->primary_sales_target != $request->primarySalesTarget) {
            $user->primary_sales_target = $request->primarySalesTarget;
        }

        if ($user->secondary_sales_target != $request->secondarySalesTarget) {
            $user->secondary_sales_target = $request->secondarySalesTarget;
        }

        if ($user->available_leaves != $request->availableLeaves) {
            $user->available_leaves = $request->availableLeaves;
        }

        $user->save();

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }
    
    public function getLatLong($address)
    {
        // dd($address);
        $address = urlencode($address);
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$apiKey}";
        $response = file_get_contents($url);
        $json = json_decode($response);

        if ($json->status === 'OK') {
            $location = $json->results[0]->geometry->location;
            return [
                'lat' => $location->lat,
                'long' => $location->lng
            ];
        }

        return null;
    }    

    public function store(Request $request)
    {
        $rules = [
            'userName' => 'required|unique:users,user_name|min:6',
            'useDefaultPassword' => 'required',
            'email' => 'email|unique:users,email',
            'phoneNumber' => 'required|unique:users,phone_number',
            'firstName' => 'required',
            'lastName' => 'required',
            'address' => 'required',
            'parentId' => 'required',
            'shiftId' => 'required',
            'teamId' => 'required',
            'designation' => 'required',
            'attendanceType' => 'required'
        ];

        $customMessages = [
            'parentId.required' => 'Manager is required',
            'shiftId.required' => 'Shift is required',
            'teamId.required' => 'Team is required',
        ];


        $this->validate(request(), $rules, $customMessages);

        $settings = Settings::first();

        $attendanceType = 'none';

        if ($request->attendanceType == '1') {
            if (!$settings->is_geofence_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'Geofence attendance module is not available!');
            }

            if ($request->geofenceGroupId == null || $request->geofenceGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'Geofence group is required!');
            }

            $attendanceType = 'geofence';
        }

        if ($request->attendanceType == '2') {
            if (!$settings->is_ip_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'IP attendance module is not available!');
            }

            if ($request->ipGroupId == null || $request->ipGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'IP group is required!');
            }

            $attendanceType = 'ip_address';
        }

        if ($request->attendanceType == '3') {
            if (!$settings->is_qr_attendance_module_enabled) {
                return redirect()->route('employee.create')->with('error', 'QR attendance module is not available!');
            }

            if ($request->qrGroupId == null || $request->qrGroupId == 0) {
                return redirect()->route('employee.create')->with('error', 'QR code group is required!');
            }
            $attendanceType = 'static_qr_code';
        }

        /*        if ($request->attendanceType == '4') {
                    if (!$settings->is_dynamic_qr_attendance_module_enabled) {
                        return redirect()->route('employee.create')->with('error', 'Dynamic QR attendance module is not available!');
                    }

                    if ($request->dynamicQrId == null || $request->dynamicQrId == 0) {
                        return redirect()->route('employee.create')->with('error', 'Dynamic QR code group is required!');
                    }
                    $attendanceType = 'dynamic_qr_code';
                }

                if ($request->attendanceType == '5') {
                    if (!$settings->is_site_module_enabled) {
                        return redirect()->route('employee.create')->with('error', 'Site attendance module is not available!');
                    }

                    if ($request->siteId == null || $request->siteId == 0) {
                        return redirect()->route('employee.create')->with('error', 'Site is required!');
                    }

                    $attendanceType = 'site';
                }*/

        $addressDetails = $this->getLatLong($request->address);

        $newUser = array(
            'user_name' => $request->userName,
            'password' => Hash::make($request->useDefaultPassword == null ? $request->password : "123456"),
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,

            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'unique_id' => $request->uniqueId,
            'alternate_number' => $request->alternateNumber,
            'address' => $request->address,

            'parent_id' => $request->parentId,
            'shift_id' => $request->shiftId,
            'team_id' => $request->teamId,
            'date_of_joining' => $request->dateOfJoining,
            'designation' => $request->designation,
            'base_salary' => $request->baseSalary,
            'primary_sales_target' => $request->primarySalesTarget,
            'secondary_sales_target' => $request->secondarySalesTarget,
            'available_leaves' => $request->availableLeaves,
            'attendance_type' => $attendanceType,
            'geofence_group_id' => $attendanceType == 'geofence' ? $request->geofenceGroupId : null,
            'ip_address_group_id' => $attendanceType == 'ip_address' ? $request->ipGroupId : null,
            'qr_code_group_id' => $attendanceType == 'static_qr_code' ? $request->qrGroupId : null,
            'lat' => $addressDetails['lat'],
            'long' => $addressDetails['long']
            /* 'dynamic_qr_id' => $attendanceType == 'dynamic_qr_code' ? $request->dynamicQrId : null,
             'site_id' => $attendanceType == 'site' ? $request->siteId : null,*/
             
        );

        $user = User::create($newUser);


        $userRole = Sentinel::findRoleBySlug('user');

        $userRole->users()->attach($user);

        return redirect()->route('employee.index')->with('success', 'Employee created successfully');
    }

    public function destroy($id)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('account.show', ['id' => $id])->with('error', 'You can not change status in demo mode');
        }
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('employee.index');
    }

    public function changeStatus(Request $request)
    {
        if (env('DEMO_MODE')) {
            return redirect()->route('employee.show', ['id' => $request->id])->with('error', 'You can not change status in demo mode');
        }
        $employee = User::findOrFail($request->id);
        if ($employee->status == 'active') {
            $employee->status = 'inactive';
        } else {
            $employee->status = 'active';
        }
        $employee->save();

        return redirect()->route('employee.show', $request->id)->with('success', 'Employee status changed successfully');
    }

    public function getGeofenceGroups()
    {
        $geofenceGroups = GeofenceGroup::where('status', '=', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($geofenceGroups);
    }

    public function getIpGroups()
    {
        $ipGroups = IpAddressGroup::where('status', '=', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($ipGroups);
    }

    public function getQrGroups()
    {
        $qrGroups = QRCodeGroup::where('status', '=', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($qrGroups);
    }


    public function taskadd($id)
    {
        $user = User::where('id', $id)
            ->with('team')
            ->with('shift')
            ->with('userDevice')
            ->first();

        $clients = Client::where('status', 'active')->latest()->get();

        $managerName = User::where('id', $user->parent_id)
            ->select('first_name', 'last_name')
            ->first();

            $tasks = Task::where('user_id', $id)->get();

        return view('employee.taskadd', compact('user', 'managerName', 'clients','tasks'));
    }

    public function taskstore(Request $request)
    {
        // Validate the incoming request
        $validator = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'client_id' => 'required|exists:clients,id', // Ensure the client exists
            'type' => 'required|in:1,2,3,4', // Ensure task type is valid (including "Other")
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'other_details' => 'nullable|string', // Validate other_details only if type is 4
        ]);
    
        // Get the authenticated user's ID
        $authId = Sentinel::getUser()->id;
        $validator['assigned_by_id'] = $authId;
    
        // Retrieve the client details
        $client = Client::find($request->client_id);
    
        // Start building the client details array
        $clientDetails = [];
    
        // Conditionally add details based on the task type or other criteria
        if ($request->type == 1 || $request->type == 3) { // For "Client Visit" or "Site Visit"
            $clientDetails['email'] = $client->email;
            $clientDetails['phone'] = $client->phone;
            $clientDetails['address'] = $client->address;
        }
    
        if ($request->type == 2) { // For "Payment Collection"
            $clientDetails['balance_amount'] = $client->balance_amount;
        }
    
        if ($request->type == 4) { // For "Other" task type
            // Store custom "other details" if provided
            if ($request->filled('other_details')) {
                $clientDetails['other_details'] = $request->other_details;
            }
        }
    
        // Add client ID and name (always required)
        $clientDetails['id'] = $client->id;
        $clientDetails['name'] = $client->name;
    
        // Create the task with the validated data and client details
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'client_id' => $request->client_id,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'assigned_by_id' => $authId,
            'client_details' => json_encode($clientDetails), // Store client details in JSON format
        ]);
    
        // Redirect with a success message
        return redirect()->route('employee.index')->with('success', 'Task Created Successfully');
    }
    

    public function getClientBalance(Request $request)
{
    $clientId = $request->input('client_id');

    // Fetch client with balance
    $client = Client::find($clientId);

    if ($client) {
        return response()->json([
            'success' => true,
            'balance_amount' => $client->balance_amount,
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Client not found.',
    ]);
}

public function getClientDetails(Request $request)
{
    $client = Client::find($request->client_id);

    if ($client) {
        return response()->json([
            'success' => true,
            'email' => $client->email,
            'address' => $client->address,
            'phone' => $client->phone,
        ]);
    }

    return response()->json(['success' => false]);
}
public function updateStatus(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $request->validate([
        'status' => 'required|in:new,in_progress,completed,cancelled',
    ]);

    $task->status = $request->status;
    $task->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully']);
}


public function taskdestroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete(); // Soft delete the task (if soft deletes are enabled)

            return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete the task.']);
        }
    }


}
