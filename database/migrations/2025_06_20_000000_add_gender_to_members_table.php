<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'gender')) {
                $table->string('gender')->nullable()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
}
