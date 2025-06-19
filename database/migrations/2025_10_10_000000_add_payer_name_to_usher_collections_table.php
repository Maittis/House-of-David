<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayerNameToUsherCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('usher_collections', function (Blueprint $table) {
            $table->string('payer_name')->after('usher_name')->nullable(false)->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('usher_collections', function (Blueprint $table) {
            $table->dropColumn('payer_name');
        });
    }
}
