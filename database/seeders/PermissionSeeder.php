<?php

namespace Database\Seeders;

use App\Models\Modules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $engineerPermissionDefault = Modules::all();
        $hrManagerPermissionDefault = Modules::whereIn('id', array_merge(range(14, 17), [2, 10]))->get();
        $hrStaffPermissionDefault = Modules::whereIn('id', array_merge(range(14, 16), [2, 10]))->get();

        foreach ($engineerPermissionDefault as $value) {
            DB::table('permissions')->insert(
                [
                    'role' => 1,
                    'module' => $value->id,
                    'name' => "Software Engineer".' - '.$value->name
                ],
            );
        }
        foreach ($hrManagerPermissionDefault as $value) {
            DB::table('permissions')->insert(
                [
                    'role' => 2,
                    'module' => $value->id,
                    'name' => "HR Manager".' - '.$value->name
                ],
            );
        }
        foreach ($hrStaffPermissionDefault as $value) {
            DB::table('permissions')->insert(
                [
                    'role' => 3,
                    'module' => $value->id,
                    'name' => "HR Staff".' - '.$value->name
                ],
            );
        }
    }
}
