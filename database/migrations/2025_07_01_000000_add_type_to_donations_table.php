<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('donations', 'type')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->string('type')->default('donation')->after('amount')->comment('Type of donation: donation, offering, tithe');
            });
        }
    }

    public function down(): void {
        if (Schema::hasColumn('donations', 'type')) {
            Schema::table('donations', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};
