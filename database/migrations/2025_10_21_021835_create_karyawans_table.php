<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id(); // primary key, auto-increment
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kode_qr')->unique();
            $table->timestamps();
        });
    }

    /**
     * Undo migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};