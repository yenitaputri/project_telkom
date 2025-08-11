<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('no_internet')->unique()->nullable();
            $table->string('no_digital')->nullable();
            $table->date('tanggal_ps')->nullable();
            $table->string('kecepatan')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->string('datel')->nullable();
            $table->string('ro')->nullable();
            $table->string('sto')->nullable();
            $table->string('nama')->nullable();
            $table->string('segmen')->nullable();
            $table->text('kcontact')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('channel_1')->nullable();
            $table->string('kode_sales')->nullable();
            $table->string('nama_sf')->nullable();
            $table->string('agency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
