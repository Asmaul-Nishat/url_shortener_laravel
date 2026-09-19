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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            $table->string('default_link_status')
                ->default('active');

            $table->unsignedInteger('default_expiration_days')
                ->default(0);

            $table->boolean('allow_guest_short_urls')
                ->default(true);

            $table->boolean('allow_guest_qr_codes')
                ->default(true);

            $table->boolean('enable_analytics')
                ->default(true);

            $table->boolean('enable_reports')
                ->default(true);

            $table->boolean('enable_activity_logs')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};