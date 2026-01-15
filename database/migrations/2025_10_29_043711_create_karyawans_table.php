<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->unsignedBigInteger('id_jabatan');
            $table->string('nama_karyawan')->unique();
            $table->string('no_telepon')->nullable()->unique();
            $table->string('alamat')->nullable();
            $table->string('kode_qr')->nullable();
            $table->timestamps();

            $table->foreign('id_jabatan')
                  ->references('id_jabatan')
                  ->on('jabatans')
                  ->onDelete('cascade');
        });

        // 🔥 LANGSUNG UPDATE KODE QR (SESUAI PERMINTAAN)
        DB::statement("
            UPDATE karyawans
            SET kode_qr = CONCAT('KRY-', id_karyawan)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};