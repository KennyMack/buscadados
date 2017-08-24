<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 
        'state_id', 
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
