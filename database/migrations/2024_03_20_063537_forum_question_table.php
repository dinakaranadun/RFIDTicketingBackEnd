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
        Schema::create('forum_question', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->text('content');
            $table->unsignedBigInteger('passenger_id');
            $table->foreign('passenger_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_questions');
    }
};
