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

    public function hasImage()
    {
        return $this->imageurl != '';
    }

    public function getImage()
    {
        if ($this->imageurl != '')
            return $this->imageurl;
        return asset('/assets/img/no-image.png');

    }

    public function getMainImage()
    {
        $images = $this->hasMany('App\CompanyCatImage', 'company_category_id', 'id');

        if(count($images->orderBy('id')->get()) > 0)
            return $images->orderBy('id')->get()[0]->imageurl;

        return asset('/assets/img/no-image.png');
    }

    public function getMainImageId()
    {
        $images = $this->hasMany('App\CompanyCatImage', 'company_category_id', 'id');

        if(count($images->orderBy('id')->get()) > 0)
            return $images->orderBy('id')->get()[0]->id;

        return 0;
    }


    public function getAllImages()
    {
        return $this->hasMany('App\CompanyCatImage', 'company_category_id', 'id');
    }
}
