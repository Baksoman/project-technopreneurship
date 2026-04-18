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
        Schema::create('build_components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('build_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('component_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('price_at_time', 12, 2);
            $table->string('marketplace')->nullable();
            $table->timestamps();

            $table->unique(['build_id', 'component_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('build_components');
    }
};
