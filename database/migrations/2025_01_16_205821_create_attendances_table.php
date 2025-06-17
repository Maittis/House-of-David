<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('service_id')->nullable();
                $table->foreignId('member_id')->constrained();
                $table->date('date');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Drop the attendances table
        Schema::dropIfExists('attendances');
    }
}
