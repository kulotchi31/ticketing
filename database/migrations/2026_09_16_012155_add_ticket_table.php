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
        Schema::create('ticket_table', function (Blueprint $table) {
            $table->bigIncrements('ticket_id');
            $table->timestamps();
            $table->string('ticket_number')->collation('utf8mb4_unicode_ci');
            $table->string('remarks');
            $table->string('acknowledge_by')->nullable();
            $table->string('requested_by')->nullable();
            $table->string('estimated_time')->nullable();

            $table->unsignedBigInteger('fk_department_id');
            $table->unsignedBigInteger('fk_category_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('assign_to')->nullable();
            $table->enum('status', [
                'For Approval',
                'Accepted',
                'Working',
                'Pending Done',
            ])->default('For Approval');

            $table->enum('classification', [
                'High',
                'Medium',
            
            ])->nullable();

            $table->string('is_walk_in')->nullable();

            $table->foreign('fk_department_id')->references('department_id')->on('department_table')->onDelete('cascade');
            $table->foreign('fk_category_id')->references('category_id')->on('category_table')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_table');
    }
};
