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
        Schema::create('all_il_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('course');
            $table->string('teacher');
            $table->string('mm');
            $table->string('dd');
            $table->string('day');
            $table->string('from');
            $table->string('to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_i_l_schedules');
    }
};
