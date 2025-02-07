<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
      */
    // public function up()
    // {
    //     Schema::create('sms_replies', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('member_id')->constrained()->onDelete('cascade'); // Link reply to the member
    //         $table->string('reply_message', 160); // Member's reply message
    //         $table->timestamps();
    //     });
    // }

    public function up()
    {
        Schema::create('sms_replies', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->text('message');
            $table->timestamps();
        });
    }
       /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_replies');
    }
};






