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
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('original_url');

            $table->string('short_code', 20)
                ->unique();

            $table->string('custom_alias', 100)
                ->nullable()
                ->unique();

            $table->unsignedBigInteger('click_count')
                ->default(0);

            $table->dateTime('expires_at')
                ->nullable();

            $table->enum('status', [
                'active',
                'expired',
                'disabled'
            ])->default('active');

            $table->timestamps();

            $table->index('user_id');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
    }
};