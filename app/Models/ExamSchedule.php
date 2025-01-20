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
}
