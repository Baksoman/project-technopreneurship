<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recommendation_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('use_case');
            $table->string('category_slug');
            $table->decimal('budget_percentage', 5, 2);
            $table->integer('priority');
            $table->json('scoring_weights');
            $table->timestamps();
            $table->unique(['use_case', 'category_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_rules');
    }
};
