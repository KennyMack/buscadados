<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageCatTemp extends Model
{
    protected $fillable = [
        'session_id',
        'image'
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
