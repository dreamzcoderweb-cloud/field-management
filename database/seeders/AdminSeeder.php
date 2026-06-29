<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\Team;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using truncate function so all info will be cleared when re-seeding.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $admin = Sentinel::registerAndActivate([
            'email' => 'admin@demo.com',
            'password' => '123456',
            'user_name' => 'adminuser',
            'designation' => 'Super Admin',
            'phone_number' => '0000000000',
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);

        $shift = Shift::where('id', 1)->first();

        $team = Team::where('id', 1)->first();

        $manager = Sentinel::registerAndActivate([
            'email' => 'manager@demo.com',
            'password' => "123456",
            'user_name' => "manager",
            'designation' => 'Manager',
            'phone_number' => '1111111111',
            'first_name' => 'John',
            'last_name' => 'Doe Manager',
        ]);

        $user = Sentinel::registerAndActivate([
            'email' => 'employee@demo.com',
            'password' => "123456",
            'user_name' => "employee",
            'designation' => 'Employee',
            'phone_number' => '2222222222',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'shift_id' => $shift->id,
            'team_id' => $team->id,
            'parent_id' => $manager->id,
        ]);

        // create 2 roles
        $adminRole = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => ['admin' => 1]
        ]);

        $managerRole = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Manager',
            'slug' => 'manager',
            'permissions' => ['manager' => true]
        ]);

        $userRole = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => ['user' => true]
        ]);

// add user to user role and admin to admin role
        $admin->roles()->attach($adminRole);
        $manager->roles()->attach($managerRole);
        $user->roles()->attach($userRole);

        $this->command->info('Admin User created with username admin@demo.com and password 123456');
    }
}
