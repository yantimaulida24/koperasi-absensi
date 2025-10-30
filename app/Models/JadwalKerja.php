<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kerjas';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'hari_kerja',
        'jam_masuk',
        'jam_keluar'
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_jadwal');
    }
}
