<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'code',
        'name',
        'price',
        'stock',
        'expired_date',
        'image',
    ];
}
