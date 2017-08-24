<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $table = 'company_categories';

    protected $fillable = [
        'company_id',
        'categorydetail_id',
        'imagepath',
        'imageurl',
        'name',
        'description',
        'value',
        'isactive',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImage()
    {
        if ($this->imageurl != '')
            return $this->imageurl;
        return asset('/assets/img/no-image.png');

    }
}
