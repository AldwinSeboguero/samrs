<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionSchedule extends Model
{
    use HasFactory;
    protected $casts = [
        'submission_date' => 'datetime', // Cast exam_date to a Carbon instance
    ];
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'submission_schedule_id');
    }
    public function getAvailableSlots()
    {
        return self::with('applicants') // Eager load applicants
            ->get() // Fetch all submission schedules
            ->map(function ($schedule) {
                $totalApplicants = $schedule->applicants->count(); // Count total applicants
                return [
                    'id' => $schedule->id,
                    'submission_date' => (new \DateTime($schedule->submission_date))->format('M d, Y h:i A'), // Format submission date
                    'reserved' => $schedule->slot, // Reserved count (total available slots)
                    'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                    'venue' => $schedule->venue->name, // Assuming there's a relationship defined
                ];
            });
    }
    public function venue()
    {
        return $this->belongsTo('App\Models\Venue','venue_id');
    }
}
