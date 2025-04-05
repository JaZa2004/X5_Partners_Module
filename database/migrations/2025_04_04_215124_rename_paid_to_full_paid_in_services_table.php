<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RenamePaidToFullPaidInServicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure the column is big enough for the new value
        Schema::table('services', function (Blueprint $table) {
            $table->string('cost_type', 20)->change(); // Make sure the length is enough
        });

        // Update the values
        DB::table('services')
            ->where('cost_type', 'paid')
            ->update(['cost_type' => 'full_paid']);  // Rename 'paid' to 'full_paid'
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the column size if needed
        Schema::table('services', function (Blueprint $table) {
            $table->string('cost_type', 10)->change(); // Original length (adjust as needed)
        });

        // Revert the values
        DB::table('services')
            ->where('cost_type', 'full_paid')
            ->update(['cost_type' => 'paid']);  // Rename 'full_paid' back to 'paid'
    }
}
