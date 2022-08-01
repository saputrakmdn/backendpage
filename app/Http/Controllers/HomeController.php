<?php

namespace App\Http\Controllers;

use App\Models\IzinKeluar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalIzin =  IzinKeluar::query()->join('presensi_masuk', 'izin_keluar.id_presensi', '=', 'presensi_masuk.id_presensi')->where('presensi_masuk.tanggal', '=', date('Y-m-d'))->count();
        $data = [
            'total_izin' => $totalIzin
        ];
        return view('home', $data);
    }
}
