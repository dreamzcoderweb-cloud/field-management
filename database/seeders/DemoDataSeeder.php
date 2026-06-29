<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DocumentType;
use App\Models\ExpenseType;
use App\Models\GeofenceGroup;
use App\Models\GeofenceLocation;
use App\Models\Holiday;
use App\Models\IpAddress;
use App\Models\IpAddressGroup;
use App\Models\LeaveType;
use App\Models\QRCodeGroup;
use App\Models\QrCodeModel;
use App\Models\Shift;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('leave_types')->truncate();
        DB::table('expense_types')->truncate();
        DB::table('clients')->truncate();
        DB::table('shifts')->truncate();
        DB::table('teams')->truncate();
        DB::table('holidays')->truncate();
        DB::table('ip_address_groups')->truncate();
        DB::table('geofence_groups')->truncate();
        DB::table('qr_code_groups')->truncate();
        DB::table('document_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //Leave Types
        LeaveType::create([
            'name' => 'Casual Leave',
            'description' => 'Casual Leave',
            'is_img_required' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        LeaveType::create([
            'name' => 'Sick Leave',
            'description' => 'Sick Leave',
            'is_img_required' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        LeaveType::create([
            'name' => 'Other Leave',
            'description' => 'Other Leave',
            'is_img_required' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Leave Type Seeded Successfully');

        //Expense Types
        ExpenseType::create([
            'name' => 'Travel',
            'description' => 'Travel',
            'is_img_required' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ExpenseType::create([
            'name' => 'Food',
            'description' => 'Food',
            'is_img_required' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        ExpenseType::create([
            'name' => 'Other',
            'description' => 'Other',
            'is_img_required' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Expense Type Seeded Successfully');

        //Clients
        Client::create([
            'name' => 'Test Solution',
            'address' => 'India',
            'phone' => '1234567890',
            'email' => 'test@czappstudio.com',
            'city' => 'chennai',
            'state' => 'Tamil Nadu',
            'radius' => 100,
            'latitude' => 23.613541,
            'longitude' => 58.594109,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Client::create([
            'name' => 'Test Solution 2',
            'address' => 'India',
            'phone' => '1234567890',
            'email' => 'test2@czappstudio.com',
            'city' => 'chennai',
            'state' => 'Tamil Nadu',
            'radius' => 100,
            'latitude' => 23.613541,
            'longitude' => 58.594109,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Client Seeded Successfully');


        //Shifts
        Shift::create(
            [
                'title' => 'Morning Shift',
                'description' => 'Morning Shift',
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'status' => 'active',
                'sunday' => 0,
                'monday' => 1,
                'tuesday' => 1,
                'wednesday' => 1,
                'thursday' => 1,
                'friday' => 1,
                'saturday' => 0,
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'title' => 'Night Shift',
                'description' => 'Night Shift',
                'start_time' => '17:00:00',
                'end_time' => '09:00:00',
                'status' => 'active',
                'sunday' => 0,
                'monday' => 1,
                'tuesday' => 1,
                'wednesday' => 1,
                'thursday' => 1,
                'friday' => 1,
                'saturday' => 0,
            ]
        );

        $this->command->info('Demo Shift Seeded Successfully');

        //Teams
        Team::create([
            'name' => 'Default Team',
            'description' => 'Team 1',
            'status' => 1,
            'is_chat_enabled' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Team::create([
            'name' => 'Team 2',
            'description' => 'Team 2',
            'status' => 1,
            'is_chat_enabled' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Team::create([
            'name' => 'Team 3',
            'description' => 'Team 3',
            'status' => 1,
            'is_chat_enabled' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Team Seeded Successfully');

        //Holidays
        Holiday::insert([
            'name' => 'New Year',
            'description' => 'New Year',
            'date' => '2024-01-01',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Republic Day',
            'description' => 'Republic Day',
            'date' => '2024-01-26',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Holi',
            'description' => 'Holi',
            'date' => '2024-03-21',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Good Friday',
            'description' => 'Good Friday',
            'date' => '2024-04-19',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Eid al-Fitr',
            'description' => 'Eid al-Fitr',
            'date' => '2024-06-05',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Independence Day',
            'description' => 'Independence Day',
            'date' => '2024-08-15',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Gandhi Jayanti',
            'description' => 'Gandhi Jayanti',
            'date' => '2024-10-02',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Diwali',
            'description' => 'Diwali',
            'date' => '2024-10-27',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'Christmas',
            'description' => 'Christmas',
            'date' => '2024-12-25',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Holiday::insert([
            'name' => 'New Year',
            'description' => 'New Year',
            'date' => '2025-01-01',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Holiday Seeded Successfully');


        //IP Address Groups
        IpAddressGroup::insert([
            'name' => '"Test IP Group 1',
            'description' => 'Test IP Group 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $group1 = IpAddressGroup::first();

        IpAddress::insert([
            'ip_address_group_id' => $group1->id,
            'name' => 'Test IP 1',
            'description' => 'Test IP 1',
            'ip_address' => '192.168.1.110',
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        IpAddress::insert([
            'ip_address_group_id' => $group1->id,
            'name' => 'Test IP 2',
            'description' => 'Test IP 2',
            'ip_address' => '192.168.29.157',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo IP Address Group Seeded Successfully');

        //Geofence Groups
        GeofenceGroup::insert([
            'name' => 'Test Geofence Group 1',
            'description' => 'Test Geofence Group 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $geofenceGroup = GeofenceGroup::first();

        GeofenceLocation::insert([
            'geofence_group_id' => $geofenceGroup->id,
            'name' => 'Test Geofence 1',
            'description' => 'Test Geofence 1',
            'latitude' => 23.613541,
            'longitude' => 58.594109,
            'radius' => 100,
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        GeofenceLocation::insert([
            'geofence_group_id' => $geofenceGroup->id,
            'name' => 'Test Geofence 2',
            'description' => 'Test Geofence 2',
            'latitude' => 23.613541,
            'longitude' => 58.594109,
            'radius' => 100,
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo Geofence Group Seeded Successfully');

        //QR Code Groups
        QRCodeGroup::insert([
            'name' => 'Test QR Code Group 1',
            'description' => 'Test QR Code Group 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $qrGroup = QRCodeGroup::first();

        QrCodeModel::insert([
            'name' => 'Test Code 1',
            'description' => 'Test Code 1',
            'code' => '1234567890',
            'qr_code_group_id' => $qrGroup->id,
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        QrCodeModel::insert([
            'name' => 'Test Code 2',
            'description' => 'Test Code 2',
            'code' => '0987654321',
            'qr_code_group_id' => $qrGroup->id,
            'is_enabled' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DocumentType::insert([
            'name' => 'NOC',
            'description' => 'NOC Type 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DocumentType::insert([
            'name' => 'Agreement',
            'description' => 'Agreement Type 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DocumentType::insert([
            'name' => 'Contract',
            'description' => 'Contract Type 1',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->command->info('Demo QR Code Group Seeded Successfully');

        $this->command->info('----Demo Data Seeded Successfully----');
    }


}
