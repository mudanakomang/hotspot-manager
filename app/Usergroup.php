<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Radcheck;

class Usergroup extends Model
{
    protected $table = 'radusergroup';

    public function radchecks()
    {
        return $this->hasMany('App\Radcheck');
    }

}
