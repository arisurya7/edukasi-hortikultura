<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizType extends Model
{
    use HasFactory;
    
    protected $table = 'm_quiz_type';
    protected $fillable = ['name'];
    public $timestamps = false;
}
