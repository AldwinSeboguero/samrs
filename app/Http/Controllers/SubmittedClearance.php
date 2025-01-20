<?php

namespace App\Http\Controllers;
 
use App\Models\SubmitClearance; 
use App\Models\Role; 
use App\Models\User; 
use App\Models\Semester;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff_PD;
use Illuminate\Support\Facades\Auth; 
use App\Http\Resources\SubmittedClearance as SubmittedClearanceResource;
use App\Http\Resources\SubmittedClearanceCollection;
use App\Models\Staff;
use App\Models\SignatoryV2;
use Inertia\Inertia;
use Request;
class SubmittedClearance extends Controller
{
   
    public function index()
    {
        $per_page = Request::only(['per_page'])?  Request::only(['per_page']) : 10; 
        $semester =  Request::only(['semester']);
        $search =  Request::only(['search']);

        $semester_id =  Request::only(['semester_id']);
        $user_id =  Request::only(['user_id']);

        return Inertia::render('SubmittedClearance', [
            'table_data' => SubmitClearance::query()
                ->when( Request::input('semester'), function($q,$semester){
                    $q->whereHas('clearance.purpose', function($q) use($semester){
                        $q->where('semester_id', $semester);
                    });
                })
                ->when(Request::input('search'), function($inner, $search){
                    $inner->whereHas('clearance.student', function($q) use ($search){
                        $q->where('name', 'ILIKE', '%' . $search . '%')
                        ->orWhere('student_number', 'ILIKE', '%' . $search . '%');
                    });
                })
                ->when(Request::input('college'), function($inner, $college){
                    $inner->whereHas('clearance.student.program',function($q) use($college){
                        $q->where('college_id',$college);
                    });
                }) 
                ->when(Request::input('program'), function($inner, $program){
                    $inner->whereHas('clearance.student',function($q) use($program){
                        $q->where('program_id',$program);
                    });
                }) 
                ->paginate($per_page)
                ->withQueryString()
                ->through(fn($clearances) => [
                    'id' => $clearances->id,
                    'clearance_id' => $clearances->clearance_id,
                    'name' => $clearances->clearance->student->name,
                    'student_number' => $clearances->clearance->student->student_number,
                    'program' => $clearances->clearance->student->program->short_name,
                    'college' => $clearances->clearance->student->program->college->name,
                    'purpose' =>  $clearances->clearance->purpose ? json_decode(json_decode($clearances->clearance->purpose)->purpose)->name.' '.
                    json_decode(json_decode($clearances->clearance->purpose)->purpose)->description : "Null",
                    'created_at' => $clearances->clearance->created_at ? $clearances->clearance->created_at->format('M d, Y g:i A') : '',
                    'datesubmitted' => $clearances->created_at ?  $clearances->created_at->format('M d, Y g:i A') : '', 

                ]),
            'filters' =>  Request::only(['search']),
            
            ]);
          //  'create_url' => route('users.create'),
        
    }
    public function index1(Request $request){
        $per_page =$request->per_page ? $request->per_page : 10; 
        $semester = $request->semester;
        $search = $request->search;

        $semester_id = $request->semester_id;
        $user_id = $request->user_id;

       // $programs = SignatoryV2::where('user_id', $user_id)->distinct('campus_id')->get('campus_id');
       
            return response()->json([
                'table_data' => new SubmittedClearanceCollection(
                SubmitClearance::orderByDesc('updated_at')
                ->when($semester , function($q) use($semester){
                    $q->whereHas('clearance.purpose', function($q) use($semester){
                        $q->where('semester_id', $semester);
                    });
                })
                ->when($request->search, function($inner) use($request){
                    $inner->whereHas('clearance.student', function($q) use ($request){
                        $q->where('name', 'ILIKE', '%' . $request->search . '%')
                        ->orWhere('student_number', 'ILIKE', '%' . $request->search . '%');
                    });
                })
                ->when($request->college, function($inner) use($request){
                    $inner->whereHas('clearance.student.program',function($q) use($request){
                        $q->where('college_id',$request->college);
                    });
                }) 
                ->when($request->program, function($inner) use($request){
                    $inner->whereHas('clearance.student',function($q) use($request){
                        $q->where('program_id',$request->program);
                    });
                }) 
                ->paginate($per_page))
                ],200);
        

    }
}
