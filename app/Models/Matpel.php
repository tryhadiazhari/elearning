<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matpel extends Model
{
    use HasFactory;

    protected $table = 'mapel';
    protected $primaryKey = 'mapel_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['mapel_id', 'kd_mapel', 'nama_mapel', 'kelas_id', 'guru_id'];
}
