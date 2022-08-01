<?php

namespace App\Http\Controllers;

use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index(){
        $result = IzinKeluar::query()->select('izin_keluar.*', 'pegawai.nama_pegawai', 'pegawai.nip')->join('presensi_masuk', 'izin_keluar.id_presensi', '=', 'presensi_masuk.id_presensi')
            ->join('pegawai', 'presensi_masuk.id_pegawai', '=', 'pegawai.id_pegawai')->where('presensi_masuk.tanggal', '=', date('Y-m-d'))->get();
        $data = [
          'data_izin' => $result
        ];

        return view('pages.izin_keluar.index', $data);
    }

    public function updateStatus(Request $request){
        $izin = IzinKeluar::query()->where('id_izin_keluar', '=', $request->id)->update(['status_izin' => $request->status]);
        if($request->ajax())
            return $izin;
        else
            return redirect()->back();
    }
}
