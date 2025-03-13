<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApplicantSchedule extends Model
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
        'applicant_id' ,
        'uuid',
   'exam_schedule_id' ,
   'status' ,
   'processed_by'
];
    
public function schedule()
{
    return $this->belongsTo('App\Models\ExamSchedule','exam_schedule_id');
}
public function applicant()
{
    return $this->belongsTo('App\Models\Applicant','applicant_id');
}
}
