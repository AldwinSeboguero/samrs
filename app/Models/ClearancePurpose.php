<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClearancePurpose extends Model
{
    protected $table='purpose_clearance';
    protected $fillable=['id','student_id','purpose','semester_id'];
    public function clearance()
    {
        return $this->belongsTo('App\Models\Student','student_id');    
    } 
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    } 
} 
