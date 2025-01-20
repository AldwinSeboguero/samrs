<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPurposeSetup extends Model
{
    protected $table='student_purpose_setup'; 
    protected $fillable=['purpose_id'];   
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function purpose()
    {
        return $this->belongsTo('App\Models\ClearancePurpose','purpose_id');
    }
}
