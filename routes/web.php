<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SubmittedClearance;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Request;

use App\Http\Controllers\PDFController;
use App\Http\Resources\SubmittedClearance as SubmittedClearanceResource;
use App\Http\Resources\SubmittedClearanceCollection;
use App\Models\SubmitClearance; 
use App\Models\Semester; 
use App\Models\School; 
use App\Models\Campus;
use App\Models\Course;
use App\Models\TrackStrand;
use App\Models\CivilStatus;
use App\Models\Gender; 
use App\Models\Zip; 
use App\Models\Applicant; 
use App\Models\ExamResult; 

use App\Models\ExamSchedule; 
use App\Models\ApplicantSchedule; 
use App\Models\SubmissionSchedule; 
use App\Exports\SubmissionReportExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Role;
use App\Models\User;
use App\Models\Venue;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\ExamResultController;




Route::get('/favicon.ico', function () {
    $path = asset('images/favicon.ico');
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
});

Route::get('/datetoday', function () {
     

        return response()->json(now()->format('M d, Y h:i:s A')); // Return the found record as JSON
  
});

Route::get('auth/google',[GoogleController::class, 'googlepage'])->name('google');
Route::get('auth/google/callback',[GoogleController::class, 'googlecallback']);
Route::get('/notregister', function () {
    return Inertia::render('NotRegister');
})->name('notregister');
Route::get('/', function () {

    if(auth()->user()){
        if ( auth()->user()->hasRole('Admin')) {
            return redirect()->route('application.requests');
    
        }
        else if (auth()->user()->hasRole('User')){
       
            return redirect()->route('home');
    
            }
    }
   else{
    return redirect()->route('login');

   }

        
    // }
 
});


