<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\PresensiMasuk;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index(){
        return view('pages.presensi.index');
    }

    public function getData(Request $request){
        $explodeDate = explode(" - ", $request->date);
        $dataAbsen = PresensiMasuk::query()->select('nip', 'nama_pegawai', 'presensi_masuk.tanggal', 'jam_masuk', 'jam_pulang', 'presensi_masuk.keterangan')->join('pegawai', 'presensi_masuk.id_pegawai', '=', 'pegawai.id_pegawai')
            ->leftJoin('presensi_pulang', 'presensi_masuk.tanggal', '=', 'presensi_pulang.tanggal')
            ->whereBetween('presensi_masuk.tanggal', $explodeDate)->get();

        return response()->json(['data' => $dataAbsen]);
    }
}
