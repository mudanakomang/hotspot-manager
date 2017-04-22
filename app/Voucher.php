<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';
    protected $fillable = ['id', 'name', 'group', 'description', 'created', 'createdby'];
}
