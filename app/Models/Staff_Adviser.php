<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff_Adviser extends Model
{
    protected $table='staff_adviser';
    protected $fillable = [
        'user_id',
        'section_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id');
    }
    
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
}
