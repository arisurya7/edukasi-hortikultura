<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantType extends Model
{
    use HasFactory;

    protected $table = 'm_plant_type';
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;
}