Route::get('/admin', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{
    return Inertia::render('Applicant/index',[
        'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
   
        'applicants' => Applicant::query()
        ->when(Request::input('status'), function($inner, $status) {
            if($status == 'Pending'){
                $inner->where('status', $status)->whereNotIn('id', function($query) {
                    $query->select('applicant_id')
                          ->from('applicant_schedules');
                });

            }
            else{
                $inner->where('status', $status);

            }
        })
        ->when(!Request::input('status'), function($inner, $status) {
                $inner->where('status', 'Pending')->whereNotIn('id', function($query) {
                    $query->select('applicant_id')
                          ->from('applicant_schedules');
                });

            
        })
        ->when(Request::input('search'), function($inner, $search) {
            $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
        })
        
        ->paginate(10)
        ->withQueryString()
        ->through(fn($applicant) => [
            'id' => $applicant->id,
            'uuid' => $applicant->uuid,
            'status' => $applicant->status,

            'first_name' => $applicant->first_name,
            'last_name' => $applicant->last_name,
            'middle_name' => $applicant->middle_name,
            'dc_course' => $applicant->course->name,
            'dc_campus' => $applicant->course->campus->name,
            'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
            'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
            'schedule' => $applicant->schedule ? 
            (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') : '',
        ]),
        'user.roles' => auth()->user() ? auth()->user()->roles->pluck('name') : [],
        'user.permissions' => auth()->user() ? auth()->user()->getPermissionsViaRoles()->pluck('name') : [],
     'schedules' => ExamSchedule::query()
     ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
     ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
     ->groupBy('exam_schedules.id')
     ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
     ->get()
     ->map(function($schedule) {
         $totalApplicants = $schedule->total_applicants; // Get the total applicants count
         return [
             'id' => $schedule->id,
             'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
             'reserved' => $schedule->slot, // Reserved count (total available slots)
             'available' => $schedule->slot - $totalApplicants, // Calculate available slots
             'venue' => $schedule->venue->name,
         ];
     }),
        

    ]);
// }
})->middleware(['auth','role:Admin'])->name('admin.index');

Route::middleware([
    'auth:sanctum',
    'role:Admin',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/application/requests', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        return Inertia::render('Gap/Applicants/index',[
            'filters' =>  Request::only(['search','selectedStatus','selectedYear','status','schedule']),
            'total_request' => Applicant::paginate(10)->total(),
            'total_request_pending' => Applicant::where('status','Pending')->paginate(10)->total(),
            'total_request_approved' => Applicant::where('status','Approved')->paginate(10)->total(),
            'total_request_disapproved' => Applicant::where('status','Disapproved')->paginate(10)->total(),
            'SubmissionSchedules' => SubmissionSchedule::get()
            ->map(function($schedule) {
        $totalApplicants = $schedule->applicants->count(); // Count total applicants

                return [
                    'id' => $schedule->id,
                    'submission_date' => $schedule->submission_date->format('M d, Y') ,
                    'venue' => $schedule->venue->name, 
                    'available' =>  $schedule->slot - $totalApplicants,
                ];
            })  
            ->values(),

            'applicants' => Applicant::query()
            ->when(Request::input('status'), function($inner, $status) {
                if($status == 'Pending'){
                    $inner->where('status', $status)->whereNotIn('id', function($query) {
                        $query->select('applicant_id')
                              ->from('applicant_schedules');
                    });

                }
                else{
                    $inner->where('status', $status);

                }
            })
            ->when(!Request::input('status'), function($inner, $status) {
                    $inner->where('status', 'Pending')->whereNotIn('id', function($query) {
                        $query->select('applicant_id')
                              ->from('applicant_schedules');
                    });

                
            })
            ->when(Request::input('schedule'), function($inner, $schedule) {
                $inner->where('submission_schedule_id', $schedule);

            
        })
            ->when(Request::input('search'), function($inner, $search) {
                $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
            })
            
            ->paginate(10)
            ->withQueryString()
            ->through(fn($applicant) => [
                'id' => $applicant->id,
                'uuid' => $applicant->uuid,
                'status' => $applicant->status,

                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'middle_name' => $applicant->middle_name,
                'dc_course' => $applicant->course->name,
                'dc_campus' => $applicant->course->campus->name,
                'dc_course1' => $applicant->course1->name,
                'dc_campus1' => $applicant->course1->campus->name,
                'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
                'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
                'subschedule' => $applicant->Subschedule ? 
                (new DateTime($applicant->Subschedule->submission_date))->format('M d, Y') : '',
                'venue' => $applicant->Subschedule ? 
                $applicant->Subschedule->venue->name: '',
            ]),
            // 'auth' =>  Auth::user()->roles(),
            // 'auth' => Auth::user() ? Auth::user()->roles->pluck('name') : [], // Get an array of role names
            'can' => [
                'createTask' => Auth::user()->roles(),
                'editTask' => auth()->user()->can('task_edit'),
                'destroyTask' => auth()->user()->can('task_destroy'),
            ],
         'schedules' => ExamSchedule::query()
         ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
         ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
         ->groupBy('exam_schedules.id')
         ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
         ->orderBy('exam_date') // Order by exam_date
         ->get()
         ->map(function($schedule) {
             $totalApplicants = $schedule->total_applicants; // Get the total applicants count
             return [
                 'id' => $schedule->id,
                 'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                 'reserved' => $schedule->slot, // Reserved count (total available slots)
                 'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                 'venue' => $schedule->venue->name,
             ];
         }),
            

        ]);
    // }
    })->name('application.requests');

    Route::get('/application/approved', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        return Inertia::render('Gap/Applicants/approved',[
            'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
            'total_request' => Applicant::paginate(10)->total(),
            'total_request_pending' => Applicant::where('status','Pending')->paginate(10)->total(),
            'total_request_approved' => Applicant::where('status','Approved')->paginate(10)->total(),
            'total_request_disapproved' => Applicant::where('status','Disapproved')->paginate(10)->total(),
            'applicants' => Applicant::query()
            ->when(!Request::input('status'), function($inner, $status) {
                    $inner->where('status', 'Approved');

                
            })
            ->when(Request::input('search'), function($inner, $search) {
                $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
            })
            
            ->paginate(10)
            ->withQueryString()
            ->through(fn($applicant) => [
                'id' => $applicant->id,
                'uuid' => $applicant->uuid,
                'status' => $applicant->status,

                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'middle_name' => $applicant->middle_name,
                'dc_course' => $applicant->course->name,
                'dc_campus' => $applicant->course->campus->name,
                'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
                'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
                'schedule' => $applicant->schedule ? 
                (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') : '',
                'venue' => $applicant->schedule ? 
                $applicant->schedule->schedule->venue->name: '',
            ]),
            // 'auth' => Auth::user(),
         'schedules' => ExamSchedule::query()
         ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
         ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
         ->groupBy('exam_schedules.id')
         ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
         ->get()
         ->map(function($schedule) {
             $totalApplicants = $schedule->total_applicants; // Get the total applicants count
             return [
                 'id' => $schedule->id,
                 'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                 'reserved' => $schedule->slot, // Reserved count (total available slots)
                 'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                 'venue' => $schedule->venue->name,
             ];
         }),
            

        ]);
    // }
    })->name('application.approved');

    Route::get('/application/disapproved', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        return Inertia::render('Gap/Applicants/approved',[
            'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
            'total_request' => Applicant::paginate(10)->total(),
            'total_request_pending' => Applicant::where('status','Pending')->paginate(10)->total(),
            'total_request_approved' => Applicant::where('status','Approved')->paginate(10)->total(),
            'total_request_disapproved' => Applicant::where('status','Disapproved')->paginate(10)->total(),
            'applicants' => Applicant::query()
            ->when(!Request::input('status'), function($inner, $status) {
                    $inner->where('status', 'Disapproved');

                
            })
            ->when(Request::input('search'), function($inner, $search) {
                $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
            })
            
            ->paginate(10)
            ->withQueryString()
            ->through(fn($applicant) => [
                'id' => $applicant->id,
                'uuid' => $applicant->uuid,
                'status' => $applicant->status,

                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'middle_name' => $applicant->middle_name,
                'dc_course' => $applicant->course->name,
                'dc_campus' => $applicant->course->campus->name,
                'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
                'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
                'schedule' => $applicant->schedule ? 
                (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') : '',
                'venue' => $applicant->schedule ? 
                $applicant->schedule->schedule->venue->name: '',
            ]),
            // 'auth' => Auth::user(),
         'schedules' => ExamSchedule::query()
         ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
         ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
         ->groupBy('exam_schedules.id')
         ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
         ->get()
         ->map(function($schedule) {
             $totalApplicants = $schedule->total_applicants; // Get the total applicants count
             return [
                 'id' => $schedule->id,
                 'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                 'reserved' => $schedule->slot, // Reserved count (total available slots)
                 'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                 'venue' => $schedule->venue->name,
             ];
         }),
            

        ]);
    // }
    })->name('application.disapproved');

    Route::get('/exam/schedules', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
            $exam_date = Request::input('exam_date'); 
            $venue = Request::input('exam_date'); 

        return Inertia::render('Gap/Schedules/index',[
            'filters' =>  Request::only(['search','selectedStatus','venue','exam_date']),
            'exam_schedules' => ExamSchedule::withCount('applicants')
            
            // ->having('slot', '>', 'applicants_count') // Use the correct alias here
            ->orderBy('updated_at', 'desc') 
            ->when(Request::input('exam_date'), function($inner, $exam_date) {
                $inner->whereDate('exam_date', $exam_date);
        
            })->when(Request::input('venue'), function($inner, $venue) {
                $inner->where('venue_id', $venue);
        
            })
            ->paginate(100)
            ->withQueryString()
            ->through(fn($schedule) => [
                'id' => $schedule->id,
                'exam_date' => $schedule->exam_date->format('M d, Y'),
                'exam_time' => $schedule->exam_date->format('h:i A'),
                'exam_date_form' => $schedule->exam_date->format('Y-m-d'),
                'exam_time_form' => $schedule->exam_date->format('H:i'),
                'available' => $schedule->slot - $schedule->applicants_count,
                'slot' => $schedule->slot,
                'venue' => $schedule->venue->name,
                'venue_id' => $schedule->venue->id,

                'created_at' => $schedule->created_at ? $schedule->created_at->format('M d, Y') : '',
                'created_at_human' => $schedule->created_at ? $schedule->created_at->diffForHumans() : '',
            ]),
            'venue' => Venue::get(),
            'applicants' => Applicant::query()
         
            ->when(Request::input('search'), function($inner, $search) {
                $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
            })
            
            ->paginate(10)
            ->withQueryString()
            ->through(fn($applicant) => [
                'id' => $applicant->id,
                'uuid' => $applicant->uuid,
                'status' => $applicant->status,

                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'middle_name' => $applicant->middle_name,
                'dc_course' => $applicant->course->name,
                'dc_campus' => $applicant->course->campus->name,
                'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
                'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
                'schedule' => $applicant->schedule ? 
                (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') : '',
                'venue' => $applicant->schedule ? 
                $applicant->schedule->schedule->venue->name: '',
            ]),
            // 'auth' => Auth::user(),
         'schedules' => ExamSchedule::query()
         ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
         ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
         ->groupBy('exam_schedules.id')
         ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
         ->get()
         ->map(function($schedule) {
             $totalApplicants = $schedule->total_applicants; // Get the total applicants count
             return [
                 'id' => $schedule->id,
                 'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                 'reserved' => $schedule->slot, // Reserved count (total available slots)
                 'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                 'venue' => $schedule->venue->name,
             ];
         }),
            

        ]);
    // }
    })->name('exam.schedules');



    Route::get('/exam/attendance', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
            $applicant=  Applicant::where('email',auth()->user()->email)->first();
            if($applicant){
                $applicantSchedule = SubmissionSchedule::where('id', $applicant->submission_schedule_id)->get()->map(fn($schedule) => [
                    'id' => $schedule->id,
                    'submission_schedule_id' => $schedule->uuid,
    
                    'submission_date' => $schedule->submission_date ? $schedule->submission_date->format('M d, Y') : '',
                    'venue' => $schedule->venue->name ?? '', // Assuming there's a venue relationship
                    'qr_link' => "https://gapms.parsu.edu.ph/examverification?exam=".$schedule->uuid,
                    // Add any additional fields you need from ApplicantSchedule
                ])->first();
            };
    
    
            $schedules = ExamSchedule::query()
             ->orderBy('exam_date') // Order by exam_date
             ->get()
          
             ->map(function($schedule) {
                 $totalApplicants = $schedule->total_applicants; // Get the total applicants count
                 return [
                     'id' => $schedule->id,
                     'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                     'reserved' => $schedule->slot, // Reserved count (total available slots)
                     'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                     'venue' => $schedule->venue->name,
                 ];
             }); 
        return Inertia::render('Gap/Schedules/attendanceSheet',[
            'Schools' => School::orderBy('name')->get(),
            'Campuses' => Campus::all(),
            'Courses' => Course::get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'campus' => $course->campus->name, 
                ];
            }),
                'SubmissionSchedules' => SubmissionSchedule::get()
                ->map(function($schedule) {
            $totalApplicants = $schedule->applicants->count(); // Count total applicants
    
                    return [
                        'id' => $schedule->id,
                        'submission_date' => $schedule->submission_date->format('M d, Y') ,
                        'venue' => $schedule->venue->name, 
                        'available' =>  $schedule->slot - $totalApplicants,
                    ];
                })  
                ->values(),
                'filters' =>  Request::only(['exam_id']),
            'TrackStrand' => TrackStrand::all(),
            'CivilStatus' => CivilStatus::all(),
            'Schedules' => $schedules,
            // 'auth' => Auth::user(),
            'applicant' => Applicant::where('id', Request::input('applicantId'))->first(),

        ]);
    // }
    })->name('exam.attendance');

    Route::post('/exam-results/import', [ExamResultController::class, 'import'])->name('exam_results.import');
    Route::get('/exam/results', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
            $exam_date = Request::input('exam_date'); 
            $venue = Request::input('exam_date'); 

        return Inertia::render('Gap/Results/index',[
            'filters' =>  Request::only(['search','selectedStatus','venue','exam_date']),
            'exam_results' => ExamResult::orderBy('updated_at', 'desc')  
            ->when(Request::input('search'), function($query, $search) {
                $query->whereHas('applicant', function($inner) use ($search) {
                    $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', middle_name))"), 'LIKE', "%" . $search . "%");
                });
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($schedule) => [
                'id' => $schedule->id,
                'uuid' => $schedule->uuid,
                'equity_group' => $schedule->equity_group ?? '', // Default to 'N/A' if null
'type' => $schedule->applicant->type ?? '', // Default to 'Unknown'
'name' => $schedule->applicant->last_name . ", ".$schedule->applicant->first_name." ".$schedule->applicant->suffix." ".$schedule->applicant->middle_name ?? '', // Default to 'No Name'
'pr' => $schedule->percentile_rank ?? 0, // Default to 0
'r' => $schedule->reading ?? 0, // Default to 0
'm' => $schedule->math ?? 0, // Default to 0
'l' => $schedule->language ?? 0, // Default to 0

'status_1' => $schedule->status_1 ?? '', // Default to 'Pending'
'status_2' => $schedule->status_2 ?? '', // Default to 'Pending'
'endorsed_for' => $schedule->endorsed_for ?? '', // Default to 'None'

            ]), 

        ]);
    // }
    })->name('exam.result');

