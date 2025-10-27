<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = ['karyawan_id', 'waktu_masuk'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
