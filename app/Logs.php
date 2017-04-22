<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Usergroup;

class Radcheck extends Model
{
    protected $fillable = ['id', 'action', 'action_by', 'description', 'created'];
    protected $table = 'logs';


}
