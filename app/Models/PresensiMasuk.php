<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMasuk extends Model
{
    use HasFactory;
    protected $table = 'presensi_masuk';
    protected $primaryKey = 'id_presensi';
}
