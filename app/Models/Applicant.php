<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
        'uuid',
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
'course_major',

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
            'pwd_description',
            'ips_description',
            'isPWD' ,
            'isIPs' ,
            'isSoloParent' ,
            'isGIDAs' ,
            'dc_campus' ,
            'dc_course' ,
            'dc_course1' ,

    ];
    //   // Accessor for age
    //   public function getAgeAttribute()
    //   {
    //       return Carbon::parse($this->birthday)->age;
    //   }
  
    //   // Mutator for birthday to update age
    //   public function setBirthdayAttribute($value)
    //   {
    //       $this->attributes['birthday'] = $value;
  
    //       // Update the age attribute when birthday is set
    //       $this->attributes['age'] = Carbon::parse($value)->age;
    //   }
    public function civilStatus()
    {
        return $this->belongsTo('App\Models\CivilStatus','civil_status_id');
    }
    public function school()
    {
        return $this->belongsTo('App\Models\School','school_id');
    }
    public function sex()
    {
        return $this->belongsTo('App\Models\Gender','gender_id');
    }
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
    public function Subschedule()
    {
        return $this->belongsTo('App\Models\SubmissionSchedule','submission_schedule_id');

    }
    public function ApplicantExamschedule()
    {
        return $this->hasOne(ApplicantSchedule::class, 'applicant_id');

    }


}
