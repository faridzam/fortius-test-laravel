<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role' => 1,
                'name' => 'Software Engineer',
                'email' => 'engineer@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'role' => 2,
                'name' => 'HR Manager',
                'email' => 'hrmanager@mail.com',
                'password' => bcrypt('password')
            ],
            [
                'role' => 3,
                'name' => 'HR Staff',
                'email' => 'hrstaff@mail.com',
                'password' => bcrypt('password')
            ],
        ]);
    }
}
