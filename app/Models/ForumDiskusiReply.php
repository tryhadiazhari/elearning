<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumDiskusiReply extends Model
{
    use HasFactory;

    protected $table = 'forum_diskusi_reply';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'string';
    public $timestamps = true;
    protected $guarded = [];
}
