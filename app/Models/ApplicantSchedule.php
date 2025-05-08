<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class ApplicantSchedule extends Model
{
    use HasFactory;
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
     {
        return LogOptions::defaults()
        ->logOnly([
            'applicant_id' ,
            'uuid',
       'exam_schedule_id' ,
       'status' ,
       'scan_at',
       'scan_by',
       'processed_by']);
     }
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
   'scan_at',
   'scan_by',
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
public function scannedBy()
{
    return $this->belongsTo('App\Models\User','scan_by');
}
}
