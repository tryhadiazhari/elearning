<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\Ruang;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Data Siswa',
            'data' => Siswa::join('kelas', 'siswa.kelas_id', '=', 'kelas.kelas_id')->get(),
            'datakelas' => Ruang::orderBy('nama_kelas', 'ASC')->get(),
            'user' => (session('lvl') == 'Admin') ? '' : Siswa::where('siswa_id', session('userID'))->first()
        ];

        return view('siswa', $data);
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
            'nama' => 'required',
            'nisn' => 'required|unique:siswa',
            'nis' => 'required|unique:siswa',
            'jk' => 'required',
            'alamat' => 'required',
            'telp' => 'required|min:11|unique:siswa',
            'email' => 'required|email|unique:siswa',
            'kelas' => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!!!',
            'nisn.required' => 'NISN tidak boleh kosong!!!',
            'nisn.unique' => 'NISN sudah terdaftar!!!',
            'nis.required' => 'NIS tidak boleh kosong!!!',
            'nis.unique' => 'NIS sudah terdaftar!!!',
            'jk.required' => 'Jenis Kelamin wajib dipilih!!!',
            'alamat.required' => 'Alamat tidak boleh kosong!!!',
            'email.required' => 'Email tidak boleh kosong!!!',
            'email.email' => 'Format Email salah!!!',
            'email.unique' => 'Email sudah terdaftar!!!',
            'telp.required' => 'No. Telp tidak boleh kosong!!!',
            'telp.min' => 'No. Telp tidak boleh kurang dari :min angka',
            'telp.unique' => 'No. Telp sudah terdaftar!!!',
            'kelas.required' => 'Kelas wajib dipilih!!!',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors())->setStatusCode(404);
        } else {
            $hazInsert = Siswa::create([
                'siswa_id' => 'sw-' . time(),
                'nama' => ucwords($request->nama),
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'jk' => $request->jk,
                'alamat' => ucwords($request->alamat),
                'telp' => $request->telp,
                'email' => $request->email,
                'kelas_id' => $request->kelas
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan...'])->setStatusCode(400);
            }
        }
    }

    public function show(Siswa $siswa)
    {
        //
    }

    public function edit(Siswa $siswa)
    {
        //
        // $login = Login::all();

        $hazCariSiswa = $siswa->join('kelas', 'siswa.kelas_id', '=', 'kelas.kelas_id')->where('siswa_id', $siswa->siswa_id)->first();

        return response()->json([
            'nama' => $hazCariSiswa->nama,
            'nisn' => $hazCariSiswa->nisn,
            'nis' => $hazCariSiswa->nis,
            'jk' => $hazCariSiswa->jk,
            'alamat' => $hazCariSiswa->alamat,
            'email' => $hazCariSiswa->email,
            'telp' => $hazCariSiswa->telp,
            'kelas' => $hazCariSiswa->kelas_id,
        ]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $hazValidateData = Validator::make($request->all(), [
            'nama' => ($siswa->nama == $request->nama) ? 'required' : 'required',
            'nisn' => ($siswa->nis == $request->nisn) ? 'required' : 'unique:siswa,nisn,' . $siswa->siswa_id . ',siswa_id',
            'nis' => ($siswa->nis == $request->nis) ? 'required' : 'unique:siswa,nis,' . $siswa->siswa_id . ',siswa_id',
            'jk' => 'required',
            'alamat' => 'required',
            'telp' => ($siswa->telp == $request->telp) ? 'required' : 'required|min:11|unique:siswa,telp,' . $siswa->siswa_id . ',siswa_id',
            'email' => ($siswa->email == $request->email) ? 'required' : 'required|email:dns|unique:siswa,email,' . $siswa->siswa_id . ',siswa_id',
            'kelas' => ($siswa->kelas_id == $request->kelas) ? 'required' : 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!!!',
            'nisn.required' => 'NISN tidak boleh kosong!!!',
            'nisn.unique' => 'NISN sudah terdaftar!!!',
            'nis.required' => 'NIS tidak boleh kosong!!!',
            'nis.unique' => 'NIS sudah terdaftar!!!',
            'jk.required' => 'Jenis Kelamin wajib dipilih!!!',
            'alamat.required' => 'Alamat tidak boleh kosong!!!',
            'email.required' => 'Email tidak boleh kosong!!!',
            'email.email' => 'Format Email salah!!!',
            'email.unique' => 'Email sudah terdaftar!!!',
            'telp.required' => 'No. Telp tidak boleh kosong!!!',
            'telp.min' => 'No. Telp tidak boleh kurang dari :min angka',
            'telp.unique' => 'No. Telp sudah terdaftar!!!',
            'kelas.required' => 'Kelas wajib dipilih!!!',
        ]);


        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors()->toArray())->setStatusCode(404);
        } else {
            $hazUpdate = $siswa->update([
                'siswa_id' => $siswa->siswa_id,
                'nama' => $request->nama,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'jk' => $request->jk,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'email' => $request->email,
                'kelas_id' => $request->kelas
            ]);

            if ($hazUpdate) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json(['error' => 'Data gagal disimpan...'])->setStatusCode(400);
            }
        }
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->delete($siswa->siswa_id)) {
            Auth::where('user_id', $siswa->siswa_id)->delete();
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json('Data gagal dihapus!!!')->setStatusCode(400);
        }
    }
}
