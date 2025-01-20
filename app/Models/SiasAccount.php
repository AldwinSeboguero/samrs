<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiasAccount extends Model
{
    protected $table='sias_accounts';   
    protected $fillable = [
        'user_id',
        'password',
        'student_id', 

    ] ;
 
    public function student()
    {
        return $this->belongsTo('App\Models\Student','student_id');
    }
}
