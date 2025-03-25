<?php

use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesPermissionSeeder;
use Database\Seeders\RolesSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => RolesSeeder::class
        ]);

        Artisan::call('db:seed', [
            '--class' => PermissionsSeeder::class
        ]);

        Artisan::call('db:seed', [
            '--class' => RolesPermissionSeeder::class
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
