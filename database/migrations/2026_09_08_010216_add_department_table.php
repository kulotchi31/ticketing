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
        Schema::create('department_table', function (Blueprint $table) {
            $table->bigIncrements('department_id');
            $table->timestamps();
            $table->string('department_name');
            $table->string('department_code');
            $table->unsignedBigInteger('fk_campus_id');

            $table->foreign('fk_campus_id')->references('campus_id')->on('campus_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_table');
    }
};
