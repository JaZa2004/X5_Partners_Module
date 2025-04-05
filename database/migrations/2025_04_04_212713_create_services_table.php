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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->unsignedBigInteger('partnership_id');
            $table->foreign('partnership_id')->references('id')->on('partnerships')->onDelete('cascade');
            
            $table->string('name'); // Name of the service
            $table->text('description'); // Description of the service
            $table->enum('cost_type', ['free', 'discount', 'paid']); // Type of service
            $table->decimal('price', 10, 2)->nullable(); // Price (nullable if type is 'free')
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
