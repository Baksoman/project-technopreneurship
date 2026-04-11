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
        Schema::create('compatibility_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('component_a_id')->constrained('components')->cascadeOnDelete();
            $table->foreignUuid('component_b_id')->constrained('components')->cascadeOnDelete();
            $table->enum('status', ['compatible', 'incompatible', 'warning'])->default('compatible');
            $table->string('message')->nullable();   // "Works great together" / "Might cause issues"
            $table->text('suggestion')->nullable();  // saran perbaikan jika warning/incompatible
            $table->timestamps();

            $table->unique(['component_a_id', 'component_b_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compatibility_rules');
    }
};
