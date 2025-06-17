<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageAndVideoToOrderOfWorshipTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_of_worship', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('content');
            $table->string('video_url')->nullable()->after('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_of_worship', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'video_url']);
        });
    }
}
