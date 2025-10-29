<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';  // Nama tabel
    protected $primaryKey = 'id_karyawan';  // Primary key
    public $timestamps = true;  // Gunakan timestamps

    protected $fillable = [
        'id_user',  // Relasi ke pengguna (users)
        'id_jabatan', // Relasi ke jabatan (jabatans)
        'nama_karyawan',
        'no_telepon',
        'alamat',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');  // Relasi 'id_user' di karyawan berelasi dengan 'id' di users
    }

    /**
     * Relasi ke tabel jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');  // Relasi 'id_jabatan' di karyawan berelasi dengan 'id_jabatan' di jabatan
    }
}