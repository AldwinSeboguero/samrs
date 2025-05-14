<?php

namespace App\Http\Controllers;

use Request;
use PDF; 
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use App\Models\Employee;
use App\Models\Timesheet;
use App\Models\Holiday;
use App\Models\Division; 
use App\Models\WorkDay; 

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use App\Models\Applicant; 
use App\Models\ApplicantSchedule; 
use App\Models\ExamSchedule; 
use App\Models\ExamResult; 




class PdfController extends Controller
{

    public function generatePDF()
    {

      
        $data = [
        'applicant' => Applicant::where('uuid', Request::input('applicantId'))->first(),
            
        ];
        $pdf = PDF::loadView('dtr', $data);
        $width = 8.5 * 72; // Convert inches to points (1 inch = 72 points)
        $height = 13 * 72; // Convert inches to points
        $pdf->setPaper([ 0, 0,  $width, $height], 'portrait');
        // $pdf->setPaper('legal', 'portrait'); // Adjust paper size and orientation as needed
        //A3: 'A3' - 297 x 420 mm or 11.7 x 16.5 inches
        //A4: 'A4' - 210 x 297 mm or 8.3 x 11.7 inches
        //A5: 'A5' - 148 x 210 mm or 5.8 x 8.3 inches
        //Letter: 'letter' or '8.5x11' - 8.5 x 11 inches
        //Legal: 'legal' or '8.5x14' - 8.5 x 14 inches
        //Tabloid: 'tabloid' or '11x17' - 11 x 17 inches
        return $pdf->download('form.pdf');
        
        
    }
    public function generateAttendance()
    {

      
        $data = [
            'applicant' => ApplicantSchedule::orderByDesc('scan_at')
            ->where('exam_schedule_id', Request::input('exam_id'))
            ->get()
            ->map(function($schedule) {
                return [ 
                    'uuid' => $schedule->uuid,
                    'name' => strtoupper($schedule->applicant->last_name . ' ' . $schedule->applicant->first_name . 
                              ($schedule->applicant->suffix ? ' ' . $schedule->applicant->suffix . ' ' : ' ') . 
                              $schedule->applicant->middle_name),
                    'date' => $schedule->scan_at ? \Carbon\Carbon::parse($schedule->scan_at)->format('F j, Y g:i A') : '',
                ];
            })
            ->sortBy('name') // Sort by name
            ->values() // Reset the keys after sorting
            ->map(function($schedule, $index) {
                return [
                    'index' => $index + 1, // Add 1 to make it 1-based index
                    'uuid' => $schedule['uuid'],
                    'name' => $schedule['name'],
                    'date' => $schedule['date'],
                ];
            }),
        'exam_schedule' => ExamSchedule::where('id', Request::input('exam_id'))->first(),    
        ];
        $schedule = ExamSchedule::where('id', Request::input('exam_id'))->first();
        $pdf = PDF::loadView('attendance', $data);
        $width = 8.5 * 72; // Convert inches to points (1 inch = 72 points)
        $height = 13 * 72; // Convert inches to points
        $pdf->setPaper([ 0, 0,  $width, $height], 'portrait');
        // $pdf->setPaper('legal', 'portrait'); // Adjust paper size and orientation as needed
        //A3: 'A3' - 297 x 420 mm or 11.7 x 16.5 inches
        //A4: 'A4' - 210 x 297 mm or 8.3 x 11.7 inches
        //A5: 'A5' - 148 x 210 mm or 5.8 x 8.3 inches
        //Letter: 'letter' or '8.5x11' - 8.5 x 11 inches
        //Legal: 'legal' or '8.5x14' - 8.5 x 14 inches
        //Tabloid: 'tabloid' or '11x17' - 11 x 17 inches
        return $pdf->download('Attendance'.'-'.$schedule->exam_date.''.$schedule->venue->name.'.pdf');
        
        
    } 
    public function generateAttendanceWithScanned()
    {

      
        $data = [
            'applicant' => ApplicantSchedule::orderByDesc('scan_at')
            ->where('exam_schedule_id', Request::input('exam_id'))
            ->get()
            ->map(function($schedule) {
                return [ 
                    'uuid' => $schedule->uuid,
                    'name' => strtoupper($schedule->applicant->last_name . ' ' . $schedule->applicant->first_name . 
                              ($schedule->applicant->suffix ? ' ' . $schedule->applicant->suffix . ' ' : ' ') . 
                              $schedule->applicant->middle_name),
                    'date' => $schedule->scan_at ? \Carbon\Carbon::parse($schedule->scan_at)->format('F j, Y g:i A') : '',
                ];
            })
            ->sortBy('name') // Sort by name
            ->values() // Reset the keys after sorting
            ->map(function($schedule, $index) {
                return [
                    'index' => $index + 1, // Add 1 to make it 1-based index
                    'uuid' => $schedule['uuid'],
                    'name' => $schedule['name'],
                    'date' => $schedule['date'],
                ];
            }),
        'exam_schedule' => ExamSchedule::where('id', Request::input('exam_id'))->first(),    
        ];
        $schedule = ExamSchedule::where('id', Request::input('exam_id'))->first();
        $pdf = PDF::loadView('attendancewithscanned', $data);
        $width = 8.5 * 72; // Convert inches to points (1 inch = 72 points)
        $height = 13 * 72; // Convert inches to points
        $pdf->setPaper([ 0, 0,  $width, $height], 'portrait');
        // $pdf->setPaper('legal', 'portrait'); // Adjust paper size and orientation as needed
        //A3: 'A3' - 297 x 420 mm or 11.7 x 16.5 inches
        //A4: 'A4' - 210 x 297 mm or 8.3 x 11.7 inches
        //A5: 'A5' - 148 x 210 mm or 5.8 x 8.3 inches
        //Letter: 'letter' or '8.5x11' - 8.5 x 11 inches
        //Legal: 'legal' or '8.5x14' - 8.5 x 14 inches
        //Tabloid: 'tabloid' or '11x17' - 11 x 17 inches
        return $pdf->download('Attendance-With Scanned'.'-'.$schedule->exam_date.''.$schedule->venue->name.'.pdf');
        
        
    } 

