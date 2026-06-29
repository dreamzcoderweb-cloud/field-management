<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'user_name',
        'team_id',
        'shift_id',
        'phone_number',
        'designation',
        'gender',
        'password',
        'parent_id',
        'status',
        'address',
        'unique_id',
        'profile_picture',
        'date_of_joining',
        'dob',
        'alternate_number',
        'available_leaves',
        'primary_sales_target',
        'secondary_sales_target',
        'base_salary',
        'dynamic_qr_device_id',
        'geofence_group_id',
        'ip_address_group_id',
        'qr_code_group_id',
        'attendance_type',
        'lat',
        'long'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /* public function role()
     {
         return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
     }*/

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function expenseRequests(): HasMany
    {
        return $this->hasMany(ExpenseRequest::class, 'user_id');
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }

    public function userDevice()
    {
        return $this->hasOne(UserDevice::class, 'user_id');
    }

    public function pushTokens(): HasMany
    {
        return $this->hasMany(PushToken::class, 'user_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function dynamicQrDevice()
    {
        return $this->belongsTo(DynamicQrDevice::class, 'dynamic_qr_device_id');
    }

    public function geofenceGroup()
    {
        return $this->belongsTo(GeofenceGroup::class, 'geofence_group_id');
    }

    public function ipAddressGroup()
    {
        return $this->belongsTo(IpAddressGroup::class, 'ip_address_group_id');
    }

    public function qrGroup()
    {
        return $this->belongsTo(QrCodeGroup::class, 'qr_group_id');
    }

    public function paymentCollections()
    {
        return $this->hasMany(PaymentCollection::class, 'user_id');
    }

    public function salesTargets()
    {
        return $this->hasMany(SalesTarget::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }

    public function geofenceVerifications()
    {
        return $this->hasMany(GeofenceVerificationLog::class, 'user_id');
    }

    public function ipAddressVerifications()
    {
        return $this->hasMany(IpAddressVerificationLog::class, 'user_id');
    }

    public function qrCodeVerifications()
    {
        return $this->hasMany(QrCodeVerificationLog::class, 'user_id');
    }

    public function duty(): HasMany
    {
        return $this->hasMany(Duty::class);
    }

    public function assignedduty(): HasMany
    {
        return $this->hasMany(Duty::class, 'assigned_by', 'id');
    }

    public function lead(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function target(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function staffvehicle(): HasOne
    {
        return $this->hasOne(Staffvehicle::class);
    }

    public function client(): HasMany
    {
        return $this->hasMany(Client::class, 'created_by_id', 'id');
    }

    public function ledger(): HasMany
    {
        return $this->hasMany(Ledger::class);
    }
}
