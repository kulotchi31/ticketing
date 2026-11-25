<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_maintenance_history_table', function (Blueprint $table) {
            $table->id('maintenance_id');

            $table->unsignedBigInteger('fk_equipment_id');

            $table->date('maintenance_date');
            $table->enum('maintenance_type', [
                'Preventive',
                'Corrective',
                'Adaptive',
            ]);
            $table->text('maintenance_description')->nullable();

            $table->timestamps();

            $table->foreign('fk_equipment_id')
                  ->references('equipment_id')
                  ->on('equipment_table')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance_history_table');
    }
};