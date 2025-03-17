<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissions;
use Illuminate\Support\Facades\Log;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['action' => 'create.staff', 'description' => 'Create a new staff'],
            ['action' => 'read.staff', 'description' => 'View staff records'],
            ['action' => 'update.staff', 'description' => 'Update staff record'],
            ['action' => 'delete.staff', 'description' => 'Delete a  staff record'],
        ];

        foreach ($permissions as $permission) {
            $action = $permission['action'];
            $dataFound = DB::table('permissions')->where('action', $action)->exists();
            if ($dataFound) {
                echo "data exists";
            } else {
                try {
                    DB::beginTransaction();
                    DB::table('permissions')->insert($permission);
                    DB::commit();
                } catch (\Throwable $th) {
                    info(json_encode($th));
                }
            }
        }
    }
}
