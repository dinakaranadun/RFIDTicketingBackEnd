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
        Schema::create('scanner_ticket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scanner_id');
            $table->unsignedBigInteger('ticket_id');
            $table->date('date');
            $table->time('time');
            
            $table->foreign('scanner_id')->references('id')->on('scanner')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('ticket')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scanner_ticket');
    }
};