//gap-applicantvie-details
Route::get('/gap/applicant/details', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{
        $applicant=  Applicant::where('email',auth()->user()->email)->first();
        if($applicant){
            $applicantSchedule = SubmissionSchedule::where('id', $applicant->submission_schedule_id)->get()->map(fn($schedule) => [
                'id' => $schedule->id,
                'submission_schedule_id' => $schedule->uuid,

                'submission_date' => $schedule->submission_date ? $schedule->submission_date->format('M d, Y') : '',
                'venue' => $schedule->venue->name ?? '', // Assuming there's a venue relationship
                'qr_link' => "https://gapms.parsu.edu.ph/examverification?exam=".$schedule->uuid,
                // Add any additional fields you need from ApplicantSchedule
            ])->first();
        }
    return Inertia::render('Gap/Applicants/view',[
        'Schools' => School::orderBy('name')->get(),
        'Campuses' => Campus::all(),
        'Courses' => Course::get()
        ->map(function($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'campus' => $course->campus->name, 
            ];
        }),
            'SubmissionSchedules' => SubmissionSchedule::get()
            ->map(function($schedule) {
        $totalApplicants = $schedule->applicants->count(); // Count total applicants

                return [
                    'id' => $schedule->id,
                    'submission_date' => $schedule->submission_date->format('M d, Y') ,
                    'venue' => $schedule->venue->name, 
                    'available' =>  $schedule->slot - $totalApplicants,
                ];
            })  
            ->values(),
        'TrackStrand' => TrackStrand::all(),
        'CivilStatus' => CivilStatus::all(),
        'Gender' => Gender::all(),
        // 'auth' => Auth::user(),
        'applicant' => Applicant::where('id', Request::input('applicantId'))->first(),
        

    ]);
// }
})->name('applicant-details');

