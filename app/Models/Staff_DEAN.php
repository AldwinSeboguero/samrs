<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff_DEAN extends Model
{
    protected $table='staff_dean';
    protected $fillable = [
        'user_id',
        'college_id',
        'semester_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function college()
    {
        return $this->belongsTo('App\Models\College','college_id');
    }
    
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
}
