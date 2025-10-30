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
        Schema::create('sales_product_targets', function (Blueprint $table) {
            $table->id();
            $table->string('product');
            $table->integer('tahun');
            $table->integer('target')->default(0);
            $table->integer('ach')->default(0);
            $table->integer('sk')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_product_targets');
    }
};
