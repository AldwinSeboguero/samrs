<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schema::table('applicants', function (Blueprint $table) {
        //     if (!Schema::hasColumn('applicants', 'uuid')) {
        //         $table->uuid('uuid')->unique()->after('id'); // Add the UUID column only if it doesn't exist
        //     }
        // });
    }

    public function down()
    {
        // Schema::table('applicants', function (Blueprint $table) {
        //     $table->dropColumn('uuid'); // Remove the UUID column
        // });
    }
};
