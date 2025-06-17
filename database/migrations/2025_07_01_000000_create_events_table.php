<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->dateTime('start_datetime');
        $table->dateTime('end_datetime')->nullable();
        $table->string('location')->nullable();
        $table->string('image_path')->nullable();
        $table->string('slug')->unique();
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
