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
            $table->string('no_internet')->unique();
            $table->string('no_digital');
            $table->date('tanggal_ps');
            $table->string('kecepatan');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('datel');
            $table->string('ro');
            $table->string('sto');
            $table->string('nama');
            $table->string('segmen');
            $table->text('kcontact');
            $table->string('jenis_layanan');
            $table->string('channel_1');
            $table->string('kode_sales');
            $table->string('nama_sf');
            $table->string('agency');
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
