<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $table='colleges';
    protected $fillable=['name','short_name','campus_id'];
    public function campus()
    {
        return $this->belongsTo('App\Models\Campus','campus_id');
    }
}
