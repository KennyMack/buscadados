<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    protected $table = 'company_categories';

    protected $fillable = [
        'company_id',
        'category_id',
        'categorydetail_id',
        'imagepath',
        'imageurl',
        'name',
        'description',
        'value',
        'contract_index',
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

    public function categoryDetail()
    {
        return $this->belongsTo('App\CategoryDetail', 'categorydetail_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function getNumberContract()
    {
        switch ($this->contract_index)
        {
            case 0:
                return '0 - 1000';
            case 1:
                return '1000 - 5000';
            case 2:
                return '5000 - 100000';
            case 3:
                return '10000 - 20000';
            case 4:
                return '20000 - 30000';
            case 5:
                return '30000 - 40000';
            case 6:
                return '40000 - 50000';
            case 7:
                return '50000 - 60000';
            case 8:
                return '60000 - 70000';
            case 9:
                return '70000 - 80000';
            case 10:
                return '80000 - 90000';
            case 11:
                return '90000 - 100000';
            case 12:
                return '100000 - 130000';
            case 13:
                return '130000 - 160000';
            case 14:
                return '160000 - 190000';
            case 15:
                return '190000 - 220000';
            case 16:
                return '220000 - 250000';
            case 17:
                return '250000 - 280000';
            case 18:
                return '280000 - 300000';
            default:
                return '0';
        }
    }
}
