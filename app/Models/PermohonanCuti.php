<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanCuti extends Model
{
    protected $table = 'permohonan_cutis';
    protected $primaryKey = 'id_cuti'; // primary key
    public $timestamps = true;

    protected $fillable = [
        'id_karyawan',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_cuti',
        'alasan_cuti',
    ];

    // Relasi ke karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}