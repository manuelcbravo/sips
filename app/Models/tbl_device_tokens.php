<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tbl_device_tokens extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_asesor',
        'device_token',
    ];
}
