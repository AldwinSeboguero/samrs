<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table='staffs';
    protected $fillable = [
        'user_id',
        'designee_id',
        'campus_id',
        'semester_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function college()
    {
        return $this->belongsTo('App\Models\College','college_id');
    }
    public function designee()
    {
        return $this->belongsTo('App\Models\Designee','designee_id');
    }
    public function campus()
    {
        return $this->belongsTo('App\Models\Campus','campus_id');
    }
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
}
