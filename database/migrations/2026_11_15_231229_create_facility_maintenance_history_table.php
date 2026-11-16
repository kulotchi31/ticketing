<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facility_maintenance_history_table', function (Blueprint $table) {
            $table->id('maintenance_id');

            $table->unsignedBigInteger('fk_facility_id');

            $table->date('maintenance_date');
            $table->enum('maintenance_type', [
                'Preventive',
                'Corrective',
                'Emergency',
                'Improvement'
            ]);
            
            $table->text('maintenance_description')->nullable();
            $table->decimal('maintenance_cost', 12, 2)->nullable();

            $table->timestamps();

            $table->foreign('fk_facility_id')
                  ->references('facility_id')
                  ->on('facility_table')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facility_maintenance_history_table');
    }
};
