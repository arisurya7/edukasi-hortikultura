<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantTips extends Model
{
    use HasFactory;

    //nama tabel di database
    protected $table = 'm_plant_tips';
    //kolom yang dapat diisi nilainya
    protected $fillable = [
        'name',
        'img',
        'desc',
    ];
    public $timestamps = false;
}
