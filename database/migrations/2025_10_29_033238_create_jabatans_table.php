<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Buat tabel 'jabatans' yang benar
        Schema::create('jabatans', function (Blueprint $table) {
            $table->id('id_jabatan');  // Kolom primary key untuk jabatan
            $table->string('nama_jabatan'); // Nama jabatan
            $table->timestamps();  // Timestamps untuk created_at dan updated_at
        });
    }

    public function down(): void
    {
        // Hapus tabel 'jabatans'
        Schema::dropIfExists('jabatans');
    }
};