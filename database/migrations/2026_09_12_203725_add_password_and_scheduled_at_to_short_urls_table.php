<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            $table->string('password')
                ->nullable()
                ->after('expires_at');

            $table->dateTime('scheduled_at')
                ->nullable()
                ->after('password');

            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('short_urls', function (Blueprint $table) {

            $table->dropIndex([
                'scheduled_at'
            ]);

            $table->dropColumn([
                'password',
                'scheduled_at',
            ]);
        });
    }
};