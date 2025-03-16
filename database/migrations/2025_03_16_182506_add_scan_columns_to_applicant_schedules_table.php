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
            $table->timestamp('scan_at')->nullable(); // Add scan_at column
            $table->unsignedBigInteger('scan_by')->nullable(); // Add scan_by column

            // Set foreign key constraint with restrict on delete
            $table->foreign('scan_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applicant_schedules', function (Blueprint $table) {
            //
        });
    }
};
