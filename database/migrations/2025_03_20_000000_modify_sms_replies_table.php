<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySmsRepliesTable extends Migration
{
    public function up()
    {
        Schema::table('sms_replies', function (Blueprint $table) {
            if (!Schema::hasColumn('sms_replies', 'member_id')) {
                $table->bigInteger('member_id')->unsigned()->nullable();
            }
            if (!Schema::hasColumn('sms_replies', 'provider')) {
                $table->string('provider')->default('twilio');
            }
        });
    }

    public function down()
    {
        Schema::table('sms_replies', function (Blueprint $table) {
            if (Schema::hasColumn('sms_replies', 'member_id')) {
                $table->dropColumn('member_id');
            }
            if (Schema::hasColumn('sms_replies', 'provider')) {
                $table->dropColumn('provider');
            }
        });
    }
}
