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
        Schema::create('performance_benchmarks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('component_id')->constrained()->cascadeOnDelete();
            $table->string('workload');             // valorant, cyberpunk, 4k_export, compile, dll
            $table->string('workload_type');        // gaming, rendering, multitasking
            $table->string('result_label');         // "120+ FPS", "~18 min", "Excellent"
            $table->decimal('result_value', 8, 2);  // nilai numerik untuk chart
            $table->string('result_unit');          // fps, minutes, score
            $table->timestamps();

            $table->index(['component_id', 'workload_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_benchmarks');
    }
};
