<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [ 
            ['name' => 'Super Admin'],
            ['name'=> 'Staff']
        ];

        foreach ($roles as $role) {
            $dataFound = DB::table('roles')->where('name', $role['name'])->exists();
            if ($dataFound) {
                echo "data exists, cannot seed";
            } else {
                try {
    
                    DB::beginTransaction();
                    DB::table('roles')->insert($role);
                    DB::commit();
                } catch (\Throwable $th) {
                    info(json_encode($th));
                }
            }
        }
    }
}
