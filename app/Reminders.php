<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{
    //
    protected $fillable = [
        'status',
    ];
    public $table="_payment_reminder";
}
