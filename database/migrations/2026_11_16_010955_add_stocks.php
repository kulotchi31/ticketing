<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->string('fk_campus_id');
            $table->unsignedBigInteger('fk_provider_id');
            $table->string('item_name');
            $table->string('sku')->nullable();
            $table->string('category');
            $table->string('unit')->default('pcs');
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->timestamps();

            $table->foreign('fk_provider_id')
                  ->references('provider_id')
                  ->on('provider_table')
                  ->onDelete('cascade');

            $table->unique(['fk_campus_id', 'fk_provider_id', 'item_name'], 'stocks_campus_provider_item_unique');
            $table->index(['fk_campus_id', 'fk_provider_id']);
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id('movement_id');
            $table->unsignedBigInteger('fk_stock_id');
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->date('transaction_date');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('fk_stock_id')
                  ->references('stock_id')
                  ->on('stocks')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stocks');
    }
};