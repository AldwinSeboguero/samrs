<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            // Adding an auto-incrementing ID column
            $table->bigIncrements('id');
    
            // Adding specified columns
            $table->uuid('uuid');
            $table->string('equity_group')->nullable();
            $table->unsignedBigInteger('applicant_id')->nullable();
    
            // Add the foreign key constraint
            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade'); // Adjust onDelete action as necessary
    
            $table->string('percentile_rank');
            $table->string('reading');
            $table->string('math');
            $table->string('language');
            $table->string('status_1');
            $table->string('status_2');
            $table->string('endorsed_for');
    
            // Adding timestamps
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            //
        });
    }
};
