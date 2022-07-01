<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pegawai extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    protected $fillable = [
        'nip',
        'nama_pegawai',
        "jenis_kelanmin",
        "tempat_lahir",
        "tanggal_lahir",
        "alamat",
        "username",
        "password"
    ];
}
