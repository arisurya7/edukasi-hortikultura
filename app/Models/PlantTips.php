<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantTips extends Model
{
    use HasFactory;

    protected $table = 'm_plant_tips';
    protected $fillable = [
        'name',
        'img',
        'desc',
    ];
    public $timestamps = false;
}
