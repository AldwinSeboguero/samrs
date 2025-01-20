<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignatoryV2 extends Model
{
    protected $table='signatories_v2';
    protected $fillable = [
        'id',
        'program_id',
        'campus_id',
        'college_id',
        'user_id',
        'name',
        'designee_id',
        'semester_id',
        'order',
        'purpose_id',
        'updated_at',
        'created_at'
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program','program_id');
    }
    public function campus()
    {
        return $this->belongsTo('App\Models\Campus','campus_id');
    }public function college()
    {
        return $this->belongsTo('App\Models\College','college_id');
    }public function designee()
    {
        return $this->belongsTo('App\Models\Designee','designee_id');
    }
    public function semester()
    {
        return $this->belongsTo('App\Models\Semester','semester_id');
    }
    public function purpose()
    {
        return $this->belongsTo('App\Models\Purpose','purpose_id');
    }
    public function clearance_requests()
{
    return $this->hasMany(ClearanceRequestV2::class,'signatory_id');
   
}
}
