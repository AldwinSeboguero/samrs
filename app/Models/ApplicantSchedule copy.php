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
   'exam_schedule_id' ,
   'status' ,
];
    
public function schedule()
{
    return $this->belongsTo('App\Models\ExamSchedule','exam_schedule_id');
}
}
