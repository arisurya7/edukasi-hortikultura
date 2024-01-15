<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;
    
    protected $table = 'm_videos';
    protected $fillable = [
        'title',
        'link'
    ];
    public $timestamps = false;
}
