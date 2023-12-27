<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validation = validator($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            if (Auth::where('uname', $request->username)->count() > 0) {
                $hazCekUser = Auth::where('uname', $request->username)->first();

                if (password_verify($request->password, $hazCekUser['password'])) {
                    $data = [
                        'username' => $hazCekUser['uname'],
                        'lvl' => $hazCekUser['level'],
                        'userID' => $hazCekUser['user_id'],
                    ];

                    session($data);
                    $request->session()->regenerate();

                    return response()->json([
                        'success' => 'Login berhasil...',
                        'href' => redirect()->intended('/')
                    ]);
                }

                return response()->json(['error' => 'Login Gagal! Password salah...'])->setStatusCode(400);
            } else {
                return response()->json(['error' => 'Login gagal! Username tidak tersedia...'])->setStatusCode(400);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('auth');
    }

    public function registration()
    {
        return view('registration', [
            'title' => 'Registrasi Akun'
        ]);
    }

    public function cekdata(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'fielddata' => 'required|unique:login,uname',
                'password' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required_with:password|same:password'
            ],
            [
                'fielddata.required' => 'Silahkan isi data dengan benar!!!',
                'fielddata.unique' => 'Data yang Anda isi sudah ada!!!',
                'password.required' => 'Password tidak boleh kosong!!!',
                'password.min' => 'Password minimal :min karakter!!!',
                'password_confirmation.required_with' => 'Silahkan masukkan ulang password!!!',
                'password_confirmation.same' => 'Ulangi Password tidak cocok!!!',
            ]
        );

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $hazCekGuru = Guru::where('nuptk', $request->fielddata)->count();
            $hazCekSiswa = Siswa::where('nisn', $request->fielddata)->count();

            if ($hazCekGuru == 1) {
                $hazTampilData = Guru::where('nuptk', $request->fielddata)->first();
                $explode = explode('-', $hazTampilData['guru_id']);

                return response()->json([
                    'success' => 'Data berhasil ditemukan, Anda bernama ' . $hazTampilData['nama'],
                    'data' => $hazTampilData,
                    'username' => $hazTampilData['nuptk'],
                    'password' => $request->password,
                    'status' => ($explode[0] == 'gru') ? 'Guru' : 'Siswa',
                    'id' => $hazTampilData['guru_id'],
                ]);
            } else if ($hazCekSiswa == 1) {
                $hazTampilData = Siswa::where('nisn', $request->fielddata)->first();
                $explode = explode('-', $hazTampilData['siswa_id']);

                return response()->json([
                    'success' => 'Data berhasil ditemukan, Anda bernama ' . $hazTampilData['nama'],
                    'data' => $hazTampilData,
                    'username' => $hazTampilData['nisn'],
                    'password' => $request->password,
                    'status' => ($explode[0] == 'sw') ? 'Siswa' : 'Guru',
                    'id' => $hazTampilData['siswa_id']
                ]);
            } else {
                return response()->json(['error' => 'Tidak ada data yang ditemukan!!!'])->setStatusCode(400);
            }
        }
    }

    public function save(Request $request)
    {
        $hazInsertData = Auth::create([
            'login_id' => uniqid(),
            'uname' => $request->username,
            'password' => password_hash($request->password, PASSWORD_BCRYPT),
            'level' => $request->status,
            'user_id' => $request->id,
        ]);

        if ($hazInsertData) {
            return response()->json('Registrasi Akun berhasil...');
        } else {
            return response()->json(['error' => 'Registrasi Akun gagal!!!'])->setStatusCode(400);
        }
    }
}