//gap-arttendance-scanner
Route::get('/gap/attendance/scanner', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{
        $applicant=  Applicant::where('email',auth()->user()->email)->first();
        if($applicant){
            $applicantSchedule = SubmissionSchedule::where('id', $applicant->submission_schedule_id)->get()->map(fn($schedule) => [
                'id' => $schedule->id,
                'submission_schedule_id' => $schedule->uuid,

                'submission_date' => $schedule->submission_date ? $schedule->submission_date->format('M d, Y') : '',
                'venue' => $schedule->venue->name ?? '', // Assuming there's a venue relationship
                'qr_link' => "https://gapms.parsu.edu.ph/examverification?exam=".$schedule->uuid,
                // Add any additional fields you need from ApplicantSchedule
            ])->first();
        };


        $schedules = ExamSchedule::query()
         ->orderBy('exam_date') // Order by exam_date
         ->get()
         ->filter(function($schedule) {
            return $schedule->exam_date->isToday() || $schedule->exam_date > today(); // Filter for today or future dates
        })
         ->map(function($schedule) {
             $totalApplicants = $schedule->total_applicants; // Get the total applicants count
             return [
                 'id' => $schedule->id,
                 'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
                 'reserved' => $schedule->slot, // Reserved count (total available slots)
                 'available' => $schedule->slot - $totalApplicants, // Calculate available slots
                 'venue' => $schedule->venue->name,
             ];
         });
    return Inertia::render('Gap/Applicants/attendanceScanner',[
        'Schools' => School::orderBy('name')->get(),
        'Campuses' => Campus::all(),
        'Courses' => Course::get()
        ->map(function($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'campus' => $course->campus->name, 
            ];
        }),
            'SubmissionSchedules' => SubmissionSchedule::get()
            ->map(function($schedule) {
        $totalApplicants = $schedule->applicants->count(); // Count total applicants

                return [
                    'id' => $schedule->id,
                    'submission_date' => $schedule->submission_date->format('M d, Y') ,
                    'venue' => $schedule->venue->name, 
                    'available' =>  $schedule->slot - $totalApplicants,
                ];
            })  
            ->values(),
            'filters' =>  Request::only(['exam_id']),
        'TrackStrand' => TrackStrand::all(),
        'CivilStatus' => CivilStatus::all(),
        'Schedules' => $schedules,
        // 'auth' => Auth::user(),
        'applicant' => Applicant::where('id', Request::input('applicantId'))->first(),
        

    ]);
// }
})->name('attendance-scanner');
Route::post('/get-examinees', function(Request $request) { 
    $applicant =  ApplicantSchedule::orderByDesc('scan_at')->where('exam_schedule_id', Request::input('exam_id'))->get()
    ->map(function($schedule) {
       

                return [ 
                    'uuid' => $schedule->uuid,
                    'name' => $schedule->applicant->last_name.' '.$schedule->applicant->first_name.($schedule->applicant->suffix ? ' '.$schedule->applicant->suffix.' ' :' ').$schedule->applicant->middle_name,
                'date' =>  $schedule->scan_at ? \Carbon\Carbon::parse($schedule->scan_at)->format('F j, Y g:i A') : '',
                'scannedBy' => $schedule->scannedBy ? $schedule->scannedBy->name : '',
                ];
            }) ;
    return response()->json([
        'applicant' => $applicant,
        'count' => $applicant->count(),
        'scanned' => ApplicantSchedule::orderByDesc('scan_at')->where('exam_schedule_id', Request::input('exam_id'))->whereNotNull('scan_at')->paginate()->total(),
        ]); // Return the found record as JSON
});
Route::post('/get-examinee-details', function(Request $request) { 
    ApplicantSchedule::where('uuid', Request::input('exam_id'))
    ->where('exam_schedule_id', Request::input('exam_schedule_id'))
    ->whereNull('scan_at')
    ->update(['scan_at' => now(),'scan_by' => Auth::user()->id]);
    $applicant = ApplicantSchedule::where('uuid', Request::input('exam_id'))
    ->where('exam_schedule_id', Request::input('exam_schedule_id')) // Ensure scan_at is NULL
    ->first();

if ($applicant) {
    return [
        'uuid' => $applicant->uuid,
        'name' => $applicant->applicant->last_name . ' ' . $applicant->applicant->first_name . 
                  ($applicant->applicant->suffix ? ' ' . $applicant->applicant->suffix : '') . 
                  ($applicant->applicant->middle_name ? ' ' . $applicant->applicant->middle_name : ''),
        'date' => $applicant->scan_at ? \Carbon\Carbon::parse($applicant->scan_at)->format('F j, Y g:i A') : '',
    ];
}
    return response()->json([
        'applicant' => $applicant,
        ]); // Return the found record as JSON
});
Route::get('/getRequestStat', function () {
     

    return response()->json([
        'total_request' => Applicant::paginate(10)->total(),
        'total_request_pending' => Applicant::where('status','Pending')->paginate(10)->total(),
        'total_request_approved' => Applicant::where('status','Approved')->paginate(10)->total(),
        'total_request_disapproved' => Applicant::where('status','Disapproved')->paginate(10)->total(),
    ]); // Return the found record as JSON

});

Route::post('/save-sched', function(Request $request) {
    // $applicant = Applicant::find(Request::input('applicantId'));
// dd($applicant);
ApplicantSchedule::updateOrCreate(
['applicant_id' => Request::input('applicationDetails.applicant_id')], // Attributes to match
Request::input('applicationDetails') // Attributes to update or create
);

    
    Applicant::where('id', Request::input('applicantId'))->update(['status' => 'Approved']);
});


