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
        'readonlyname',
        'readonlydescription',
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
}
