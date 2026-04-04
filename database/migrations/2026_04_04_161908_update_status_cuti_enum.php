<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonan_cutis', function (Blueprint $table) {
            $table->enum('status_cuti', ['disetujui', 'belum disetujui', 'ditolak'])
                  ->default('belum disetujui')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_cutis', function (Blueprint $table) {
            $table->enum('status_cuti', ['disetujui', 'belum disetujui'])
                  ->default('belum disetujui')
                  ->change();
        });
    }
};