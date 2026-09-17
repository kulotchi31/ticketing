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
        Schema::create('category_table', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->timestamps();
            $table->string('category_name')->unique();
            $table->string('category_code')->unique();
            $table->unsignedBigInteger('fk_request_type_id');


            $table->foreign('fk_request_type_id')->references('request_type_id')->on('request_type_table')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_table');
    }
};
