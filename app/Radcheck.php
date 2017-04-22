<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usergroup;

class Radcheck extends Model
{
    protected $fillable = ['id', 'username', 'attribute', 'op', 'value'];
    protected $table = 'radcheck';

    public function usergroups()
    {
        return $this->belongsTo('App\Usergroup');
    }
}
