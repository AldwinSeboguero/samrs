<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table='roles';
    protected $fillable=['name','description'];
    // public function users()
    // {
    //     return $this->belongsToMany('App\Models\User')
    //                 ->withTimestamps();
    // }
    public function users()
{
    return $this->belongsToMany(User::class);
}
}
