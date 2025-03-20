<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;
    public function venue()
    {
        return $this->belongsTo('App\Models\Venue','venue_id');
    }
    protected $casts = [
        'exam_date' => 'datetime', // Cast exam_date to a Carbon instance
    ];
    protected $fillable=['exam_date','slot','venue_id'];

    public function applicants()
{
    return $this->hasMany(ApplicantSchedule::class, 'exam_schedule_id');
}
}
