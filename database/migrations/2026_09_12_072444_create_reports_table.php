<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('short_url_id')
                ->nullable()
                ->constrained('short_urls')
                ->nullOnDelete();

            $table->string('name');

            $table->string('type');

            $table->string('date_range');

            $table->date('start_date');

            $table->date('end_date');

            $table->string('format', 10);

            $table->string('file_path');

            $table->unsignedInteger('total_clicks')
                ->default(0);

            $table->timestamps();

            $table->index('user_id');
            $table->index('short_url_id');
            $table->index('type');
            $table->index('format');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};