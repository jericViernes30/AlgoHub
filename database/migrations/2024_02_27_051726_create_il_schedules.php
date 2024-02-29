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
        Schema::create('il_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->string('teacher');
            $table->string('month');
            $table->string('date');
            $table->string('day');
            $table->string('a_time');
            $table->string('b_time');
            $table->string('c_time');
            $table->string('d_time');
            $table->string('parents_name');
            $table->string('childs_name');
            $table->string('age');
            $table->string('contact_number');
            $table->string('email_address');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('il_schedules');
    }
};
