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
        Schema::create('facility_table', function (Blueprint $table) {
            $table->id('facility_id');
            $table->string('facility_name');
            $table->date('date_establish')->nullable();

            $table->unsignedBigInteger('fk_campus_id');

            $table->foreign('fk_campus_id')
                  ->references('campus_id')
                  ->on('campus_table')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_table');
    }
};
