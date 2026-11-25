<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('e_next_maintenance', function (Blueprint $table) {
            $table->id('prediction_id');
            $table->unsignedBigInteger('fk_equipment_id')->unique();
            $table->string('last_maintenance_type', 100)->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->string('predicted_next_action', 100);
            $table->decimal('confidence', 6, 4)->default(0);
            $table->date('predicted_date')->nullable();
            $table->json('probabilities')->nullable();
            $table->json('markov_probabilities')->nullable();
            $table->string('model_used', 100)->nullable();
            $table->timestamp('predicted_at')->nullable();
            $table->timestamps();

            $table->foreign('fk_equipment_id')
                ->references('equipment_id')
                ->on('equipment_table')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_next_maintenance_predictions_table');
    }
};