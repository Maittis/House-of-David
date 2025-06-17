<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();  // Moved up for better organization
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('recorded_by')->nullable();  // Uncommented and added
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('type');  // Added missing donation type field
            $table->string('transaction_id')->nullable()->unique();  // Made nullable
            $table->string('status')->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')  // Changed from 'users' to 'members' to match your validation
                  ->onDelete('cascade');
                  
            $table->foreign('recorded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('donations');
    }
};