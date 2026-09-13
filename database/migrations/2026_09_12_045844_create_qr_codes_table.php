<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('short_url_id')
                ->constrained('short_urls')
                ->cascadeOnDelete();

            $table->unsignedInteger('size')
                ->default(300);

            $table->string('foreground_color', 7)
                ->default('#111827');

            $table->string('background_color', 7)
                ->default('#ffffff');

            $table->string('logo_path')
                ->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('short_url_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};