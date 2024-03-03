<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;
    //nama tabel di database
    protected $table = 'm_videos';
    //kolom yang dapat diisi nilainya
    protected $fillable = [
        'title',
        'link',
        'video_id'
    ];
    public $timestamps = false;
}
