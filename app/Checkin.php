<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table = ['checkin'];
    protected $fillable = ['username', 'status', 'lastcheckin', 'checkout'];
}
