<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forum_subsections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_section_id')->constrained('forum_sections')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
            $table->unique(['forum_section_id','slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('forum_subsections');
    }
};


