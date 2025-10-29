<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    // Nama tabel
    protected $table = 'karyawans'; // pastikan ini sesuai nama tabel di database

    // Primary key
    protected $primaryKey = 'id_karyawan';
    public $incrementing = true;
    protected $keyType = 'int';

    // Mass assignable
    protected $fillable = [
        'id_pengguna',
        'id_jabatan',
        'nama_karyawan',
        'no_telepon',
        'alamat'
    ];

    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    // Relasi ke jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    // Relasi ke permohonan cuti
    public function cuti()
    {
        return $this->hasMany(PermohonanCuti::class, 'id_karyawan', 'id_karyawan');
    }
}
