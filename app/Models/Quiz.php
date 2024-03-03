<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    //nama tabel di database
    protected $table = 'm_quiz';
    //kolom yang dapat diisi nilainya
    protected $fillable = [
        'quiz_type_id',
        'question',
        'answer',
    ];
    public $timestamps = false;
}
