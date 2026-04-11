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
        Schema::create('components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->constrained('component_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('brand');
            $table->string('model');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('base_price', 12, 2);           // harga referensi
            $table->integer('tdp')->nullable();              // konsumsi daya (watt)
            $table->integer('performance_score')->nullable();// skor performa 0–100
            $table->json('specs');                           // spesifikasi lengkap (flexible)
            $table->json('compatibility_tags');              // socket, form factor, dll
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
