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
            $table->string('no_internet')->nullable();
            $table->string('no_digital')->nullable();
            $table->date('tanggal_ps')->nullable();
            $table->string('kecepatan')->nullable();
            $table->string('regional')->nullable();
            $table->integer('bulan')->nullable();
            $table->integer('tahun')->nullable();
            $table->string('datel')->nullable();
            $table->string('ro')->nullable();
            $table->string('sto')->nullable();
            $table->string('nama')->nullable();
            $table->string('segmen')->nullable();
            $table->text('kcontact')->nullable();
            $table->string('channel')->nullable();
            $table->string('jenis_layanan')->nullable();
            $table->string('cek_netmonk')->nullable();
            $table->string('cek_pijar_mahir')->nullable();
            $table->string('cek_eazy_cam')->nullable();
            $table->string('cek_oca')->nullable();
            $table->string('cek_pijar_sekolah')->nullable();
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
