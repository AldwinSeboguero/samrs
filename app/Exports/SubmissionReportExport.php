<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DateTime;
class SubmissionReportExport implements FromCollection, WithHeadings
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
            'Applicant ID',
            'Type',

            'Last Name',
            'First Name',
            'Middle Name',
            'Suffix',
            'Birthdate',
            'Sex',


            

            'School', 
            'Track/Strand',
            'Course',

            'Contact No',
            'Email',
            'Equity Group',
            'Street',
            'Town/City',
            'Province',

            'Date of Submission',
            'Venue',
            'Date of Examination',
            'Exam Venue',
            '1st Choice',
            '2nd Choice',
            'Status',
 
        ];
    }
    public function collection()
    {
        return Applicant::query()
        ->when($this->filter, function ($query) {
            $query->where('submission_schedule_id', $this->filter);
        })
        ->get()
        ->map(fn($applicant) => [ 
            'uuid' => $applicant->uuid,
            'type' => $applicant->type,

            'last_name' => $applicant->last_name,
            'first_name' => $applicant->first_name,
            'middle_name' => $applicant->middle_name,
            'suffix_name' => $applicant->suffix,
            'birthday' => $applicant->birthday,
            'sex' => $applicant->sex->name,



            'sla_school' => $applicant->sla_name,  
            'track' => $applicant->sla_track, 
            'course' => $applicant->course_major, 


            'contact_no' => $applicant->contact_no, 
            'email' => $applicant->email, 
            'equity_group' => ($applicant->isPWD ? 'PWD ' : '').''.($applicant->isIPs ? 'IP ' : '').''.($applicant->isSoloParent ? 'Solo Parent ' : '').''.($applicant->isGIDAs ? 'GIDAs ' : ''), 
            'Street' => $applicant->street_address , 
            'Town/City' => $applicant->city_address, 
            'Province' => $applicant->province_address, 



            'subschedule' => ($applicant->Subschedule ? 
                (new DateTime($applicant->Subschedule->submission_date))->format('M d, Y') : ''),
            'venue' => $applicant->Subschedule ? 
                $applicant->Subschedule->venue->name : '',
            'examschedule' => ($applicant->ApplicantExamschedule ? 
                (new DateTime($applicant->ApplicantExamschedule->schedule->exam_date))->format('M d, Y h:i A') : ''),
            'examvenue' => $applicant->ApplicantExamschedule ? 
            ($applicant->ApplicantExamschedule->schedule->venue? $applicant->ApplicantExamschedule->schedule->venue->name : '') : '',
            'dc_course' => $applicant->curriculum != 'Transferee'  || $applicant->curriculum != 'Second Courser' ? $applicant->course->name.' '.$applicant->course->campus->name : '',
            'dc_course1' => $applicant->curriculum != 'Transferee'  || $applicant->curriculum != 'Second Courser' ? $applicant->course1->name.' '.$applicant->course1->campus->name : '',
            'status' => $applicant->status,

        ]);
    }
}
