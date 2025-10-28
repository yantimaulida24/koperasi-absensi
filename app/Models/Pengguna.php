<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $timestamps = false;

    protected $fillable = [
        'nama_pengguna',
        'username',
        'password',
        'no_telepon',
        'role'
    ];

    protected $hidden = [
        'password'
    ];

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'id_pengguna', 'id_pengguna');
    }
}
