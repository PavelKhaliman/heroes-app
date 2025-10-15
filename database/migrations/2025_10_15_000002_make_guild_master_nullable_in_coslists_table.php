<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE coslists ALTER COLUMN guild DROP NOT NULL');
            DB::statement('ALTER TABLE coslists ALTER COLUMN master DROP NOT NULL');
            return;
        }

        if ($driver === 'sqlite') {
            Schema::rename('coslists', 'coslists_old');

            Schema::create('coslists', function (Blueprint $table) {
                $table->id();
                $table->string('nicname');
                $table->string('guild')->nullable();
                $table->string('master')->nullable();
                $table->string('reason');
                $table->string('repayment');
                $table->timestamps();
            });

            DB::statement('INSERT INTO coslists (id, nicname, guild, master, reason, repayment, created_at, updated_at) SELECT id, nicname, guild, master, reason, repayment, created_at, updated_at FROM coslists_old');

            Schema::drop('coslists_old');
            return;
        }

        // Fallback for other drivers: try schema change (requires doctrine/dbal)
        Schema::table('coslists', function (Blueprint $table) {
            $table->string('guild')->nullable()->change();
            $table->string('master')->nullable()->change();
        });
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE coslists ALTER COLUMN guild SET NOT NULL');
            DB::statement('ALTER TABLE coslists ALTER COLUMN master SET NOT NULL');
            return;
        }

        if ($driver === 'sqlite') {
            Schema::rename('coslists', 'coslists_old');

            Schema::create('coslists', function (Blueprint $table) {
                $table->id();
                $table->string('nicname');
                $table->string('guild');
                $table->string('master');
                $table->string('reason');
                $table->string('repayment');
                $table->timestamps();
            });

            DB::statement('INSERT INTO coslists (id, nicname, guild, master, reason, repayment, created_at, updated_at) SELECT id, nicname, guild, master, reason, repayment, created_at, updated_at FROM coslists_old');

            Schema::drop('coslists_old');
            return;
        }

        Schema::table('coslists', function (Blueprint $table) {
            $table->string('guild')->nullable(false)->change();
            $table->string('master')->nullable(false)->change();
        });
    }
};


