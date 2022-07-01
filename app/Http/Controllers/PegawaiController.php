<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::query()->get();
        $data = [
            'pegawai' => $pegawai
        ];

        return view('pages.pegawai.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:pegawai|numeric',
            'nama_pegawai' => 'required',
            "jenis_kelamin" => "required",
            "tempat_lahir" => "required",
            "tanggal_lahir" => "required",
            "alamat" => "required",
            "username" => "required:unique:pegawai",
            "password" => "required",
        ]);
        $pegawai = Pegawai::create([
            'nip' => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            "jenis_kelamin" => $request->jenis_kelamin,
            "tempat_lahir" => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "alamat" => $request->alamat,
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ]);

        return redirect()->back()->with('status', 'Data Pegawai Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = Pegawai::find($id);

        return response()->json(['data' => $pegawai]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'edit_nip' => 'required|numeric|unique:pegawai,nip,'.$id.',id_pegawai',
            'edit_nama_pegawai' => 'required',
            "edit_jenis_kelamin" => "required",
            "edit_tempat_lahir" => "required",
            "edit_tanggal_lahir" => "required",
            "edit_alamat" => "required",
            "edit_username" => "required:unique:pegawai,username,".$id.",id_pegawai",
        ]);

        $param = [
            'nip' => $request->edit_nip,
            'nama_pegawai' => $request->edit_nama_pegawai,
            "jenis_kelamin" => $request->edit_jenis_kelamin,
            "tempat_lahir" => $request->edit_tempat_lahir,
            "tanggal_lahir" => $request->edit_tanggal_lahir,
            "alamat" => $request->edit_alamat,
            "username" => $request->edit_username,
        ];
        if(!is_null($request->edit_password))
            $param['password'] = Hash::make($request->edit_password);

        $pegawai = Pegawai::query()->where('id_pegawai', '=', $id)->update($param);
        return redirect()->back()->with('status', 'Data Pegawai Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::query()->where('id_pegawai', '=', $id)->delete();
        return redirect()->back()->with('status', 'Data Pegawai Berhasil Dihapus');
    }
}
