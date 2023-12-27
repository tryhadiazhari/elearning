<?php

namespace App\Http\Controllers;

use App\Models\Bahanajar;
use App\Models\Guru;
use App\Models\Matpel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BahanAjarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('lvl') == 'Guru') {
            $data = [
                'title' => 'Data Bahan Ajar',
                'data' => Bahanajar::join('mapel', 'materibelajar.mapel_id', '=', 'mapel.kd_mapel')
                    ->join('kelas', 'materibelajar.kelas_id', '=', 'kelas.kd_kelas')
                    ->select('materibelajar.materi_id', 'materibelajar.nama_materi', 'materibelajar.nama_file', 'materibelajar.deskripsi', 'mapel.kd_mapel as mapel', 'kelas.kd_kelas as kelas', 'materibelajar.created_date')
                    ->where('materibelajar.created_by', session('userID'))
                    ->groupBy(
                        'materibelajar.materi_id',
                        'materibelajar.nama_materi',
                        'materibelajar.nama_file',
                        'materibelajar.deskripsi',
                        'mapel.kd_mapel',
                        'kelas.kd_kelas',
                        'materibelajar.created_by',
                        'materibelajar.created_date',
                    )
                    ->get(),
                'datamapel' => Matpel::join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')->where('guru_id', session('userID'))->orderBy('mapel.nama_mapel', 'ASC')->orderBy('kelas.nama_kelas', 'ASC')->get(),
                'user' => Guru::where('guru_id', session('userID'))->first()
            ];

            return view('bahanajar', $data);
        }

        $hazUser = Siswa::where('siswa_id', session('userID'))->first();

        $data = [
            'title' => 'Data Bahan Ajar',
            'data' => Bahanajar::all(),
            'datamapel' => Matpel::join('kelas', 'mapel.kelas_id', '=', 'kelas.kelas_id')
                ->where('kelas.kelas_id', $hazUser['kelas_id'])
                ->orderBy('mapel.kelas_id', 'ASC')
                ->orderBy('mapel.nama_mapel', 'ASC')
                ->get(),
            'user' => $hazUser
        ];

        return view('materibelajar', $data);
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
    public function store(Bahanajar $bahanajar, Request $request)
    {
        $cekMapel = $bahanajar->where([
            'kelas_id' => $request->mapel,
        ])->count();

        $validation = Validator::make($request->all(), [
            'mapel' => 'required',
            'judulmateri' => ($cekMapel == 0) ? 'required' : 'required|unique:materibelajar,nama_materi',
            'deskripsi' => 'required',
            'file' => 'required'
        ], [
            'mapel.required' => 'Mata Pelajaran wajib dipilih!!!',
            'judulmateri.required' => 'Judul Materi tidak boleh kosong!!!',
            'judulmateri.unique' => 'Judul sudah ada!!!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!!!',
            'file.required' => 'Pilih file yang akan di upload!!!'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $explode = explode('-', $request->file);
            $explode2 = explode(' - ', $request->mapel);

            $hazInsert = Bahanajar::create([
                'materi_id' => $explode[0],
                'nama_materi' => $request->judulmateri,
                'nama_file' => $request->file,
                'deskripsi' => $request->deskripsi,
                'mapel_id' => $explode2[0],
                'kelas_id' => $explode2[1],
                'created_by' => session('userID'),
                'created_date' => date('Y-m-d'),
            ]);

            if ($hazInsert) {
                return response()->json(['success' => 'Data berhasil disimpan...']);
            }

            return response()->json(['error' => 'Data gagal disimpan!!!'])->setStatusCode(400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanAjar  $bahanAjar
     * @return \Illuminate\Http\Response
     */
    public function show(Bahanajar $bahanajar)
    {
        $user = (session('lvl') == 'Siswa') ? Siswa::where('siswa_id', session('userID'))->first() : Guru::where('guru_id', session('userID'))->first();

        $data = '
            <hr>
            <div class="row">
                <div class="col-12">';

        $explode = explode('.', $bahanajar['nama_file']);

        $data .= '
                    <div class="col-12 pr-0 my-0 mb-3" align="right">
                        <button class="btn btn-primary btn-sm btn-refresh"><i class="fa fa-arrow-left"></i> Kembali</button>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <label class="card-title my-0 fs-3 fw-normal">' . $bahanajar['nama_materi'] . '</label>
                        </div>
                        
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-auto mt-2">Post By <label class="text-primary">' . $user['nama'] . '</label></div>
                                <div class="col-auto mt-2 ml-auto">
                                    <i class="fas fa-calendar fa-fw"></i> ' . date('d/m/Y', strtotime($bahanajar['created_date'])) . '
                                </div>

                                <div class="col-12 my-2 text-justify">' . $bahanajar['deskripsi'] . '</div>

                                <div class="col-12 my-2">';
        if ($explode[1] == 'mp4') {
            $data .= '
                                    <div class="ratio ratio-16x9">
                                        <video controls>
                                            <source src="' . asset('files/' . $bahanajar['nama_file']) . '" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>';
        } else {
            $data .= '
                                    <a href="' . asset('files/' . $bahanajar['nama_file']) . '" class="" target="_blank">' . $bahanajar['nama_file'] . '</a>';
        }


        $data .= '
                                </div>
                            </div>
                        </div>
                    </div>';

        $data .= '
                </div>
            </div>';

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanAjar  $bahanAjar
     * @return \Illuminate\Http\Response
     */
    public function edit(Bahanajar $bahanajar)
    {
        session(['materiID' => $bahanajar->materi_id]);

        return response()->json([
            'mapel' => $bahanajar->mapel_id . ' - ' . $bahanajar->kelas_id,
            'judulmateri' => $bahanajar->nama_materi,
            'deskripsi' => $bahanajar->deskripsi,
            'filename' => $bahanajar->nama_file,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BahanAjar  $bahanAjar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $bahanajar = Bahanajar::where('materi_id', session('materiID'))->first();

        $validation = Validator::make($request->all(), [
            'mapel' => ($bahanajar->kelas_id == $request->mapel) ? 'required' : 'required',
            'judulmateri' => ($bahanajar->nama_materi == $request->judulmateri) ? 'required' : 'required|unique:materibelajar,nama_materi,' . $bahanajar->materi_id . ',materi_id',
            'deskripsi' => ($bahanajar->deskripsi == $request->deskripsi) ? 'required' : 'required',
        ], [
            'mapel.required' => 'Mata Pelajaran wajib dipilih!!!',
            'judulmateri.required' => 'Judul Materi tidak boleh kosong!!!',
            'judulmateri.unique' => 'Judul sudah ada!!!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!!!',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors())->setStatusCode(404);
        } else {
            $explode = explode('-', $request->file);

            $hazInsert = $bahanajar->update([
                'materi_id' => $bahanajar->materi_id,
                'nama_materi' => $request->judulmateri,
                'nama_file' => ($request->file == "") ? $bahanajar->nama_file : $request->file,
                'deskripsi' => $request->deskripsi,
            ]);

            if ($hazInsert) {
                Session::forget('materiID');
                return response()->json(['success' => 'Data berhasil disimpan...']);
            }

            return response()->json(['error' => 'Data gagal disimpan!!!'])->setStatusCode(400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanAjar  $bahanAjar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bahanajar $bahanAjar, Request $request)
    {
        $hazCekData = Bahanajar::find($request->id);

        if ($bahanAjar->where('materi_id', $request->id)->delete()) {
            unlink('files/' . $hazCekData->nama_file);
            return response()->json(['success' => 'Data berhasil dihapus']);
        } else {
            return response()->json('Data gagal dihapus!!!')->setStatusCode(400);
        }
    }

    public function revert(Request $request)
    {
        unlink('files/' . $request->getContent());
        return $request->getContent();
    }

    public function upload(Bahanajar $bahanajar, Request $request)
    {
        if ($request->hasFile('file')) {
            if (session('materiID') != null) {
                $hazCekData = $bahanajar->where('materi_id', session('materiID'))->first();

                if (unlink('files/' . $hazCekData->nama_file)) {
                    $file = $request->file('file');
                    $filename = session('materiID') . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                    $file->move('files/', $filename);

                    return $filename;
                }
            } else {
                $file = $request->file('file');
                $filename = uniqid() . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                $file->move('files/', $filename);

                return $filename;
            }
        }

        return '';
    }

    public function cari(Bahanajar $bahanajar, $id, $tgl)
    {
        $explode = explode(' - ', $id);

        $hazCekData = $bahanajar->where([
            'mapel_id' => $explode[0],
            'kelas_id' => $explode[1],
            'created_date' => $tgl
        ])->orderBy('created_date', 'DESC')->get();

        $user = (session('lvl') == 'Siswa') ? Siswa::where('siswa_id', session('userID'))->first() : Guru::where('guru_id', session('userID'))->first();

        if (count($hazCekData) == 0) {
            return response()->json('Tidak ada data tersedia...')->setStatusCode(404);
        } else {
            $data = '
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="timeline">';

            foreach ($hazCekData as $mapel) {
                $explode = explode('.', $mapel['nama_file']);

                $data .= '
                            <div class="time-label">
                                <span class="bg-red">' . date('d M Y', strtotime($mapel['created_date'])) . '</span>
                            </div>
                            <div class="col-12">
                                <i class="fas fa-file bg-blue"></i>
                                <div class="timeline-item mr-0">
                                    <h3 class="timeline-header">Post By <a href="#">' . $user['nama'] . '</a></h3>

                                    <div class="timeline-body">
                                        <h3 class="timeline-header text-decoration-underline">' . $mapel['nama_materi'] . ' - ' . $mapel['kelas_id'] . '</h3>

                                        <div class="col-12 my-2">' . \Illuminate\Support\Str::limit($mapel['deskripsi'], 100, ' ...') . '</div>

                                        <div class="col-12 my-2">';
                if ($explode[1] == 'mp4') {
                    $data .= '
                                            <div class="ratio ratio-16x9">
                                                <video controls>
                                                    <source src="' . asset('files/' . $mapel['nama_file']) . '" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>';
                } else {
                    $data .= '
                                            <a href="' . asset('files/' . $mapel['nama_file']) . '" class="" target="_blank">' . $mapel['nama_file'] . '</a>';
                }
                $data .= '
                                        </div>
                                    </div>
                                    <div class="timeline-footer">
                                        <a class="btn btn-primary btn-sm btn-read" data-id="' . $mapel['materi_id'] . '">Read more</a>
                                    </div>
                                </div>
                            </div>';
            }

            $data .= '
                        </div>
                    </div>
                </div>';

            return $data;
        }
    }
}
