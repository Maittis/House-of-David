<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDonationsTable extends Migration
{
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'receipt_number')) {
                $table->string('receipt_number')->after('id');
            }

            if (!Schema::hasColumn('donations', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('status');
            }

            if (!Schema::hasColumn('donations', 'recorded_by')) {
                $table->unsignedBigInteger('recorded_by')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['receipt_number', 'verified_at', 'recorded_by']);
        });
    }
}
