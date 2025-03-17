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

        $roles = [ //NB, if you want more roles to be seeded, make the value of roles, be many arrays such that one array will represent a row in the roles table
            'name' => 'Super Admin'
        ];


        $dataFound = DB::table('roles')->where('name', $roles['name'])->exists();
        if ($dataFound) {
            echo "data exists, cannot seed";
        } else {
            try {

                DB::beginTransaction();
                DB::table('roles')->insert($roles);
                DB::commit();
            } catch (\Throwable $th) {
                info(json_encode($th));
            }
        }
    }
}
