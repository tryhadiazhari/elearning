<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Ruang;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Kelas',
            'data' => Ruang::orderBy('nama_kelas', 'ASC')->get(),
            'user' => (session('lvl') == 'Admin') ? '' : (session('lvl') == 'Siswa' ? Siswa::where('siswa_id', session('userID'))->first() : Guru::where('guru_id', session('userID'))->first())
        ];

        return view('kelas', $data);
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
        $hazValidateData = Validator::make($request->all(), [
            'kode' => 'required|unique:kelas,kd_kelas',
            'namaKelas' => 'required|unique:kelas,nama_kelas',
        ], [
            'kode.required' => 'Kode Kelas tidak boleh kosong!!!',
            'kode.unique' => 'Kode Kelas sudah terdaftar!!!',
            'namaKelas.required' => 'Nama Kelas tidak boleh kosong!!!',
            'namaKelas.unique' => 'Nama Kelas sudah terdaftar!!!',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors()->toArray())->setStatusCode(404);
        } else {
            $hazInsert = Ruang::create([
                'kelas_id' => 'kls-' . time(),
                'kd_kelas' => strtoupper($request->kode),
                'nama_kelas' => ucwords($request->namaKelas),
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan...'])->setStatusCode(400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ruang  $ruang
     * @return \Illuminate\Http\Response
     */
    public function show(Ruang $ruang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ruang  $ruang
     * @return \Illuminate\Http\Response
     */
    public function edit(Ruang $ruang)
    {
        $hazCariKelas = Ruang::find($ruang->kelas_id);

        return response()->json([
            'kode' => $hazCariKelas->kd_kelas,
            'namaKelas' => $hazCariKelas->nama_kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ruang  $ruang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ruang $ruang)
    {
        $hazValidateData = Validator::make($request->all(), [
            'kode' => ($ruang->kd_kelas == $request->kode) ? 'required' : 'required|unique:kelas,kd_kelas',
            'namaKelas' => ($ruang->nama_kelas == $request->namaKelas) ? 'required' : 'required|unique:kelas,nama_kelas,' . $ruang->kelas_id . ',kelas_id',
        ], [
            'kode.required' => 'Kode Kelas tidak boleh kosong!!!',
            'kode.unique' => 'Kode Kelas sudah terdaftar!!!',
            'namaKelas.required' => 'Nama Kelas tidak boleh kosong!!!',
            'namaKelas.unique' => 'Nama Kelas sudah terdaftar!!!',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors())->setStatusCode(404);
        } else {
            $hazInsert = $ruang->update([
                'kelas_id' => $ruang->kelas_id,
                'kd_kelas' => strtoupper($request->kode),
                'nama_kelas' => ucwords($request->namaKelas),
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan...'])->setStatusCode(400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruang  $ruang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ruang $ruang)
    {
        if (Ruang::destroy($ruang->kelas_id)) {
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json('Data gagal dihapus!!!')->setStatusCode(400);
        }
    }
}
