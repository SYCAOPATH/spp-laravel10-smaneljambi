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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->integer('id_pembayaran')->autoIncrement();
            $table->integer('id_petugas')->nullable();
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('SET NULL')->onUpdate('SET NULL')->nullable();
            $table->string('nisn', 10)->nullable();
            $table->foreign('nisn')->references('nisn')->on('siswa')->onDelete('SET NULL')->onUpdate('SET NULL')->nullable();
            $table->date('tgl_bayar');
            $table->string('bulan_dibayar', 20);
            $table->string('tahun_dibayar', 4);
            $table->integer('id_spp')->nullable();
            $table->foreign('id_spp')->references('id_spp')->on('spp')->onDelete('SET NULL')->onUpdate('SET NULL')->nullable();
            $table->integer('jumlah_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
