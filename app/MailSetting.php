<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = ['host','port','username','password','fromaddress','fromname','subject'];
}
