<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; //línea necesaria

class cat_marca extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'marca',
        'nombre',
    ];
}
