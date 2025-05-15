<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UsersEmpSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(2)->create();

        $users = [
            [
                'fName' => 'John',
                'lName' => 'Emp',
                'NIC' => '1234567890',
                'email' => 'johnemp@example.com',
                'contact_number' => '1234567888',
                'image' => null,
                'rfid' => null,
                'account_credits' => 0.00,
                'status' => 'active',
                'user_type' => 'EMP',
                'contactnumber_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'remember_token' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more users as needed
        ];

        DB::table('users')->insert($users);
    }
}
