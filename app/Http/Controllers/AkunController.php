<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Pengaturan Akun',
            'user' => Auth::where('user_id', session('userID'))->first()
        ];

        return view('akun', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auth $auth)
    {
        $validation = Validator::make($request->all(), [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
        ], [
            'old_password.required' => 'Masukkan password lama Anda',
            'old_password.min' => 'Password lama minimal :min karakter',
            'new_password.required' => 'Masukkan password baru Anda',
            'new_password.min' => 'Password minimal :min karakter!!!'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $hazCekOldPassword = $auth->where('uname', $request->username)->first();

            if (password_verify($request->old_password, $hazCekOldPassword->password)) {
                $hazUpdate = $auth->where('uname', $request->username)->update([
                    'password' => password_hash($request->new_password, PASSWORD_BCRYPT)
                ]);

                if ($hazUpdate) {
                    return response()->json('Password berhasil diganti...');
                } else {
                    return response()->json('Password gagal diganti...')->setStatusCode(400);
                }
            }
            return response()->json(['old_password' => 'Password lama tidak sesuai atau salah!!!'])->setStatusCode(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auth $auth)
    {
        //
    }
}
