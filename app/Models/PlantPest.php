<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantPest extends Model
{
    use HasFactory;

    protected $table = 'm_plant_pests';
    protected $fillable = [
        'name',
        'img',
        'desc',
    ];
    public $timestamps = false;
}
