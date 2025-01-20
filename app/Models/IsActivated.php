<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsActivated extends Model
{
    protected $table='staff_dean';
    protected $fillable = [
        'user_id',
        'college_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
