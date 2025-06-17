<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagePathToEventsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    if (!Schema::hasColumn('events', 'image_path')) {
        Schema::table('events', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
        });
    }
}

public function down()
{
    if (Schema::hasColumn('events', 'image_path')) {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });
    }
}

}
