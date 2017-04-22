<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radacct extends Model
{
    protected $table = 'radacct';

    public function radcheck()
    {
        return $this->hasMany('\App\Radcheck');
    }
}
