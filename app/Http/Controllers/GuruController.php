<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Guru',
            'data' => Guru::orderBy('nama', 'ASC')->get(),
            'user' => (session('lvl') == 'Admin') ? '' : Guru::where('guru_id', session('userID'))->first()
        ];

        return view('guru', $data);
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
     * @param  \App\Http\Requests\StoreGuruRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hazValidateData = Validator::make($request->all(), [
            'nama' => 'required',
            'nuptk' => 'required|unique:guru,nuptk|min:16',
            'jk' => 'required',
            'nip' => ($request->nip == '-') ? '' : 'required|unique:guru,nip|min:18'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!!!',
            'nuptk.required' => 'NUPTK tidak boleh kosong!!!',
            'nuptk.unique' => 'NUPTK sudah terdaftar!!!',
            'nuptk.min' => 'NUPTK tidak boleh kurang dari 16 angka!!!',
            'jk.required' => 'Jenis Kelamin wajib dipilih!!!',
            'nip.required' => 'NIP tidak boleh kosong!!!',
            'nip.unique' => 'NIP sudah terdaftar!!!',
            'nip.min' => 'NUPTK tidak boleh kurang dari 18 angka!!!',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors())->setStatusCode(404);
        } else {
            $hazInsert = Guru::create([
                'guru_id' => 'gru-' . time(),
                'nama' => ucwords($request->nama),
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'jk' => $request->jk,
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
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function edit(Guru $guru)
    {
        return response()->json($guru);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGuruRequest  $request
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guru $guru)
    {
        $hazValidateData = Validator::make($request->all(), [
            'nama' => ($guru->nama == $request->nama) ? 'required' : 'required',
            'nuptk' => ($guru->nip == $request->nip) ? 'required' : 'required|unique:guru,nuptk,' . $guru->guru_id . ',guru_id||min:16',
            'nip' => ($guru->nip == $request->nip) ? 'required' : ($request->nip == '-' ? '' : 'required|unique:guru,nip,' . $guru->guru_id . ',guru_id|min:18'),
            'jk' => 'required',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors()->toArray())->setStatusCode(404);
        } else {
            $hazUpdate = $guru->update([
                'guru_id' => $guru->guru_id,
                'nama' => ucwords($request->nama),
                'nuptk' => $request->nuptk,
                'nip' => $request->nip,
                'jk' => $request->jk,
            ]);

            if ($hazUpdate) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan...'])->setStatusCode(400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guru  $guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guru $guru)
    {
        if ($guru->delete($guru->guru_id)) {
            Auth::where('user_id', $guru->guru_id)->delete();
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json('Data gagal dihapus!!!')->setStatusCode(400);
        }
    }
}
