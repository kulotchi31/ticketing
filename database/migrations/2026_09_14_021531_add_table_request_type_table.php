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
        Schema::create('request_type_table', function (Blueprint $table) {
            $table->bigIncrements('request_type_id');
            $table->timestamps();
            $table->string('rt_name');
            $table->string('rt_code');
            $table->unsignedBigInteger('fk_provider_id');


            $table->foreign('fk_provider_id')->references('provider_id')->on('provider_table')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::dropIfExists('request_type_table');
    }
};