    public function generateResult()
    {
        $applicant = ExamResult::where('applicant_id', Request::input('applicant_id'))->first();
    
        if ($applicant) {
            $data = [
                'applicant' => [
                    'uuid' => $applicant->uuid,
                    'sla_name' => strtoupper($applicant->applicant->sla_name),
                    'sla_track' => strtoupper($applicant->applicant->sla_track),
                    'course_major' => strtoupper($applicant->applicant->course_major),
                    'type' => strtoupper($applicant->applicant->type),
                    'equity_group' => strtoupper($applicant->equity_group),
                    'percentile_rank' => $applicant->percentile_rank,
                    'reading' => $applicant->reading,
                    'math' => $applicant->math,
                    'language' => $applicant->language,
                    'endorsed_for' => strtoupper($applicant->endorsed_for),
                    'status_1' => strtoupper($applicant->status_1),
                    'status_2' => strtoupper($applicant->status_2),

                    'dc_course' => strtoupper($applicant->applicant->course->name),
                    'dc_campus' => strtoupper($applicant->applicant->course->campus->name),
                    'dc_course1' => strtoupper($applicant->applicant->course1->name),
                    'dc_campus1' => strtoupper($applicant->applicant->course1->campus->name),




                    'name' => strtoupper($applicant->applicant->last_name . ', ' . $applicant->applicant->first_name . 
                                      ($applicant->applicant->suffix ? ' ' . $applicant->applicant->suffix . ' ' : ' ') . 
                                      $applicant->applicant->middle_name),
                    'date' => $applicant->scan_at ? \Carbon\Carbon::parse($applicant->scan_at)->format('F j, Y g:i A') : '',
                ],
            ];
    
            $pdf = PDF::loadView('admissionresults', $data);
            $width = 8.5 * 72; // Convert inches to points (1 inch = 72 points)
            $height = 6.5 * 72; // Convert inches to points
            $pdf->setPaper([0, 0, $width, $height], 'portrait'); 
    
            return $pdf->download('Result' . '-' . '.pdf');
        } else {
            // Handle the case when no applicant is found
            return response()->json(['error' => 'Applicant not found'], 404);
        }
    }
}