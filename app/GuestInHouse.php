<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestInHouse extends Model
{
    protected $fillable = ['id', 'username', 'attribute', 'op', 'value'];
}
