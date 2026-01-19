<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            // 🔥 WAJIB id_karyawan (BUKAN karyawan_id)
            $table->unsignedBigInteger('id_karyawan');

            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();

            $table->enum('status', ['Hadir'])->default('Hadir');

            $table->timestamps();

            $table->foreign('id_karyawan')
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