Route::post('/save-school', function(Request $request) {
    // $applicant = Applicant::find(Request::input('applicantId'));
// dd($applicant);
School::updateOrCreate(
['id' => Request::input('schoolData.id')], // Attributes to match
Request::input('schoolData') // Attributes to update or create
);
});

Route::post('/save-schedule', function(Request $request) {
    // $applicant = Applicant::find(Request::input('applicantId'));
// dd($applicant);
// $validatedData = Request::validate([
//     'userData.id' => 'nullable|integer|exists:users,id', // Adjust validation as necessary
//     'userData.email' => 'required|email', // Adjust validation as necessary
//     'userData.name' => 'required', // Adjust validation as necessary

//     'userData.role' => 'required', // Expecting an array of roles
//     // Add other validation rules for userData fields as needed
// ]);

$scheduleDate = [
     
    'exam_date' => Request::input('scheduleData.exam_date').' '.Request::input('scheduleData.exam_time') ,
    'slot' => Request::input('scheduleData.slot'),

    'venue_id' => Request::input('scheduleData.venue'),

];
ExamSchedule::updateOrCreate(
['id' => Request::input('scheduleData.id')], // Attributes to match
$scheduleDate // Attributes to update or create
);
});

Route::post('/save-user', function(Request $request) {
 // Validate the input data
 $validatedData = Request::validate([
    'userData.id' => 'nullable|integer|exists:users,id', // Adjust validation as necessary
    'userData.email' => 'required|email', // Adjust validation as necessary
    'userData.name' => 'required', // Adjust validation as necessary

    'userData.role' => 'required', // Expecting an array of roles
    // Add other validation rules for userData fields as needed
]);

// Separate the user data and roles
$userData = $validatedData['userData'];
$roles = $userData['role']; // This assumes that roles are sent as an array

// Use updateOrCreate to update or create the school record
$user = User::updateOrCreate(
    ['id' => $userData['id']], // Attributes to match
    $userData // Attributes to update or create
);

// Sync roles if you're using a many-to-many relationship
if (method_exists($user, 'roles')) {
    // $currentRoles = $user->roles()->pluck('name')->toArray();
    $user->roles()->sync($roles); // Sync the roles array with the school model
    // activity()
    // ->performedOn($user)
    // ->withProperties(['roles' => $currentRoles])
    // ->log('Updated roles for user: ' . $user->name);
}
$user->touch();
// Optionally return a response
return response()->json(['message' => 'User and roles saved successfully'], 200);

    
});

Route::post('/update-school', function(Request $request) {
    // $applicant = Applicant::find(Request::input('applicantId'));
// dd($applicant);
School::updateOrCreate(
['id' => Request::input('schoolData.id')], // Attributes to match
Request::input('schoolData') // Attributes to update or create
);

    
});

Route::post('/disapproved-applicant', function(Request $request) {


    
    Applicant::where('id', Request::input('applicantId'))->update(['status' => 'Disapproved']);
});
// Route::post('/count-total-applicant-inschedule', function (Request $request) {
//     $scheduleId = Request::input('schedule_id');
// // dd($scheduleId);
//     // Validate the input
//     if (is_null($scheduleId)) {
//         return response()->json(['error' => 'Schedule ID is required'], 400);
//     }

//     // Count applicants
//     $count = ApplicantSchedule::where('exam_schedule_id', $scheduleId)->count();

//     return response()->json([
//         'count' => $count,
//         'available' => ExamSchedule::where('id',$scheduleId)->first()->available,
//     ]);

// });

Route::post('/update-student-deatails', function(Request $request) {
  
    // dd(Request::input('applicationDetails'));
    $applicant = Applicant::where('id', Request::input('applicantId'))->first()
    ->update(Request::input('applicationDetails'));
    return response()->json([
        'Applicant' => $applicant,
    ]);
});

///management
Route::get('/management/schools', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{
    return Inertia::render('Gap/Managements/Schools/index',[
        'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
        'Schools' => School::orderByDesc('created_at')
        ->when(Request::input('search'), function($inner, $search) {
            $inner->where(DB::raw("TRIM(CONCAT(name, ' ', address))"), 'LIKE', "%" . $search . "%");
        })
        ->paginate(10),

        

    ]);
// }
})->name('management.school');
Route::get('/management/users', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{ 
    return Inertia::render('Gap/Managements/Users/index',[
        'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
        'Schools' => School::orderByDesc('created_at')
        ->when(Request::input('search'), function($inner, $search) {
            $inner->where(DB::raw("TRIM(CONCAT(name, ' ', address))"), 'LIKE', "%" . $search . "%");
        })
        ->paginate(10),
       'Users' => User::with('roles') // Eager load roles
       ->orderByDesc('updated_at')
       ->whereNot('email', 'aldwin.seboguero@parsu.edu.ph')
       ->when(Request::input('search'), function ($query, $search) {
           $query->where(DB::raw("TRIM(name)"), 'LIKE', "%" . $search . "%");
       })
       ->when(Request::input('role_id'), function ($query, $role_id) {
           $query->whereHas('roles', function ($roleQuery) use ($role_id) {
               $roleQuery->where('id', $role_id);
           });
       })
       ->paginate(10), 
    'Roles' => Role::get(),

        

    ]);
// }
})->name('management.users');

Route::post('/management/getusers', function () {
    // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
    //     dd('Applied!');
    // }
    // else{
    $search = Request::input('search');
    return response()->json([
        'Users' => User::with('roles') // Load the roles
    ->orderByDesc('updated_at')
    ->whereNot('email', 'aldwin.seboguero@parsu.edu.ph')
    ->when($search, function($inner, $search) {
        $inner->where("name", 'LIKE', "%" . $search . "%");
    })
    ->when(Request::input('role_id'), function ($query, $role_id) {
        $query->whereHas('roles', function ($roleQuery) use ($role_id) {
            $roleQuery->where('id', $role_id);
        });
    })
    ->paginate(10),
        ]); // Return the found record as JSON
     
// }
})->name('management.getusers');

//reports

Route::get('/generate-submission-report', function () {
    return Excel::download(new SubmissionReportExport(Request::input('schedule')), 'applicant.xlsx');
})->name('generate-submission-report');


