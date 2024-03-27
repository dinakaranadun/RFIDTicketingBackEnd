<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dummy data for users table
        $users = [
            [
                'fName' => 'John',
                'lName' => 'Doe',
                'NIC' => '123456789X',
                'email' => 'john@example.com',
                'contact_number' => '1234567890',
                'image' => null,
                'rfid' => null,
                'account_credits' => 0.00,
                'status' => 'active',
                'contactnumber_verified_at' => Carbon::now(),
                'password' => Hash::make('dinakara'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more users as needed
        ];

        // Insert data into users table
        DB::table('users')->insert($users);
    }
}
