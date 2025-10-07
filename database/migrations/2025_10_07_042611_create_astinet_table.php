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
    Schema::create('astinet', function (Blueprint $table) {
        $table->id();
        $table->string('kode_order')->unique();
        $table->string('sid')->nullable();
        $table->string('bandwidth');
        $table->string('nama_pelanggan');
        $table->string('nama_sales');
        $table->date('tanggal_complete')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astinet');
    }
};
