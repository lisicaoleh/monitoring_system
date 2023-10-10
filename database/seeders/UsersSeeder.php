<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '00000000',
                'mobile' => '0000000000',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => '00000000',
                'mobile' => '1234567890',
            ]
        ]);
    }
}
