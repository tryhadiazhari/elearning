<?php

namespace App\Http\Controllers;

use App\Models\ForumDiskusi;
use App\Models\ForumDiskusiReply;
use App\Models\Guru;
use App\Models\Matpel;
use App\Models\Siswa;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ForumDiscussController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hazUser = (session('lvl') == 'Guru') ? Guru::where('guru_id', session('userID'))->first() : Siswa::where('siswa_id', session('userID'))->first();

        if (session('lvl') == 'Guru') {
            $data = [
                'title' => 'Forum Diskusi',
                'user' => $hazUser,
                'datamapel' => Matpel::join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')->where('guru_id', session('userID'))->orderBy('nama_mapel', 'ASC')->get(),
                'dataforum' => ForumDiskusi::join('mapel', 'forum_diskusi.forum_kelas_id', '=', 'mapel.kelas_id')
                    ->join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')
                    ->join('siswa', 'forum_diskusi.forum_user_id', '=', 'siswa.siswa_id')
                    ->where('forum_guru_id', $hazUser->guru_id)
                    ->get(),
            ];
        } else {

            $data = [
                'title' => 'Forum Diskusi',
                'user' => Siswa::where('siswa_id', session('userID'))->first(),
                'datamapel' => Matpel::join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')->where('mapel.kelas_id', $hazUser['kelas_id'])->orderBy('nama_mapel', 'ASC')->get(),
                'dataforum' => ForumDiskusi::where('forum_user_id', $hazUser['siswa_id'])->get(),
            ];
        }

        return view('forum', $data);
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
        $explode = explode(' - ', $request->kelas);
        $hazCekKelas = Matpel::where('kelas_id', $explode[1])->first();

        $hazValidateData = Validator::make($request->all(), [
            'judul' => 'required',
            'kelas' => 'required',
            'isidiskusi' => 'required',
        ], [
            'judul.required' => 'Judul tidak boleh kosong!!!',
            'kelas.required' => 'Kelas wajib dipilih!!!',
            'isidiskusi.required' => 'Isi diskusi tidak boleh kosong!!!',
        ]);

        if ($hazValidateData->fails()) {
            return response()->json($hazValidateData->errors()->toArray())->setStatusCode(404);
        } else {
            // return $request->isidiskusi;
            $hazInsert = ForumDiskusi::create([
                'forum_user_id' => session('userID'),
                'forum_guru_id' => $hazCekKelas->guru_id,
                'forum_kd_mapel' => $explode[0],
                'forum_kelas_id' => $explode[1],
                'forum_judul' => $request->judul,
                'forum_text' => $request->isidiskusi,
                'updated_at' => null
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan']);
            } else {
                return response()->json([['error' => 'Data gagal disimpan!!!']])->setStatusCode(400);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ForumDiskusi $forumDiskusi, $id)
    {
        $hazUser = (session('lvl') == 'Guru') ? Guru::where('guru_id', session('userID'))->first() : Siswa::where('siswa_id', session('userID'))->first();

        if (session('lvl') == 'Guru') {
            $data = [
                'title' => 'Forum Diskusi',
                'user' => Guru::where('guru_id', session('userID'))->first(),
                'dataforum' => ForumDiskusi::join('kelas', 'forum_diskusi.forum_kelas_id', '=', 'kelas.kelas_id')->where('id', $id)->first(),
                'forumreply' => ForumDiskusiReply::join('forum_diskusi', 'forum_diskusi_reply.forum_id', '=', 'forum_diskusi.id')->where('forum_id', $id)->get()
            ];
        } else {
            $data = [
                'title' => 'Forum Diskusi',
                'user' => Siswa::where('siswa_id', session('userID'))->first(),
                'dataforum' => ForumDiskusi::join('kelas', 'forum_diskusi.forum_kelas_id', '=', 'kelas.kelas_id')->where('id', $id)->first(),
                'forumreply' => ForumDiskusiReply::join('forum_diskusi', 'forum_diskusi_reply.forum_id', '=', 'forum_diskusi.id')->where('forum_id', $id)->get()
            ];
        }

        return view('forum-chat', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reply(Request $request, $id)
    {
        $hazCekData = ForumDiskusi::where('id', $id)->first();
        $hazUser = (session('lvl') == 'Guru') ? Guru::where('guru_id', session('userID'))->first() : Siswa::where('siswa_id', session('userID'))->first();

        $hazValidate = Validator::make($request->all(), [
            'reply' => 'required'
        ], [
            'reply.required' => '<i>Kolom tidak boleh kosong</i>'
        ]);

        if ($hazValidate->fails()) {
            return response()->json($hazValidate->errors())->setStatusCode(404);
        } else {
            $hazInsert = ForumDiskusiReply::create([
                'forum_id' => $id,
                'from' => $hazUser->nama,
                'discussing' => $request->reply,
                'updated_at' => null
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan...']);
            }

            return response()->json(['error' => 'Data gagal disimpan!!!'])->setStatusCode(400);
        }
    }
}
