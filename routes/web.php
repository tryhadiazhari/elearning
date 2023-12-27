<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanAjarController;
use App\Http\Controllers\ForumDiscussController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MatpelController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\SiswaController;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index', [
            'title' => 'Beranda',
            'user' => (session('lvl') == 'Admin') ? '' : (session('lvl') == 'Siswa' ? Siswa::where('siswa_id', session('userID'))->first() : Guru::where('guru_id', session('userID'))->first())
        ]);
    });

    Route::resource('/ruang', RuangController::class);
    Route::resource('/siswa', SiswaController::class);
    Route::resource('/guru', GuruController::class);
    Route::resource('/matpel', MatpelController::class);
    Route::resource('/bahanajar', BahanAjarController::class);
    Route::get('/bahanajar/cari/{id}/{tgl}', [BahanAjarController::class, 'cari']);
    Route::post('/bahanajar/{id}', [BahanAjarController::class, 'update']);
    Route::post('/upload', [BahanAjarController::class, 'upload']);
    Route::delete('/delete', [BahanAjarController::class, 'revert']);

    Route::get('forum-diskusi', [ForumDiscussController::class, 'index']);
    Route::post('forum-diskusi/simpan', [ForumDiscussController::class, 'store']);
    Route::get('forum-diskusi/{id}', [ForumDiscussController::class, 'show']);
    Route::post('forum-diskusi/{id}/reply', [ForumDiscussController::class, 'reply']);

    Route::resource('/akun', AkunController::class);
});


Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::get('/auth/registration', [AuthController::class, 'registration'])->name('registrasi');
Route::post('/auth/registration/save', [AuthController::class, 'save']);
Route::post('/cek/field', [AuthController::class, 'cekdata']);
Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);
