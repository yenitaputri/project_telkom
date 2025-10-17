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
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->enum('target_type', ['agency', 'prodigi', 'sales']);
            $table->integer("bulan")->nullable();
            $table->integer("tahun");
            $table->string('target_ref');
            $table->integer("target_value");
            $table->timestamps();

            $table->unique(['target_type', 'target_ref', 'tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};
