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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('nic_name');
            $table->integer('level');
            $table->integer('strong');
            $table->integer('survival');
            $table->string('prime_msk');
            $table->string('charecter_class');
            $table->text('info');
            $table->string('kos_list');
            $table->string('status');
            $table->timestamps();
            $table->index(['status']);
            $table->index(['nic_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
