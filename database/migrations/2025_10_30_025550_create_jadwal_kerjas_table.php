<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kerjas', function (Blueprint $table) {
            $table->id('id_jadwal');
            
            // Relasi ke tabel karyawan (pastikan kolom di tabel karyawans bernama id_karyawan)
            $table->unsignedBigInteger('id_karyawan')->nullable();
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
            
            // Data jadwal kerja
            $table->string('hari_kerja');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kerjas');
    }
};