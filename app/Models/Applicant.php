<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Applicant extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid(); // Generate and assign a UUID
        });
    }
    protected $fillable = [
                 'last_name' ,
            'first_name' ,
            'middle_name' ,
            'suffix' ,
            'street_address' ,
            'city_address' ,
            'province_address' ,
            'zip' ,
            'type' ,
            'email' ,


            'civil_status_id' ,
            'submission_schedule_id' ,

            'gender_id' ,
            'birthday' ,
            'citizenship' ,
            'place_birth' ,
            'religion' ,
            'contact_no' ,
            'emergency_contact_name' ,
            'emergency_contact_no' ,
            'curriculum' ,
            'sla_name' ,
            'sla_address' ,
            'sla_completed_year' ,
            'sla_track' ,
            'sla_strand' ,
            'isPWD' ,
            'isIPs' ,
            'isSoloParent' ,
            'isGIDAs' ,
            'dc_campus' ,
            'dc_course' ,
            'dc_course1' ,

    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course','dc_course');
    }
    public function course1()
    {
        return $this->belongsTo('App\Models\Course','dc_course1');
    }


    public function schedule()
    {
        return $this->hasOne(ApplicantSchedule::class, 'applicant_id');
    }
    

}
