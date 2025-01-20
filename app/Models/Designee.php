<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Designee extends Model
{
    protected $table='designees';
    protected $fillable=['name','short_name'];
}
