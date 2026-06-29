<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DemoDataSeeder::class);
        //Local Demo
        //$this->call(SettingsSeeder::class);

        //Live
        $this->call(LiveSettingsSeeder::class);


        $this->call(AdminSeeder::class);
    }
}
