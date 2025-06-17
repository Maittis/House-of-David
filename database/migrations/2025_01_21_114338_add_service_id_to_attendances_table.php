<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdToAttendancesTable extends Migration
{
    public function up()
{
    if (!Schema::hasColumn('attendances', 'service_id')) {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->after('id');
        });
    }
}

public function down()
{
    if (Schema::hasColumn('attendances', 'service_id')) {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('service_id');
        });
    }
}
}
