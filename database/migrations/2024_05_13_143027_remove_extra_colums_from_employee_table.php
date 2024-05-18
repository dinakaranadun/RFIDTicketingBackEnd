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
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn('fName');
            $table->dropColumn('lName');
            $table->dropUnique('employee_NIC_unique');
            $table->dropColumn('NIC');
            $table->dropUnique('employee_email_unique');
            $table->dropColumn('email');
            $table->dropUnique('employee_contact_number_unique');
            $table->dropColumn('contact_number');
            $table->dropColumn('image');
            $table->dropColumn('status');
            $table->dropColumn('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            //
        });
    }
};
