<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Membuat tabel 'karyawans'
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id('id_karyawan');  // Kolom primary key
            $table->unsignedBigInteger('id_user');  // Kolom foreign key untuk relasi dengan tabel 'users'
            $table->unsignedBigInteger('id_jabatan')->nullable();  // Kolom foreign key untuk relasi dengan tabel 'jabatans'
            $table->string('nama_karyawan');
            $table->string('no_telepon')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamps();

            // Menambahkan foreign key ke tabel 'users'
            $table->foreign('id_user')
                  ->references('id')  // Kolom 'id' di tabel 'users'
                  ->on('users')  // Tabel 'users'
                  ->onDelete('cascade');  // Jika user dihapus, maka karyawan terkait akan dihapus

            // Menambahkan foreign key ke tabel 'jabatans'
            $table->foreign('id_jabatan')
                  ->references('id_jabatan')  // Kolom 'id_jabatan' di tabel 'jabatans'
                  ->on('jabatans')  // Tabel 'jabatans'
                  ->onDelete('set null');  // Jika jabatan dihapus, kolom 'id_jabatan' di karyawan menjadi NULL
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'karyawans'
        Schema::dropIfExists('karyawans');
    }
};