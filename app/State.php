<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'initials',
        'name', 
        'country_id', 
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

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function DescriptionInitials()
    {
        return $this->name.' ('.$this->initials.')';
    }
}
