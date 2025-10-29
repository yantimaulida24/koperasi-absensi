<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jabatan';  // Tentukan primary key

    public $timestamps = true;  // Aktifkan timestamps (created_at, updated_at)

    protected $fillable = ['nama_jabatan'];  // Kolom yang bisa diisi

    /**
     * Relasi satu ke banyak dengan Karyawan
     */
    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id_jabatan', 'id_jabatan');
    }
}