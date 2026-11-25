<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_table', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->unsignedBigInteger('fk_department_id');
            $table->string('equipment_name');
            $table->enum('category', [
                'Network',
                'Computer Equipment',
                'Printing Equipment',
                'Multimedia Equipment',
                'Server and Storage',
                'Power and Accessories',
            ]);
            $table->string('serial_number')->nullable();
            $table->enum('status', [
                'operational',
                'needs_maintenance',
                'under_repair',
                'retired',
            ])->default('operational');
            $table->date('date_acquired')->nullable();
            $table->timestamps();

            $table->foreign('fk_department_id')
                  ->references('department_id')
                  ->on('department_table')
                  ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_table');
    }
};