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
        $table->unsignedBigInteger('karyawan_id');
        $table->time('waktu_masuk')->nullable();
        $table->time('waktu_keluar')->nullable();
        $table->timestamps();

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