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
        Schema::create('agreementterms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('term');
            $table->text('description');
            $table->unsignedBigInteger('partnership_id');
            $table->foreign('partnership_id')->references('id')->on('partnerships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreementterms');
    }
};
