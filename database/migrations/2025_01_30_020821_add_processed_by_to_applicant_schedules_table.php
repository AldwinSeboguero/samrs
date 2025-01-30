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
        Schema::table('applicant_schedules', function (Blueprint $table) {
              // Add the processed_by column
              $table->unsignedBigInteger('processed_by')->nullable(); // Replace 'some_existing_column' with the actual column after which you want to add this

              // Add the foreign key constraint
              $table->foreign('processed_by')->references('id')->on('users'); // Adjust the onDelete action as necessary
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('applicant_schedules', function (Blueprint $table) {
        //     //
        // });
    }
};
