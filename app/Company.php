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
        'status', // 1 aprovado 2 desabilitado 3 alterado 0 aguardando
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
        'cellphone',
        'ie',
        'im',
        'site',

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

    public function hasImage()
    {
        return $this->logourl != '';
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

    public function getNumContracts()
    {
        $categories = $this->companyCategories->all();

        foreach ($categories as $category)
        {
            if ($category->Category->type == 1)
            {
                return $this->getNumberContract($category->contract_index);
            }
        }

        return '-';
    }

    public function getNumberContract($contract_index)
    {
        switch ($contract_index)
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
