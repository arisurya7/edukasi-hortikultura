<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantPest extends Model
{
    use HasFactory;

    //nama tabel di database
    protected $table = 'm_plant_pests';
    //kolom yang dapat diisi nilainya 
    protected $fillable = [
        'name',
        'img',
        'desc',
        'plant_id'
    ];
    public $timestamps = false;
}
