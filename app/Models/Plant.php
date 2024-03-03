<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;
    //nama tabel di database
    protected $table = 'm_plants';
    //kolom yang dapat diisi nilainya
    protected $fillable = [
        'plant_type_id',
        'name',
        'img',
        'desc',
        'bellow_temperature',
        'top_temperature'
    ];
    public $timestamps = false;
}
