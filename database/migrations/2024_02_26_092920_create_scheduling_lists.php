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
        Schema::create('scheduling_lists', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('scheduling_lists');
    }
};
