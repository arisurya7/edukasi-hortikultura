<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantDisease extends Model
{
    use HasFactory;

    //nama tabel di database
    protected $table = 'm_plant_disease';
    //kolom yang dapat diisi nilainnya
    protected $fillable = [
        'name',
        'img',
        'desc',
        'plant_id'
    ];
    public $timestamps = false;
}
