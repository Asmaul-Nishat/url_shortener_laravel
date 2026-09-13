<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('first_name')->nullable()->after('id');

            $table->string('last_name')->nullable()->after('first_name');

            $table->string('phone')->nullable()->after('email');

            $table->string('country')->nullable()->after('phone');

            $table->string('timezone')
                ->default('Asia/Dhaka')
                ->after('country');

            $table->text('bio')->nullable()->after('timezone');

            $table->string('profile_photo_path')
                ->nullable()
                ->after('bio');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'first_name',
                'last_name',
                'phone',
                'country',
                'timezone',
                'bio',
                'profile_photo_path',
            ]);

        });
    }
};