<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_cutis', function (Blueprint $table) {
            $table->id('id_cuti');  // Primary key
            $table->unsignedBigInteger('id_karyawan');  // Foreign key ke karyawan
            $table->date('tanggal_pengajuan');  // Tanggal pengajuan cuti
            $table->date('tanggal_mulai');  // Tanggal mulai cuti
            $table->date('tanggal_selesai');  // Tanggal selesai cuti
            $table->enum('status_cuti', ['disetujui', 'belum disetujui'])->default('belum disetujui');  // Status cuti
            $table->text('alasan_cuti');  // Alasan pengajuan cuti
            $table->timestamps();

            // Menambahkan foreign key ke tabel 'karyawans'
            $table->foreign('id_karyawan')
                  ->references('id_karyawan')  // Referensi ke kolom 'id_karyawan' di tabel 'karyawans'
                  ->on('karyawans')  // Tabel 'karyawans'
                  ->onDelete('cascade');  // Jika karyawan dihapus, permohonan cuti terkait juga dihapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_cutis');
    }
};