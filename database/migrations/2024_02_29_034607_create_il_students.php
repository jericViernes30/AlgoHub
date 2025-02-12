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
        Schema::create('il_students', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('course');
            $table->string('student_name');
            $table->string('parent_name');
            $table->string('age');
            $table->string('contact_number');
            $table->string('email_address');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('il_students');
    }
};
