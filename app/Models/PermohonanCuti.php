<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanCuti extends Model
{
    protected $table = 'permohonan_cutis'; // sesuaikan dengan nama tabel di DB
    protected $fillable = [
        'id_karyawan', 'tanggal_pengajuan', 'tanggal_mulai',
        'tanggal_selesai', 'status_cuti', 'alasan'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function user()
    {
    return $this->belongsTo(User::class, 'id_karyawan', 'id');
    }

}
