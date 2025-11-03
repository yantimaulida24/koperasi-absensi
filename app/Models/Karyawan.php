<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';
    protected $primaryKey = 'id_karyawan';
    protected $fillable = [
        'id_jabatan',
        'nama_karyawan',
        'no_telepon',
        'alamat',
        'kode_qr'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
