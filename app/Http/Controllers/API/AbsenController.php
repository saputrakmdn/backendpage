<?php

namespace App\Http\Controllers\API;

use App\Events\NotificationIzin;
use App\Http\Controllers\Controller;
use App\Models\IzinKeluar;
use App\Models\Presensi;
use App\Models\PresensiMasuk;
use App\Models\PresensiPulang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function presensiMasuk(Request $request){
        $user = $request->user();
        $time = Carbon::now()->toTimeString();
        $checkIfAbsen = PresensiMasuk::query()->where('tanggal', '=', date('Y-m-d'))->where('id_pegawai', '=', $user->id_pegawai)->first();

        if(!is_null($checkIfAbsen))
            return response(["message"=>"Anda Sudah Melakukan Absen"], 423);
        if($time < "08:30:00"){
            if ($time < "08:00:00")
                $keterangan = "hadir";
            else
                $keterangan = "telat";

            $presensi = new PresensiMasuk();
            $presensi->id_pegawai = $user->id_pegawai;
            $presensi->tanggal = date('Y-m-d');
            $presensi->jam_masuk = $time;
            $presensi->latitude = $request->latitude;
            $presensi->longtitude = $request->longtitude;
            $presensi->keterangan = $keterangan;
            $presensi->save();

            return response($presensi,200);
        }else{
            return response(["message"=>"Absen sudah ditutup"], 423);
        }
    }

    public function presensiPulang(Request $request){
        $user = $request->user();
        $time = Carbon::now()->toTimeString();
        $checkIfAbsen = PresensiPulang::query()->where('tanggal', '=', date('Y-m-d'))->where('id_pegawai', '=', $user->id_pegawai)->first();
        if(!is_null($checkIfAbsen))
            return response(["message"=>"Anda Sudah Melakukan Absen"], 423);

        if($time > "15:00:00"){
            $keterangan = "";

            $presensi = new PresensiPulang();
            $presensi->id_pegawai = $user->id_pegawai;
            $presensi->tanggal = date('Y-m-d');
            $presensi->jam_pulang = $time;
            $presensi->latitude = $request->latitude;
            $presensi->longtitude = $request->longtitude;
            $presensi->keterangan = $keterangan;
            $presensi->save();

            return response($presensi,200);
        }else{
            return response(["message"=>"Absen pulang belum dibuka"], 423);
        }
    }

    public function izinKeluar(Request $request){
        $izin = new IzinKeluar();
        $izin->id_presensi = $request->id_presensi;
        $izin->keterangan = $request->keterangan;
        $izin->jam_izin = Carbon::now()->toTimeString();
        $izin->status_izin = 0;
        $izin->save();

        $result = IzinKeluar::query()->select('izin_keluar.*', 'pegawai.nama_pegawai')->join('presensi_masuk', 'izin_keluar.id_presensi', '=', 'presensi_masuk.id_presensi')
            ->join('pegawai', 'presensi_masuk.id_pegawai', '=', 'pegawai.id_pegawai')->where('id_izin_keluar', '=', $izin->id_izin_keluar)->first()->toArray();
//        dd($result);

        event(new NotificationIzin($result));
        return response($result,200);

    }

}
