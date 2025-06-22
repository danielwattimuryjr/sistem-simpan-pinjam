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
        Schema::create('criteria_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')
                ->nullable()
                ->constrained('criterias')
                ->nullOnDelete()
                ->nullOnUpdate();
            $table->string('criteria_name');
            $table->enum('criteria_category', ['benefit', 'cost']);
            $table->decimal('criteria_weight', 8, 4);
            $table->decimal('batas_bawah', 12, 2)->nullable();
            $table->decimal('score', 8, 4);
            $table->string('table_reference');
            $table->string('column_reference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_scores');
    }
};
