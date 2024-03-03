<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizType extends Model
{
    use HasFactory;
    //nama tabel di database
    protected $table = 'm_quiz_type';
    //kolom yang dapat diisi nilainya
    protected $fillable = ['name'];
    public $timestamps = false;
}
