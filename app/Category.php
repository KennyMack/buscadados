<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'name', 
        'isactive',
        'orderby',
        'type', // 0 - category detail 1 - category contract
        'icon',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function details()
    {
        return $this->hasMany('App\CategoryDetail', 'category_id', 'id');
    }

    public function getTypeDescription()
    {
        return $this->type == 0 ? 'Categoria detalhada' : 'Contrato';
    }

    public function getMainImage()
    {
        switch ($this->icon)
        {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 8:
            case 9:
                return asset('/assets/img/' . $this->icon . '.jpg');
            default:
                return asset('/assets/img/no-image.png');
        }
    }
}
