<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('last_attendance')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}
