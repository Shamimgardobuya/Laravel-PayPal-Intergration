<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role_permission = [
            [
                'role_id' => 1,
                'permission_id' =>  1,
                'created_at' =>  Carbon::now()

            ],
            [
                'role_id' => 1,
                'permission_id' =>  2,
                'created_at' =>  Carbon::now()

            ],
            [
                'role_id' => 1,
                'permission_id' =>  3,
                'created_at' =>  Carbon::now()

            ],
            [
                'role_id' => 1,
                'permission_id' =>  4,
                'created_at' =>  Carbon::now()

            ],



        ];

        foreach ($role_permission as $rolePermission) {
            $dataFound = DB::table('role_permissions')
                ->where('role_id', $rolePermission['role_id'])
                ->where('permission_id', $rolePermission['permission_id'])
                ->exists();
            if ($dataFound) {
                echo "data exists";
            } else {
                try {
                    DB::beginTransaction();
                    DB::table('role_permissions')->insert($rolePermission);
                    DB::commit();
                } catch (\Throwable $th) {
                    info(json_encode($th));
                }
            }
        }
    }
}
