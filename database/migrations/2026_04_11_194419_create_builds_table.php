<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();                          // nama build (opsional)
            $table->enum('use_case', ['gaming', 'work', 'editing', 'study', 'balanced']);
            $table->enum('experience_level', ['beginner', 'enthusiast', 'expert'])->default('beginner');
            $table->decimal('budget', 12, 2);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->integer('total_tdp')->default(0);                    // total konsumsi daya
            $table->integer('performance_score')->default(0);            // skor performa keseluruhan
            $table->boolean('has_bottleneck')->default(false);
            $table->json('bottleneck_details')->nullable();              // detail bottleneck + saran
            $table->enum('status', ['draft', 'saved', 'published'])->default('draft');
            $table->boolean('is_public')->default(false);                // untuk community builds
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['is_public', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('builds');
    }
};
