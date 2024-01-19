<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantDisease extends Model
{
    use HasFactory;

    protected $table = 'm_plant_disease';
    protected $fillable = [
        'name',
        'img',
        'desc',
    ];
    public $timestamps = false;
}
