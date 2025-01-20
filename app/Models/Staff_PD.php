<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff_PD extends Model
{
    protected $table='staff_pd';
    protected $fillable = [
        'user_id',
        'program_id',
        'semester_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program','program_id');
    }
    public function clearancerequest()
    {
        return $this->belongsToMany('App\Models\ClearanceRequest','clearance_requests','student_id','staff_id')->withTimestamps();
    }
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
}
