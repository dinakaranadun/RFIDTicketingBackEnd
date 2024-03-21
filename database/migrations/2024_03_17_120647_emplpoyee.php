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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('fName');
            $table->string('lName');
            $table->string('NIC')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact_number')->unique();
            $table->string('image')->nullable();
            $table->string('position');
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
