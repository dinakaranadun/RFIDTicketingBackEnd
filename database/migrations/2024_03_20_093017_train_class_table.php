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
        Schema::create('train_class', function (Blueprint $table) {
            $table->unsignedBigInteger('train_id');
            $table->string('class');
            
            $table->foreign('train_id')->references('id')->on('train')->onDelete('cascade');
            
            // Composite primary key
            $table->primary(['train_id', 'class']);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_class');
    }
};
