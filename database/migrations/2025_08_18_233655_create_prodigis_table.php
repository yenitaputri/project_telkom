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
        Schema::create('prodigi', function (Blueprint $table) {
            $table->id();
            $table->string('nd')->nullable();
            $table->string('order_id')->nullable();
            $table->string('tanggal_ps')->nullable();
            $table->string('telda')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('paket')->nullable();
            $table->string('witel')->nullable();
            $table->string('rev')->nullable();
            $table->string('device')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodigi');
    }
};
