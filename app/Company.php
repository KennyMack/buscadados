<?php

namespace App;

use Sofa\Eloquence\Eloquence;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'user.name' => 20,
        'user.lastname' => 20,
        'companyname' => 20,
        'tradingname' => 20,
    ];

    protected $fillable = [
        'companyname',
        'tradingname',
        'status',
        'city_id',
        'category_id',
        'address',
        'number',
        'postalnumber',
        'district',
        'cnpjcpf',

        'history',
        'logopath',
        'logourl',
        'phone',
        'ie',
        'im',

        'user_id',
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

    public function getStatus()
    {
        if ($this->user->firstlogin == 1)
            return 'Cadastro incompleto';

        switch ($this->status)
        {
            case 1:
                return 'Aprovado';
            case 2:
                return 'Desabilitado';
            case 3:
                return 'Alterado';
        }

        return 'Aguardando';
    }

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function companyCategories()
    {
        return $this->hasMany('App\CompanyCategory', 'company_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function isEnabled()
    {
        return $this->status == 1;
    }

    public function getImage()
    {
        if ($this->logourl != '')
            return $this->logourl;
        return asset('/assets/img/no-image.png');
    }

    public function cityStateDescription()
    {
        if ($this->city_id != null) {
            return ucwords($this->city->name) . '('. $this->city->state->initials .')';
        }

        return '';

    }
}