Route::get('/reports/submission-summary', function () {
    return Inertia::render('Gap/Reports/SubmissionReport',[
        'filters' =>  Request::only(['search','selectedStatus','selectedYear','status','schedule']),
        'total_request' => Applicant::paginate(10)->total(),
        'total_request_pending' => Applicant::where('status','Pending')->paginate(10)->total(),
        'total_request_approved' => Applicant::where('status','Approved')->paginate(10)->total(),
        'total_request_disapproved' => Applicant::where('status','Disapproved')->paginate(10)->total(),
        'SubmissionSchedules' => SubmissionSchedule::get()
        ->map(function($schedule) {
    $totalApplicants = $schedule->applicants->count(); // Count total applicants

            return [
                'id' => $schedule->id,
                'submission_date' => $schedule->submission_date->format('M d, Y') ,
                'venue' => $schedule->venue->name, 
                'available' =>  $schedule->slot - $totalApplicants,
            ];
        })  
        ->values(),

        'applicants' => Applicant::query()
        // ->when(Request::input('status'), function($inner, $status) {
        //     if($status == 'Pending'){
        //         $inner->where('status', $status)->whereNotIn('id', function($query) {
        //             $query->select('applicant_id')
        //                   ->from('applicant_schedules');
        //         });

        //     }
        //     else{
        //         $inner->where('status', $status);

        //     }
        // })
        // ->when(!Request::input('status'), function($inner, $status) {
        //         $inner->where('status', 'Pending')->whereNotIn('id', function($query) {
        //             $query->select('applicant_id')
        //                   ->from('applicant_schedules');
        //         });

            
        // })
        ->when(Request::input('schedule'), function($inner, $schedule) {
            $inner->where('submission_schedule_id', $schedule);

        
    })
        ->when(Request::input('search'), function($inner, $search) {
            $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
        })
        
        ->paginate(10)
        ->withQueryString()
        ->through(fn($applicant) => [
            'id' => $applicant->id,
            'uuid' => $applicant->uuid,
            'status' => $applicant->status,

            'first_name' => $applicant->first_name,
            'last_name' => $applicant->last_name,
            'middle_name' => $applicant->middle_name,
            'sla_school' => $applicant->sla_name,

            'dc_course' => $applicant->course->name,
            'dc_campus' => $applicant->course->campus->name,
            'dc_course1' => $applicant->course1->name,
            'dc_campus1' => $applicant->course1->campus->name,
            'status' => $applicant->status,

            'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
            'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
            'subschedule' => $applicant->Subschedule ? 
            (new DateTime($applicant->Subschedule->submission_date))->format('M d, Y') : '',
            'venue' => $applicant->Subschedule ? 
            $applicant->Subschedule->venue->name: '',
        ]),
        // 'auth' =>  Auth::user()->roles(),
        // 'auth' => Auth::user() ? Auth::user()->roles->pluck('name') : [], // Get an array of role names
        'can' => [
            'createTask' => Auth::user()->roles(),
            'editTask' => auth()->user()->can('task_edit'),
            'destroyTask' => auth()->user()->can('task_destroy'),
        ],
     'schedules' => ExamSchedule::query()
     ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
     ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
     ->groupBy('exam_schedules.id')
     ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
     ->orderBy('exam_date') // Order by exam_date
     ->get()
     ->map(function($schedule) {
         $totalApplicants = $schedule->total_applicants; // Get the total applicants count
         return [
             'id' => $schedule->id,
             'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
             'reserved' => $schedule->slot, // Reserved count (total available slots)
             'available' => $schedule->slot - $totalApplicants, // Calculate available slots
             'venue' => $schedule->venue->name,
         ];
     }),
        

    ]);
})->name('reports.school');

});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');
Route::get('/generate-attendance', [PDFController::class, 'generateAttendance'])->name('generate-attendance');
Route::get('/generate-attendancewithscanned', [PDFController::class, 'generateAttendanceWithScanned'])->name('generate-attendancewithscanned');
Route::get('/generate-result', [PDFController::class, 'generateResult'])->name('generate-result');



    Route::post('/count-total-applicant-inschedule', function (Request $request) {
        $scheduleId = Request::input('schedule_id');
        // Validate the input
        if (is_null($scheduleId)) {
            return response()->json(['error' => 'Schedule ID is required'], 400);
        }
    
        // Count applicants
        $count = ApplicantSchedule::where('exam_schedule_id', $scheduleId)->count();
        
        return response()->json([
            'count' => $count,
            'available' => ExamSchedule::where('id',$scheduleId)->first()->slot,
        ]);
    
    });
    
    Route::get('/dashboard', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        // return Inertia::render('Applicant/index',[
        //     'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
        //     'cans' => [
        //         'createTask' => auth()->user()->can('task_create'),
        //         'editTask' => auth()->user()->can('task_edit'),
        //         'destroyTask' => auth()->user()->can('task_destroy'),
        //     ],
        //     'applicants' => Applicant::query()
        //     ->when(Request::input('status'), function($inner, $status) {
        //         if($status == 'Pending'){
        //             $inner->where('status', $status)->whereNotIn('id', function($query) {
        //                 $query->select('applicant_id')
        //                       ->from('applicant_schedules');
        //             });

        //         }
        //         else{
        //             $inner->where('status', $status);

        //         }
        //     })
        //     ->when(!Request::input('status'), function($inner, $status) {
        //             $inner->where('status', 'Pending')->whereNotIn('id', function($query) {
        //                 $query->select('applicant_id')
        //                       ->from('applicant_schedules');
        //             });

                
        //     })
        //     ->when(Request::input('search'), function($inner, $search) {
        //         $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
        //     })
            
        //     ->paginate(10)
        //     ->withQueryString()
        //     ->through(fn($applicant) => [
        //         'id' => $applicant->id,
        //         'uuid' => $applicant->uuid,
        //         'status' => $applicant->status,

        //         'first_name' => $applicant->first_name,
        //         'last_name' => $applicant->last_name,
        //         'middle_name' => $applicant->middle_name,
        //         'dc_course' => $applicant->course->name,
        //         'dc_campus' => $applicant->course->campus->name,
        //         'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
        //         'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
        //         'schedule' => $applicant->schedule ? 
        //         (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') : '',
        //     ]),
        //     // 'auth' => Auth::user(),
        //  'schedules' => ExamSchedule::query()
        //  ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
        //  ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
        //  ->groupBy('exam_schedules.id')
        //  ->havingRaw('slot > total_applicants') // Check if slots are greater than total applicants
        //  ->get()
        //  ->map(function($schedule) {
        //      $totalApplicants = $schedule->total_applicants; // Get the total applicants count
        //      return [
        //          'id' => $schedule->id,
        //          'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y h:i A'),
        //          'reserved' => $schedule->slot, // Reserved count (total available slots)
        //          'available' => $schedule->slot - $totalApplicants, // Calculate available slots
        //          'venue' => $schedule->venue->name,
        //      ];
        //  }),
            

        // ]);
        if(auth()->user()){
            if ( auth()->user()->hasRole('Admin')) {
                return redirect()->route('application.requests');
        
            }
            else if (auth()->user()->hasRole('User')){
           
                return redirect()->route('home');
        
                }
        }
       else{
        return redirect()->route('login');
    
       }
    
    // }
    })->name('dashboard');
  
   
    Route::get('/home', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        $applicant=  Applicant::where('email',auth()->user()->email)->first();
        if($applicant){
            $applicantSchedule = SubmissionSchedule::where('id', $applicant->submission_schedule_id)->get()->map(fn($schedule) => [
                'id' => $schedule->id,
                'submission_schedule_id' => $schedule->uuid,

                'submission_date' => $schedule->submission_date ? $schedule->submission_date->format('M d, Y') : '',
                'venue' => $schedule->venue->name ?? '', // Assuming there's a venue relationship
                'qr_link' => "https://gapms.parsu.edu.ph/examverification?exam=".$schedule->uuid,
                // Add any additional fields you need from ApplicantSchedule
            ])->first();
        }
        return Inertia::render('Applicant/index',[
            'Schools' => School::orderBy('name')->get(),
            'Campuses' => Campus::all(),
            'SubmissionSchedules' => SubmissionSchedule::get()
            ->filter(function($schedule) {
                return $schedule->submission_date->isToday() || $schedule->submission_date > today(); // Filter for today or future dates
            })
            ->map(function($schedule) {
        $totalApplicants = $schedule->applicants->count(); // Count total applicants

                return [
                    'id' => $schedule->id,
                    'submission_date' => $schedule->submission_date->format('M d, Y') ,
                    'venue' => $schedule->venue->name, 
                    'available' =>  $schedule->slot - $totalApplicants,
                ];
            })  ->filter(function ($schedule) {
                return $schedule['available'] > 0; // Filter to include only those with available slots
            })
            ->values(),

          'Courses' => Course::get()
            ->filter(function($course) {
                return !empty($course->name); // Filter to include only courses with a non-empty name
            })
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'campus' => $course->campus->name,
                ];
            }),
            'Application' =>$applicant,
            'ExamSchedule' => $applicant ? ApplicantSchedule::where('applicant_id',$applicant->id)->first() : null,
            'SubmissionSchedule' => $applicant ? $applicantSchedule : null,

          'ExamResult' => $applicant ? ExamResult::where('applicant_id', $applicant->id)->first() : null,


            'TrackStrand' => TrackStrand::all(),
            'CivilStatus' => CivilStatus::all(),
            'Gender' => Gender::all(),

            // 'auth' => auth()->user()->can('create','System Administrator'),
            

        ]);
    // }
    })->name('home');
    Route::get('/getsubsched', function () {
        // Get the search input from the request
        $sched =SubmissionSchedule::get()
            ->map(function($schedule) {
        $totalApplicants = $schedule->applicants->count(); // Count total applicants

                return [
                    'id' => $schedule->id,
                    'submission_date' => $schedule->submission_date->format('M d, Y h:i A') ,
                    'venue' => $schedule->venue->name, 
                    'available' =>  $schedule->slot - $totalApplicants,
                ];
            })  ->filter(function ($schedule) {
                return $schedule['available'] > 0; // Filter to include only those with available slots
            })
            ->values();

            return response()->json($sched); // Return the found record as JSON
      
    });
    Route::get('/examschedule', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
            $applicants = Applicant::where('email', auth()->user()->email)
            // ->with('course.campus', 'schedule.schedule.venue') // Eager load related models
            ->get() // Get all matching applicants
            ->map(fn($applicant) => [
                'id' => $applicant->id,
                'uuid' => $applicant->uuid,
                'status' => $applicant->status,
                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'middle_name' => $applicant->middle_name,
                'dc_course' => $applicant->course->name ?? '',
                'dc_course1' => $applicant->course1->name ?? '',

                'dc_campus' => $applicant->course->campus->name ?? '',
                'dc_campus1' => $applicant->course1->campus->name ?? '',

                'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
                'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
                'schedule' => $applicant->schedule && $applicant->schedule->schedule 
                    ? (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') 
                    : '',
                'venue' => $applicant->schedule && $applicant->schedule->schedule && $applicant->schedule->schedule->venue 
                    ? $applicant->schedule->schedule->venue->name 
                    : '',
            ]);
        
        // Get the first transformed applicant
        $applicantData = $applicants->first(); 
        
        if ($applicantData) {
            $applicantId = $applicantData['id']; // Access the id from the array
            $applicantSchedule = ApplicantSchedule::where('applicant_id', $applicantId)->get()->map(fn($schedule) => [
                'id' => $schedule->id,
                'exam_schedule_id' => $schedule->uuid,

                'exam_date' => $schedule->schedule->exam_date ? $schedule->schedule->exam_date->format('M d, Y h:i A') : '',
                'venue' => $schedule->schedule->venue->name ?? '', // Assuming there's a venue relationship
                'qr_link' => "https://samrs.parsu.edu.ph/examverification?exam=".$schedule->uuid,
                // Add any additional fields you need from ApplicantSchedule
            ])->first();
        } else {
            $applicantId = null; // Handle case where no applicants are found
        }
        
        return Inertia::render('Applicant/ExamSchedule', [
            'Schools' => School::all(),
            'Campuses' => Campus::all(),
            'Courses' => Course::all(),
            'TrackStrand' => TrackStrand::all(),
            'CivilStatus' => CivilStatus::all(),
            'Gender' => Gender::all(),
            'auths' => Auth::user()->hasRoles('Admin'),
            'Application' => $applicantData, // Use the transformed applicant data
            'ExamSchedule' => $applicantSchedule,
            'ExamResult' => $applicantId ? ExamResult::where('applicant_id', $applicantId)->first() : null,

        ]);
    // }
    })->name('examschedule');

    Route::get('/examresults', function () {
        $applicants = Applicant::where('email', auth()->user()->email)
        // ->with('course.campus', 'schedule.schedule.venue') // Eager load related models
        ->get() // Get all matching applicants
        ->map(fn($applicant) => [
            'id' => $applicant->id,
            'uuid' => $applicant->uuid,
            'status' => $applicant->status,
            'first_name' => $applicant->first_name,
            'last_name' => $applicant->last_name,
            'middle_name' => $applicant->middle_name,
            'dc_course' => $applicant->course->name ?? '',
            'dc_course1' => $applicant->course1->name ?? '',

            'dc_campus' => $applicant->course->campus->name ?? '',
            'dc_campus1' => $applicant->course1->campus->name ?? '',

            'created_at' => $applicant->created_at ? $applicant->created_at->format('M d, Y') : '',
            'created_at_human' => $applicant->created_at ? $applicant->created_at->diffForHumans() : '',
            'schedule' => $applicant->schedule && $applicant->schedule->schedule 
                ? (new DateTime($applicant->schedule->schedule->exam_date))->format('M d, Y h:i A') 
                : '',
            'venue' => $applicant->schedule && $applicant->schedule->schedule && $applicant->schedule->schedule->venue 
                ? $applicant->schedule->schedule->venue->name 
                : '',
        ]);
    
    // Get the first transformed applicant
    $applicantData = $applicants->first(); 
    
    if ($applicantData) {
        $applicantId = $applicantData['id']; // Access the id from the array
        $applicantSchedule = ApplicantSchedule::where('applicant_id', $applicantId)->get()->map(fn($schedule) => [
            'id' => $schedule->id,
            'exam_schedule_id' => $schedule->uuid,

            'exam_date' => $schedule->schedule->exam_date ? $schedule->schedule->exam_date->format('M d, Y h:i A') : '',
            'venue' => $schedule->schedule->venue->name ?? '', // Assuming there's a venue relationship
            'qr_link' => "https://samrs.parsu.edu.ph/examverification?exam=".$schedule->uuid,
            // Add any additional fields you need from ApplicantSchedule
        ])->first();
    } else {
        $applicantId = null; // Handle case where no applicants are found
    }
    
        return Inertia::render('Applicant/ExamResults',[
            'Schools' => School::all(),
            'Campuses' => Campus::all(),
            'Courses' => Course::all(),
            'TrackStrand' => TrackStrand::all(),
            'CivilStatus' => CivilStatus::all(),
            'Gender' => Gender::all(),
            // 'auth' => Auth::user(),
            
            'Application' => $applicantData, // Use the transformed applicant data
            'ExamSchedule' => $applicantSchedule,
            'ExamResult' => $applicantId ? ExamResult::where('applicant_id', $applicantId)->first() : null,


        ]);
    // }
    })->name('examresults');

    Route::get('/announcements', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        return Inertia::render('Applicant/Announcements',[
            'Schools' => School::all(),
            'Campuses' => Campus::all(),
            'Courses' => Course::all(),
            'TrackStrand' => TrackStrand::all(),
            'CivilStatus' => CivilStatus::all(),
            'Gender' => Gender::all(),
            // 'auth' => Auth::user(),
            

        ]);
    // }
    })->name('announcements');
    Route::get('/getzip', function () {
        // Get the search input from the request
        $search = Request::input('search');
    
        // Query the Zip model for the given zip code
        $zipData = Zip::where('zip', $search)->first(); // Use first() to get the first matching record
    
        // Check if any record was found
    
            return response()->json($zipData); // Return the found record as JSON
      
    });
   
  
    Route::get('/application-details', function(){
    //    $applicantDetails =  Request::validate([
    //         'last_name' => 'required',
    //         'first_name' => 'required',
    //         'middle_name' => 'required',
    //         'ext_name' => 'required',
    //         'street_address' => 'required',
    //         'city_address' => 'required',
    //         'province_address' => 'required',
    //         'zip' => 'required',
    //         'civil_status' => 'required',
    //         'sex' => 'required',
    //         'birthday' => 'required',
    //         'citizenship' => 'required',
    //         'place_birth' => 'required',
    //         'religion' => 'required',
    //         'contact_no' => 'required',
    //         'emergency_contact_name' => 'required',
    //         'emergency_contact_no' => 'required',
    //         'curriculum' => 'required',
    //         'sla_name' => 'required',
    //         'sla_address' => 'required',
    //         'sla_completed_year' => 'required',
    //         'sla_track' => 'required',
    //         'sla_strand' => 'required',
    //         'isPWD' => 'required',
    //         'isIPs' => 'required',
    //         'isSoloParent' => 'required',
    //         'isGIDAs' => 'required',
    //         'dc_campus' => 'required',
    //         'dc_cource' => 'required',

    //     ]);
    // Applicant::updateOrCreate(Request::input('applicationDetails'));
      
    // return redirect()->route('home');
    $existingApplicant = Applicant::where('last_name',Request::input('applicationDetails.last_name'))
    ->where('first_name', Request::input('applicationDetails.first_name'))
    ->where('middle_name', Request::input('applicationDetails.middle_name'))
    ->where('birthday', Request::input('applicationDetails.birthday'))
    ->first();

        if ($existingApplicant) {
            // If an existing applicant is found, you can return an error message or redirect as needed
            return redirect()->back()->withErrors(['msg' => 'Applicant with this name and birthday already exists.']);
        }
        else{
            Applicant::updateOrCreate(Request::input('applicationDetails'));

            return redirect()->route('home')->with('success', 'Application submitted successfully.');
    
        }

    }
);


});


