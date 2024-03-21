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
        Schema::create('forum_answer', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('forum_question')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_answer');
    }
};
