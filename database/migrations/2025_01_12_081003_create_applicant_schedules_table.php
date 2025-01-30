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
       
        // Schema::create('applicant_schedules', function (Blueprint $table) {
        //     // $table->id(); // Primary key
        //     // $table->unsignedBigInteger('applicant_id'); // Foreign key for applicants
        //     // $table->unsignedBigInteger('exam_schedule_id'); // Foreign key for exam schedules
        //     // $table->dateTime('scheduled_at'); // Date and time for the schedule
        //     // $table->string('status')->default('pending'); // Status of the schedule

        //     // // Foreign key constraints
        //     // $table->foreign('applicant_id')
        //     //       ->references('id')->on('applicants');

        //     // $table->foreign('exam_schedule_id')
        //     //       ->references('id')->on('exam_schedules');// Cascade on delete// Status of the schedule (e.g., pending, confirmed, canceled)
        //     // $table->timestamps(); // Created at and updated at timestamps
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('applicant_schedules');
    }
};
