<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();  // Primary key untuk absensi
            $table->unsignedBigInteger('karyawan_id');  // Relasi dengan id_karyawan di karyawans
            $table->timestamp('waktu_masuk')->nullable();
            $table->enum('status', ['Masuk', 'Tidak Masuk'])->default('Masuk');  // Status kehadiran
            $table->timestamps();

            // Menambahkan foreign key yang mengarah ke karyawans
            $table->foreign('karyawan_id') // karyawan_id di absensis
                  ->references('id_karyawan') // id_karyawan di karyawans
                  ->on('karyawans') // Tabel karyawans
                  ->onDelete('cascade'); // Jika karyawan dihapus, absensi akan ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};