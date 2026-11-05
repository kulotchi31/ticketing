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
        Schema::create('auditlogs_table', function (Blueprint $table) {
        $table->bigIncrements('audit_id');
        $table->unsignedBigInteger('fk_user_id'); 
        $table->unsignedBigInteger('target_id');
        $table->string('action_type');
        $table->json('payload')->nullable();
        $table->date('transaction_date')->default(now());

        $table->foreign('fk_user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');


         $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditlogs_table');
    }
};
