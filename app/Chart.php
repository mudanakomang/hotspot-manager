<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table = ['chart'];
    protected $fillable = ['guest', 'public', 'mice'];
}