<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminCharge extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fee'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public $table="admin_fee";
}
