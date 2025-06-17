<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsherCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usher_collections', function (Blueprint $table) {
            $table->id();
            $table->string('usher_name');
            $table->timestamp('date_time');
            $table->string('collection_type');
            $table->decimal('amount', 10, 2);
            $table->longText('signature'); // base64 encoded image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('usher_collections');
    }
}
