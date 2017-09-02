<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCatImage extends Model
{
    protected $fillable = [
        'company_category_id',
        'company_id',
        'imagepath',
        'imageurl',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
