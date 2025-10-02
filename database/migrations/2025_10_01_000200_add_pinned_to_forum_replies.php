<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->boolean('pinned')->default(false)->after('body');
            $table->index(['forum_subsection_id', 'pinned']);
        });
    }

    public function down(): void
    {
        Schema::table('forum_replies', function (Blueprint $table) {
            $table->dropIndex(['forum_subsection_id', 'pinned']);
            $table->dropColumn('pinned');
        });
    }
};
