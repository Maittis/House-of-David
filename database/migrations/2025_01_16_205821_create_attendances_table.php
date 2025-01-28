<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Primary key

            // Foreign key linking to services table
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');

            // Foreign key linking to members table
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');

            // Date of attendance
            $table->date('date');

            $table->timestamps(); // Created and updated timestamps

            // Ensure unique attendance per service, member, and date
            $table->unique(['service_id', 'member_id', 'date']);
        });
    }

    public function down()
    {
        // Drop the attendances table
        Schema::dropIfExists('attendances');
    }
}
