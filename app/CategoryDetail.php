<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    protected $table = 'category_details';
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'minvalue',
        'maxvalue',
        'isactive',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

}
