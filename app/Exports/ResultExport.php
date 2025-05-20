<?php

namespace App\Exports;

use App\Models\ExamResult;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DateTime;

class ResultExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $filter; // Add a property to hold the filter

    public function __construct($filter = null)
    {
        $this->filter = $filter; // Store the filter
    }
    public function headings(): array
    {
        return [
            'Exam ID',
            'Equity Group',
            'Type',
            
            'Name', 
            'Percentile Rank',
            

            'Reading', 
            'Math',
            'Language',
            'Course 1',
            'Campus 1',
            'Status 1',
            'Course 2',
            'Campus 2',
            'Status 2',
            'Endorsed For', 
 
        ];
    }
    public function collection()
    {
        return ExamResult::query() 
        ->get()
        ->map(fn($schedule) => [ 
            'uuid' => $schedule->uuid,
                'equity_group' => $schedule->equity_group ?? '', // Default to 'N/A' if null
'type' => $schedule->applicant->type ?? '', // Default to 'Unknown'
'name' => $schedule->applicant->last_name . ", ".$schedule->applicant->first_name." ".$schedule->applicant->suffix." ".$schedule->applicant->middle_name ?? '', // Default to 'No Name'
'pr' => $schedule->percentile_rank ?? 0, // Default to 0
'r' => $schedule->reading ?? 0, // Default to 0
'm' => $schedule->math ?? 0, // Default to 0
'l' => $schedule->language ?? 0, // Default to 0
'dc_course' => $schedule->applicant->course->name,
'dc_campus' => $schedule->applicant->course->campus->name,
'status_1' => $schedule->status_1 ?? '', // Default to 'Pending'
'dc_course1' => $schedule->applicant->course1->name,
'dc_campus1' => $schedule->applicant->course1->campus->name,
'status_2' => $schedule->status_2 ?? '', // Default to 'Pending'
'endorsed_for' => $schedule->endorsed_for ?? '', // Default to 'None' 


        ]);
    }
}
