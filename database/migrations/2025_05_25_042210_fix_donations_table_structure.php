<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 1. First handle NULL values and invalid references
        // Option 1: Set invalid references to 0 (assuming 0 is a valid default or no member)
        DB::table('donations')
            ->whereNotIn('member_id', function($query) {
                $query->select('id')->from('members');
            })
            ->whereNotNull('member_id')
            ->update(['member_id' => 0]);
            
        // Option 2: Or assign to a default member (if you have one)
        // $defaultMemberId = 1; // Ensure this member exists
        // DB::table('donations')
        //     ->whereNotIn('member_id', function($query) {
        //         $query->select('id')->from('members');
        //     })
        //     ->update(['member_id' => $defaultMemberId]);
        
        // 2. Modify the column to be nullable first
        Schema::table('donations', function (Blueprint $table) {
            // Drop foreign key if exists
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys('donations');
            foreach ($foreignKeys as $foreignKey) {
                if (in_array('member_id', $foreignKey->getLocalColumns())) {
                    $table->dropForeign($foreignKey->getName());
                }
            }
            $table->unsignedBigInteger('member_id')->nullable()->change();
        });
        
        // 3. Now add the foreign key constraint
        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('member_id')
                ->references('id')
                ->on('members')
                ->onDelete('set null'); // Changed from 'cascade' to 'set null'
        });
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            // Optional: change back to not nullable if needed
            // $table->unsignedBigInteger('member_id')->nullable(false)->change();
        });
    }
};
