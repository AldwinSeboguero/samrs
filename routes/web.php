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
use App\Models\ExamSchedule; 
use App\Models\ApplicantSchedule; 
use App\Models\SubmissionSchedule; 


use App\Models\Role;


Route::get('/favicon.ico', function () {
    $path = asset('images/favicon.ico');
    if (file_exists($path)) {
        return response()->file($path);
    }
    abort(404);
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
        return Inertia::render('Gap/Schedules/index',[
            'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
            'exam_schedules' => ExamSchedule::query()
            ->orderBy('exam_date', 'desc') 
            ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
            ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
            ->groupBy('exam_schedules.id')
            ->havingRaw('slot > total_applicants')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($schedule) => [
                'id' => $schedule->id,
                'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y'),
                'exam_time' => (new DateTime($schedule->exam_date))->format('h:i A'),
                'available' =>  $schedule->slot -  $schedule->total_applicants,
                'slot' => $schedule->slot,
                'venue' => $schedule->venue->name,
                'created_at' => $schedule->created_at ? $schedule->created_at->format('M d, Y') : '',
                'created_at_human' => $schedule->created_at ? $schedule->created_at->diffForHumans() : '',
            ]),
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
    })->name('exam.schedules');



    Route::get('/exam/attendance', function () {
        // if (Auth::check() && Applicant::where('email', Auth::user()->email)->exists()) {
        //     dd('Applied!');
        // }
        // else{
        return Inertia::render('Gap/Schedules/index',[
            'filters' =>  Request::only(['search','selectedStatus','selectedYear','status']),
            'exam_schedules' => ExamSchedule::query()
            ->orderBy('exam_date', 'desc') 
            ->leftJoin('applicant_schedules', 'exam_schedules.id', '=', 'applicant_schedules.exam_schedule_id')
            ->select('exam_schedules.*', DB::raw('COUNT(applicant_schedules.id) as total_applicants'))
            ->groupBy('exam_schedules.id')
            ->havingRaw('slot > total_applicants')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($schedule) => [
                'id' => $schedule->id,
                'exam_date' => (new DateTime($schedule->exam_date))->format('M d, Y'),
                'exam_time' => (new DateTime($schedule->exam_date))->format('h:i A'),
                'available' =>  $schedule->slot -  $schedule->total_applicants,
                'slot' => $schedule->slot,
                'venue' => $schedule->venue->name,
                'created_at' => $schedule->created_at ? $schedule->created_at->format('M d, Y') : '',
                'created_at_human' => $schedule->created_at ? $schedule->created_at->diffForHumans() : '',
            ]),
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
    })->name('exam.attendance');
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
        'Schools' => School::all(),
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
['name' => Request::input('school.name')], // Attributes to match
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

});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate-pdf');

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

            'ExamResult' => $applicant ? ApplicantSchedule::where('applicant_id',$applicant->id)->first() : null,


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
            'ExamResult' => $applicantId ? ApplicantSchedule::where('applicant_id', $applicantId)->first() : null,
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
            'ExamResult' => $applicantId ? ApplicantSchedule::where('applicant_id', $applicantId)->first() : null,


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


