<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'jabatan', 'kode_qr'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
