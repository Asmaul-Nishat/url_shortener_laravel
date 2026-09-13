<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | General Settings
            |--------------------------------------------------------------------------
            */
            $table->string('language')->default('English');

            $table->string('timezone')
                ->default('Asia/Dhaka');

            $table->string('date_format')
                ->default('MMM DD, YYYY');

            /*
            |--------------------------------------------------------------------------
            | URL Settings
            |--------------------------------------------------------------------------
            */
            $table->string('default_expiration')
                ->default('Never');

            $table->boolean('allow_custom_aliases')
                ->default(true);

            $table->boolean('duplicate_detection')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Notification Settings
            |--------------------------------------------------------------------------
            */
            $table->boolean('link_expiration_alerts')
                ->default(true);

            $table->boolean('report_notifications')
                ->default(false);

            $table->boolean('security_alerts')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};