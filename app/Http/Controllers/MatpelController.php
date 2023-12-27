<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Matpel;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatpelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'data' => (session('lvl') == 'Admin') ? Matpel::join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')->join('guru', 'mapel.guru_id', '=', 'guru.guru_id')->orderBy('kelas.nama_kelas', 'ASC')->orderBy('mapel.nama_mapel', 'ASC')->get() : Matpel::where('guru.guru_id', session('userID'))->join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')->join('guru', 'mapel.guru_id', '=', 'guru.guru_id')->orderBy('mapel.nama_mapel', 'ASC')->orderBy('kelas.nama_kelas', 'ASC')->get(),
            'dataguru' => (session('lvl') == 'Admin') ? Guru::orderBy('nama', 'ASC')->get() : Guru::where('guru_id', session('userID'))->get(),
            'datakelas' => Ruang::orderBy('nama_kelas', 'ASC')->get(),
            'user' => Guru::where('guru_id', session('userID'))->first()
        ];

        return view('mapel', $data);
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
    public function store(Matpel $matpel, Request $request)
    {
        $cekKodeMapel = $matpel->where([
            'kelas_id' => $request->kelas,
            'kd_mapel' => $request->kodemapel
        ])->count();

        $cekMapel = $matpel->where([
            'kelas_id' => $request->kelas,
            'nama_mapel' => $request->namamapel
        ])->count();

        $validation = Validator::make($request->all(), [
            'kodemapel' => ($cekKodeMapel == 0) ? 'required' : 'required|unique:mapel,kd_mapel',
            'namamapel' => ($cekMapel == 0) ? 'required' : 'required|unique:mapel,nama_mapel',
            'kelas' => 'required',
            'guru' => 'required',
        ], [
            'kodemapel.required' => 'Kode Mata Pelajaran tidak boleh kosong!!!',
            'kodemapel.unique' => 'Kode Mata Pelajaran sudah terdaftar!!!',
            'namamapel.required' => 'Nama Mata Pelajaran tidak boleh kosong!!!',
            'namamapel.unique' => 'Nama Mata Pelajaran sudah terdaftar!!!',
            'kelas.required' => 'Kelas wajib dipilih!!!',
            'guru.required' => 'Guru wajib dipilih!!!',
            'guru.unique' => 'Nama Mata Pelajaran sudah terdaftar!!!',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $hazInsert = $matpel->create([
                'mapel_id' => 'mp-' . time(),
                'kd_mapel' => strtoupper($request->kodemapel),
                'nama_mapel' => ucwords($request->namamapel),
                'kelas_id' => $request->kelas,
                'guru_id' => $request->guru
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan...']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan!!!'])->setStatusCode(400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matpel  $matpel
     * @return \Illuminate\Http\Response
     */
    public function show(Matpel $matpel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matpel  $matpel
     * @return \Illuminate\Http\Response
     */
    public function edit(Matpel $matpel)
    {
        return response()->json([
            'kodemapel' => $matpel->kd_mapel,
            'namamapel' => $matpel->nama_mapel,
            'kelas' => $matpel->kelas_id,
            'guru' => $matpel->guru_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matpel  $matpel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matpel $matpel)
    {
        $cekKodeMapel = $matpel->where([
            'kelas_id' => $request->kelas,
            'kd_mapel' => $request->kodemapel
        ])->count();

        $cekMapel = $matpel->where([
            'kelas_id' => $request->kelas,
            'nama_mapel' => $request->namamapel
        ])->count();

        $validation = Validator::make($request->all(), [
            'kodemapel' => ($request->kodemapel == $matpel->kd_mapel) ? 'required' : (($cekKodeMapel == 0) ? 'required' : 'required|unique:mapel,kd_mapel'),
            'namamapel' => ($request->namamapel == $matpel->nama_mapel) ? 'required' : (($cekMapel == 0) ? 'required' : 'required|unique:mapel,nama_mapel'),
            'kelas' => 'required',
            'guru' => 'required',
        ], [
            'kodemapel.required' => 'Kode Mata Pelajaran tidak boleh kosong!!!',
            'kodemapel.unique' => 'Kode Mata Pelajaran sudah terdaftar!!!',
            'namamapel.required' => 'Nama Mata Pelajaran tidak boleh kosong!!!',
            'namamapel.unique' => 'Nama Mata Pelajaran sudah terdaftar!!!',
            'kelas.required' => 'Kelas wajib dipilih!!!',
            'guru.required' => 'Guru wajib dipilih!!!',
            'guru.unique' => 'Nama Mata Pelajaran sudah terdaftar!!!',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $hazUpdate = $matpel->update([
                'mapel_id' => $matpel->mapel_id,
                'kd_mapel' => strtoupper($request->kodemapel),
                'nama_mapel' => ucwords($request->namamapel),
                'kelas_id' => $request->kelas,
                'guru_id' => $request->guru
            ]);

            if ($hazUpdate) {
                return response()->json(['success' => 'Data berhasil disimpan...']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan!!!'])->setStatusCode(400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matpel  $matpel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matpel $matpel)
    {
        if ($matpel->delete($matpel->siswa_id)) {
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json('Data gagal dihapus!!!')->setStatusCode(400);
        }
    }
}
