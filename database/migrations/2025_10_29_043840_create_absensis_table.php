<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id(); // Primary key absensi

            $table->unsignedBigInteger('karyawan_id'); // Relasi ke karyawans

            // 👉 TANGGAL ABSENSI
            $table->date('tanggal');

            // Waktu absensi (jam saja)
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();

            // Status hanya "Hadir"
            $table->enum('status', ['Hadir'])->default('Hadir');

            $table->timestamps();

            // Foreign key
            $table->foreign('karyawan_id')
                  ->references('id_karyawan')
                  ->on('karyawans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};