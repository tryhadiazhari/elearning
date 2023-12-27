<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahanajar extends Model
{
    use HasFactory;

    protected $table = 'materibelajar';
    protected $primaryKey = 'materi_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['materi_id', 'nama_materi', 'nama_file', 'deskripsi', 'mapel_id', 'kelas_id', 'created_by', 'created_date'];
}
