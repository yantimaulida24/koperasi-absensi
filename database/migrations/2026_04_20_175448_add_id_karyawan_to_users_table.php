<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_karyawan')->nullable()->after('id');

            $table->foreign('id_karyawan')
                  ->references('id_karyawan')
                  ->on('karyawans')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_karyawan']);
            $table->dropColumn('id_karyawan');
        });
    }
};
