<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('next_maintenance_predictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_facility_id')->unique();
            $table->string('last_maintenance_type')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->string('predicted_next_action');
            $table->decimal('confidence', 5, 4); // e.g. 0.6850 (68.5%)
            $table->json('probabilities'); // e.g. {"Preventive": 0.685, "Repair": 0.215, ...}
            $table->string('model_used', 64);
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->foreign('fk_facility_id')
                ->references('facility_id')
                ->on('facility_table')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('next_maintenance_predictions');
    }
};