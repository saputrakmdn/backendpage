<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function presensiMasuk(Request $request){
        $user = $request->user();
        $time = Carbon::now()->toTimeString();
        $presensi = new Presensi();
        $presensi->id_pegawai = $user->id_pegawai;
        $presensi->tanggal = date('Y-m-d');
        $presensi->jam_masuk = $time;
        $presensi->latitude = $request->latitude;
        $presensi->longtitude = $request->longtitude;
        $presensi->keterangan = "hadir";
        $presensi->save();

        return $presensi;
    }
}
