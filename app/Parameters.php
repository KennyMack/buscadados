<?php
/**
 * Created by PhpStorm.
 * User: Jonathan
 * Date: 16/06/2018
 * Time: 17:03
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $table = 'parameters';
    protected $fillable = [
        'readonlyname',
        'readonlydescription',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}