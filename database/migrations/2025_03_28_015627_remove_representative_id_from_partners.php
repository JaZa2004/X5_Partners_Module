<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropForeign(['representative_id']); // Remove foreign key
            $table->dropColumn('representative_id'); // Remove the column
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->unsignedBigInteger('representative_id')->nullable();
            $table->foreign('representative_id')->references('id')->on('representatives')->onDelete('cascade');
        });
    }
};
