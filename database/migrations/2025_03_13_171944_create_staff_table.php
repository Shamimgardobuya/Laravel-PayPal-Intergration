<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->timestamps();
            $table->string('first_name')->max(25)->nullable(false);
            $table->string('last_name')->max(25)->nullable(false);
            $table->string('role')->max(25)->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('phone')->unique()->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
