<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SemesterSetup extends Model
{
    
    protected $table='semester_setup';    
    protected $fillable=['user_id','semester_id'];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
}
