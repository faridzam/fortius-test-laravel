<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modules')->insert([
            [
                'name' => 'register'
            ],
            [
                'name' => 'role-get',
            ],
            [
                'name' => 'role-create',
            ],
            [
                'name' => 'role-update',
            ],
            [
                'name' => 'role-delete',
            ],
            [
                'name' => 'module-get',
            ],
            [
                'name' => 'module-create',
            ],
            [
                'name' => 'module-update',
            ],
            [
                'name' => 'module-delete',
            ],
            [
                'name' => 'permission-get',
            ],
            [
                'name' => 'permission-create',
            ],
            [
                'name' => 'permission-update',
            ],
            [
                'name' => 'permission-delete',
            ],
            [
                'name' => 'employee-get',
            ],
            [
                'name' => 'employee-create',
            ],
            [
                'name' => 'employee-update',
            ],
            [
                'name' => 'employee-delete',
            ],
        ]);
    }
}
