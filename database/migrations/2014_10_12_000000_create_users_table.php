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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fName');
            $table->string('lName');
            $table->string('NIC')->unique();
            $table->string('email')->unique();
            $table->string('contact_number')->unique();
            $table->string('image')->nullable();
            $table->string('rfid')->nullable();
            $table->decimal('account_credits', 10, 2)->default(0.00);
            $table->string('status')->default('active');
            $table->timestamp('contactnumber_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
