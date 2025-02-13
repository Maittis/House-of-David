<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Check if the table doesn't exist, then create it. But since it does, this does nothing.
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->timestamps();
            });
        }
        // Or you can log that the table already exists
        Log::info('Roles table already exists in the database.');
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
