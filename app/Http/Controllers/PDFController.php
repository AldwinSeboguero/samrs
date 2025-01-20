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

class PdfController extends Controller
{
    public function generatePDF()
    {

        // $dtrDate = Request::input('dtrDate');
        $dtrDate = Request::input('dtrDate');
        $selectedMonth = Request::input('selectedMonth') ? Request::input('selectedMonth') : Carbon::now()->month; 
        $selectedYear = Request::input('selectedYear') ? Request::input('selectedYear') : Carbon::now()->year;

        $employee_id = Request::input('employee_id');
        

        $today = Carbon::now()->format('n/j/Y');
        $data =  Request::input('data');
        $employee = Employee::query()
        ->where('id', $employee_id)
        ->first(); // Fetch the first matching employee
    
        if ($employee) {
            $employeeData = [
                'id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'gender' => $employee->gender,

                'name' => $employee->last_name . ", " . $employee->first_name . ' ' . $employee->middle_name,
                'position' => $employee->position->name,
                'division' => $employee->division->name,
                'status' => $employee->employeeType->name,
                'gender' => $employee->gender,
                'birthday' => $employee->date_of_birth ? $employee->date_of_birth->format('M d, Y') : '',
                'work_days' => $employee->workDays ? json_decode($employee->workDays->data)->TimeDesc : '',

            ];
        } else {
            $employeeData = null; // Handle employee not found case
        }
        

        $currentMonth = $selectedMonth ? $selectedMonth: Carbon::now()->month;
        $currentYear =  $selectedYear ? $selectedYear:  Carbon::now()->year;
        // $currentMonth = '07';
        // $currentYear =  '2024';

        $startDate = Carbon::create($currentYear, $currentMonth, 1)->format('Y-m-d');
        $endDate = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth()->format('Y-m-d');
        $endDate2 = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth()->format('j');

        $regular_days = Carbon::create($currentYear, $currentMonth, 1)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        },  Carbon::create($currentYear, $currentMonth, 1)->endOfMonth());
        if($employee_id){
            
            $attendance =Timesheet::orderByDesc('transaction_date')->whereBetween('transaction_date',[$startDate,$endDate])->where('employee_id',$employee_id)
                                ->get()->map(
                                    function($inner){
                                        return [
                                            'id' => $inner->id,
                                            'loginam' => $inner->loginam,
                                            'logoutam' => $inner->logoutam,
                                            'loginpm' => $inner->loginpm,
                                            'logoutpm' => $inner->logoutpm,
                                            'transaction_date' => $inner->transaction_date,
                                            // 'bypass' => $inner->bypass,
                                            // 'bypass1' => $inner->bypass1,
                                            // 'bypass2' => $inner->bypass2,
                                            // 'bypass3' => $inner->bypass3,
                                            // 'remarks' => $inner->remarks,



                    
                                        ];                
                                    }
                                );
        }
        else{

            
            $attendance = null;
        }
        
        $days = [];
        for ($day = 1; $day <= $endDate2; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);

            $amin = '';
            $amout = '';
            $pmin = '';
            $pmout = '';
            $bypass = '';
            $bypass1 = '';
            $bypass2 = '';
            $bypass3 = '';
            $remarks = '';

            if($attendance){
                $log = $attendance->firstWhere('transaction_date', $date->format('Y-m-d'));
                // dd($log);

                if ($log) {
                    $amin = $log['loginam'];
                    $amout = $log['logoutam'];
                    $pmin = $log['loginpm'];
                    $pmout = $log['logoutpm'];
                 
    
    
    
                    // dd($amin);
    
                }
             
                // dd($date->format('l'),);
                $days[] = [
                        'date' => $day,
                        'day' => $date->format('l'),
                        'amin' => $amin ? Carbon::createFromFormat('H:i:s', $amin)->format('h:i') : ($date->format('l') == 'Saturday' ? 'SAT' : ($date->format('l') == 'Sunday' ? 'SUN' : (Holiday::where('holidate',$date)->get()->first() ? 
                        (Holiday::where('holidate',$date)->get()->first()->holidayam ? 'HOL':'') :''))) ,
                        'amout' => $amout ? Carbon::createFromFormat('H:i:s', $amout)->format('h:i')  : ($date->format('l') == 'Saturday' ? 'SAT' : ($date->format('l') == 'Sunday' ? 'SUN' :(Holiday::where('holidate',$date)->get()->first() ? 
                        (Holiday::where('holidate',$date)->get()->first()->holidayam ? 'HOL':'') :''))) ,
                        'pmin' => $pmin ?Carbon::createFromFormat('H:i:s', $pmin)->format('h:i')  : ($date->format('l') == 'Saturday' ? 'SAT' : ($date->format('l') == 'Sunday' ? 'SUN' :(Holiday::where('holidate',$date)->get()->first() ? 
                        (Holiday::where('holidate',$date)->get()->first()->holidaypm ? 'HOL':'') :''))) ,
                        'pmout' => $pmout ? Carbon::createFromFormat('H:i:s', $pmout)->format('h:i')  : ($date->format('l') == 'Saturday' ? 'SAT' : ($date->format('l') == 'Sunday' ? 'SUN' :(Holiday::where('holidate',$date)->get()->first() ? 
                        (Holiday::where('holidate',$date)->get()->first()->holidaypm ? 'HOL':'') :''))) ,
                        // 'isHolidayAM' => Holiday::where('holidate',$date)->get()->first() ? Holiday::where('holidate',$date)->get()->first()->holidayam : '',
                        // 'isHolidayPM' => Holiday::where('holidate',$date)->get()->first() ? Holiday::where('holidate',$date)->get()->first()->holidaypm : '',
        
        
                    ];
                
            }
            
           
        }
        // dd($days);

        $month = $startDate ? Carbon::create($startDate)->format('F, Y'): Carbon::now()->format('F, Y');
        $id = Request::input('id');
        $data = [
            'filters' =>  Request::only(['search','employee_id','selectedOffice']),
            'selectedMonth' => $selectedMonth,
            'selectedYear' => $selectedYear, 
            'month' => $month ,
            'years' => Timesheet::whereNotNull('created_at')->get()->pluck('created_at') // Get the collection of created_at dates
            ->map(function ($date) {
                return $date->format('Y'); // Format to 'Y' (year)
            })
            ->unique() // Get unique years
            ->sort() // Sort the years if needed
            ->values() // Reindex the array
            ->toArray(),
            'employee' => $employeeData,
            'at' => $attendance,
            'attendances' => Timesheet::orderByDesc('transaction_date')->whereBetween('transaction_date',['2024-07-01','2024-07-31'])->where('employee_id',128)->get(),
            'time_records' => $days,
        ];
        $pdf = PDF::loadView('dtr', $data);

        $pdf->setPaper('legal', 'portrait'); // Adjust paper size and orientation as needed
        //A3: 'A3' - 297 x 420 mm or 11.7 x 16.5 inches
        //A4: 'A4' - 210 x 297 mm or 8.3 x 11.7 inches
        //A5: 'A5' - 148 x 210 mm or 5.8 x 8.3 inches
        //Letter: 'letter' or '8.5x11' - 8.5 x 11 inches
        //Legal: 'legal' or '8.5x14' - 8.5 x 14 inches
        //Tabloid: 'tabloid' or '11x17' - 11 x 17 inches
        return $pdf->download($employeeData['name'].$month.'dtr.pdf');
        
        
    }
    // public function create(Request $request)
    // {   
       
    //     $paperSize = 'a4';
    //     $orientation = 'portrait';
    //     $clearance = Clearance::where('id',$request->clearance)->first();
    //     // dd($clearance);
    //     $student = Student::find($clearance->student_id);
    //     $purposeClearance = ClearancePurpose::where('id',$clearance->purpose_id)->first();
    //     $purpose = json_decode($purposeClearance->purpose)->name.' '.
    //         json_decode($purposeClearance->purpose)->description;
	// 	/* When saved, the PDF file generated will have a name with the format */
    //     /* 2010-john-doe-01012085945.pdf */
        
    //     $activeClearancePurpose = $purposeClearance;
  
    //     $clearanceRequest = ClearanceRequest::where('student_id',$student->id)->get();
    //     //signatories info
    //     $staffPD = Staff_PD::where('program_id', $student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffDEAN = Staff_DEAN::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffSTCOUNCIL = StaffStCouncil::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffCASHIER = Staff::where('designee_id',Designee::where('name','Cashier')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffOSAS = Staff::where('designee_id',Designee::where('short_name','OSAS')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffLIBRARY = Staff::where('designee_id',Designee::where('name','Library')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRAR = Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRARSTAFF = StaffRegistrar::with('user')->where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first() ? 
    //     StaffRegistrar::where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first()
    //     :
    //     Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();;

    //     //staff
    //     $staffPD_id =null;
    //     $staffDEAN_id =null;
    //     $staffSTCOUNCIL_id =null;
    //     $staffCASHIER_id =null;
    //     $staffOSAS_id =null;
    //     $staffLIBRARY_id =null;
    //     $staffREGISTRAR_id =null;
    //     $staffREGISTRARSTAFF_id =null;

    //     //clearance request signatory
    //     $pd = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',1);
    //     })
    //     ->latest('id')->first();

    //     $dean = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',2);
    //     })
    //     ->latest('id')->first();
    //     $council = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',8);
    //     })
    //     ->latest('id')->first();

    //     $cashier = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',3);
    //     })
    //     ->latest('id')->first();

    //     $osas = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',6);
    //     })
    //     ->latest('id')->first();

    //     $library = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',5);
    //     })
    //     ->latest('id')->first();

    //     $registrar = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',4);
    //     })
    //     ->latest('id')->first();
       
    //     $registrarstaff = ClearanceRequest::where('student_id',$student->id)
    //     ->where('approved_at','!=',null)
    //     ->where('purpose_id',$clearance->purpose_id)
    //     ->whereHas('staff',function($query){
    //         $query->where('designee_id',9);
    //     })
    //     ->latest('id')->first();

    //     // dd($pd);
    //      //staff id
    //      if ($staffPD) {
    //         $staffPD_id = $pd->staff_id;
         
    //      }
        
       
    //      if ($staffDEAN) {
    //         $staffDEAN_id = $dean->staff_id;
    //     }
    //     if ($staffSTCOUNCIL) {
    //         $staffSTCOUNCIL_id = $council->staff_id;
    //     }
    //     if ($staffCASHIER) {
    //         $staffCASHIER_id = $cashier->staff_id;
    //     }
    //     if ($staffOSAS) {
    //         $staffOSAS_id = $osas->staff_id;
    //     }
    //     if ($staffLIBRARY) {
    //         $staffLIBRARY_id = $library->staff_id;
    //     }
    //     if ($staffREGISTRAR && $registrar) {
    //         $staffREGISTRAR_id = $registrar->staff_id;
    //     } 
    //     if ($staffREGISTRARSTAFF) {
            
           
              
    //             //  $staf1 = $registrarstaff->staff_id;
    //             //  $staf2 = $registrar->staff_id;
    //              $staffREGISTRARSTAFF_id = $registrarstaff ? $registrarstaff->staff_id : $registrar->staff_id;
                
    //     }
 
    //     $clearanceRequestSTCOUNCIL = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id',$staffSTCOUNCIL_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestCASHIER = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id', $staffCASHIER_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestLIBRARY = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id', $staffLIBRARY_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestOSAS = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id',$staffOSAS_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestPROGRAMDIRECTOR = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id',$staffPD_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestDEAN = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id',$staffDEAN_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRARSTAFF = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id', $staffREGISTRARSTAFF_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRAR = ClearanceRequest::orderBy('approved_at','desc')->where('approved_at','!=',null)->where('student_id',$student->id)
    //     ->where('staff_id',$staffREGISTRAR_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
 
    //     $clearanceREGS = $clearanceRequestREGISTRARSTAFF ? $clearanceRequestREGISTRARSTAFF : $clearanceRequestREGISTRAR;




	// 	$format = "mdyhis";
	// 	$file_name = $student->slug . "-".
    //                 Carbon::now()->format($format) . ".pdf";
      
    //        $pdf = PDF::loadView('pdf',compact('student'
    //        , 'file_name'
    //        ,'purpose'
    //        ,'staffPD'
    //        ,'staffDEAN'
    //        ,'staffCASHIER'
    //        ,'staffSTCOUNCIL'
    //        ,'staffLIBRARY'
    //        ,'staffOSAS'
    //        ,'staffREGISTRARSTAFF'
    //        ,'clearanceRequestCASHIER'
    //        ,'clearanceRequestPROGRAMDIRECTOR'
    //        ,'clearanceRequestDEAN'
    //        ,'clearanceRequestSTCOUNCIL'
    //        ,'clearanceRequestLIBRARY'
    //        ,'clearanceRequestOSAS'
    //        ,'clearanceREGS'
    //        ,'clearance'
    //     ));
       
    // 	// $data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
    //     // $pdf = PDF::loadView('pdf', $student);
  
    //     return $pdf->output();
    // }
    // public function createSGS(Request $request)
    // {
    //     $paperSize = 'a4';
    //     $orientation = 'portrait';
        
    //     $clearance = Clearance::where('id',$request->clearance)->first();
    //     // dd($clearance);
    //     $student = Student::find($clearance->student_id);
    //     $purposeClearance = ClearancePurpose::where('id',$clearance->purpose_id)->first();
    //     $purpose = json_decode($purposeClearance->purpose)->name.' '.
    //         json_decode($purposeClearance->purpose)->description;
    //     $student = Student::find($clearance->student_id);
        
       
       
	// 	/* When saved, the PDF file generated will have a name with the format */
    //     /* 2010-john-doe-01012085945.pdf */
        
    //     $activeClearancePurpose = $purposeClearance;
  
    //         $clearanceRequest = ClearanceRequest::where('student_id',$student->id)->get();
    //     //signatories info
    //     $staffPD = Staff_PD::where('program_id', $student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffDEAN = Staff_DEAN::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffSTCOUNCIL = StaffStCouncil::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffCASHIER = Staff::where('designee_id',Designee::where('name','Cashier')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffOSAS = Staff::where('designee_id',Designee::where('short_name','OSAS')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffLIBRARY = Staff::where('designee_id',Designee::where('name','Library')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRAR = Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRARSTAFF = StaffRegistrar::where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first() ? 
    //     StaffRegistrar::where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first()
    //     :
    //     Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();;

    //     //staff
    //     $staffPD_id =null;
    //     $staffDEAN_id =null;
    //     $staffSTCOUNCIL_id =null;
    //     $staffCASHIER_id =null;
    //     $staffOSAS_id =null;
    //     $staffLIBRARY_id =null;
    //     $staffREGISTRAR_id =null;
    //     $staffREGISTRARSTAFF_id =null;
    //      //staff id
    //      //clearance request signatory
    //      $pd = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',1);
    //      })
    //      ->latest('id')->first();
 
    //      $dean = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',2);
    //      })
    //      ->latest('id')->first();
    //      $council = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',8);
    //      })
    //      ->latest('id')->first();
 
    //      $cashier = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',3);
    //      })
    //      ->latest('id')->first();
 
    //      $osas = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',6);
    //      })
    //      ->latest('id')->first();
 
    //      $library = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',5);
    //      })
    //      ->latest('id')->first();
 
    //      $registrar = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',4);
    //      })
    //      ->latest('id')->first();
 
    //      $registrarstaff = ClearanceRequest::where('student_id',$student->id)
    //      ->where('approved_at','!=',null)
    //      ->where('purpose_id',$clearance->purpose_id)
    //      ->whereHas('staff',function($query){
    //          $query->where('designee_id',4);
    //      })
    //      ->latest('id')->first();
 
    //      // dd($pd);
    //       //staff id
    //       if ($staffPD) {
    //          $staffPD_id = $pd->staff_id;
          
    //       }
         
        
    //       if ($staffDEAN) {
    //          $staffDEAN_id = $dean->staff_id;
    //      }
    //      if ($staffSTCOUNCIL) {
    //          $staffSTCOUNCIL_id = $council->staff_id;
    //      }
    //      if ($staffCASHIER) {
    //          $staffCASHIER_id = $cashier->staff_id;
    //      }
    //      if ($staffOSAS) {
    //          $staffOSAS_id = $osas->staff_id;
    //      }
    //      if ($staffLIBRARY) {
    //          $staffLIBRARY_id = $library->staff_id;
    //      }
    //      if ($staffREGISTRAR) {
    //          $staffREGISTRAR_id = $registrar->staff_id;
    //      } 
    //      if ($staffREGISTRARSTAFF) {
    //         $staffREGISTRARSTAFF_id = Staff::where('designee_id',Designee::where('short_name','registrarstaff')->first()->id)->where('user_id',$staffREGISTRARSTAFF->user_id)->where('semester_id',$activeClearancePurpose->semester_id)->first()->id;
 
    //     }
    //     $clearanceRequestSTCOUNCIL = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffSTCOUNCIL_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestCASHIER = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffCASHIER_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestLIBRARY = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffLIBRARY_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestOSAS = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffOSAS_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestPROGRAMDIRECTOR = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffPD_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestDEAN = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffDEAN_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRARSTAFF = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffREGISTRARSTAFF_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRAR = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffREGISTRAR_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
 
    //     $clearanceREGS = $clearanceRequestREGISTRARSTAFF ? $clearanceRequestREGISTRARSTAFF : $clearanceRequestREGISTRAR;




	// 	$format = "mdyhis";
	// 	$file_name = $student->slug . "-".
    //                 Carbon::now()->format($format) . ".pdf";
      
    //        $pdf = PDF::loadView('sgspdf',compact('student'
    //        , 'file_name'
    //        ,'purpose'
    //        ,'staffPD'
    //        ,'staffDEAN'
    //        ,'staffCASHIER'
    //        ,'staffSTCOUNCIL'
    //        ,'staffLIBRARY'
    //        ,'staffOSAS'
    //        ,'staffREGISTRARSTAFF'
    //        ,'clearanceRequestCASHIER'
    //        ,'clearanceRequestPROGRAMDIRECTOR'
    //        ,'clearanceRequestDEAN'
    //        ,'clearanceRequestSTCOUNCIL'
    //        ,'clearanceRequestLIBRARY'
    //        ,'clearanceRequestOSAS'
    //        ,'clearanceREGS'
    //        ,'clearance'
    //     ));
       
    // 	// $data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
    //     // $pdf = PDF::loadView('pdf', $student);
  
    //     return $pdf->output();
    // }
    // public function createLHS(Request $request)
    // {
    //     $paperSize = 'a4';
    //     $orientation = 'portrait';
    //     $clearance = Clearance::where('id',$request->clearance)->first();
    //     $student = Student::find($clearance->student_id);
    //     $purposeClearance = ClearancePurpose::find($clearance->purpose_id);
    //     $purpose = json_decode($purposeClearance->purpose)->name.' '.
    //         json_decode($purposeClearance->purpose)->description;
	// 	/* When saved, the PDF file generated will have a name with the format */
    //     /* 2010-john-doe-01012085945.pdf */
        
    //     $activeClearancePurpose = $purposeClearance;
  
    //         $clearanceRequest = ClearanceRequest::where('student_id',$student->id)->get();
    //     //signatories info
    //     $staffPD = Staff_PD::where('program_id', $student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffDEAN = Staff_DEAN::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffSTCOUNCIL = StaffStCouncil::where('college_id', $student->program->college_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffCASHIER = Staff::where('designee_id',Designee::where('name','Cashier')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffOSAS = Staff::where('designee_id',Designee::where('short_name','OSAS')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffLIBRARY = Staff::where('designee_id',Designee::where('name','Library')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRAR = Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();
    //     $staffREGISTRARSTAFF = StaffRegistrar::where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first() ? 
    //     StaffRegistrar::where('program_id',$student->program_id)->where('semester_id',$activeClearancePurpose->semester_id)->first()
    //     :
    //     Staff::where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->semester_id)->first();;

    //     //staff
    //     $staffPD_id =null;
    //     $staffDEAN_id =null;
    //     $staffSTCOUNCIL_id =null;
    //     $staffCASHIER_id =null;
    //     $staffOSAS_id =null;
    //     $staffLIBRARY_id =null;
    //     $staffREGISTRAR_id =null;
    //     $staffREGISTRARSTAFF_id =null;
    //      //staff id
    //      if ($staffPD) {
    //         $staffPD_id = Staff::where('designee_id',Designee::where('short_name','pd')->first()->id)->where('user_id',$staffPD->user_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
         
    //      }
    //      if ($staffADVISER) {
    //         $staffADVISER_id = Staff::where('designee_id',Designee::where('short_name','pd')->first()->id)->where('user_id',$staffADVISER->user_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
         
    //      }
    //      if ($staffPRINCIPAL) {
    //         $staffPRINCIPAL_id = Staff::where('designee_id',Designee::where('name','Principal')->first()->id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
        
    //     }
    //      if ($staffDEAN) {
    //         $staffDEAN_id = Staff::where('designee_id',Designee::where('short_name','dean')->first()->id)->where('user_id',$staffDEAN->user_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
         
    //     }
    //     if ($staffSTCOUNCIL) {
    //         $staffSTCOUNCIL_id = Staff::where('designee_id',Designee::where('short_name','stcouncil')->first()->id)->where('user_id',$staffSTCOUNCIL->user_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
         
    //     }
    //     if ($staffCASHIER) {
    //         $staffCASHIER_id = Staff::where('designee_id',Designee::where('short_name','cashier')->first()->id)->where('designee_id',Designee::where('name','Cashier')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
        
    //     }
    //     if ($staffOSAS) {
    //         $staffOSAS_id = Staff::where('designee_id',Designee::where('short_name','OSAS')->first()->id)->where('designee_id',Designee::where('short_name','OSAS')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
        
    //     }
    //     if ($staffLIBRARY) {
    //         $staffLIBRARY_id = Staff::where('designee_id',Designee::where('short_name','library')->first()->id)->where('designee_id',Designee::where('name','Library')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
         
    //     }
    //     if ($staffREGISTRAR) {
    //         $staffREGISTRAR_id = Staff::where('designee_id',Designee::where('short_name','registrar')->first()->id)->where('designee_id',Designee::where('name','Registrar')->first()->id)->where('campus_id',$student->program->campus_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
        
    //     }
    //     if ($staffREGISTRARSTAFF) {
    //         $staffREGISTRARSTAFF_id = Staff::where('designee_id',Designee::where('short_name','registrarstaff')->first()->id)->where('user_id',$staffREGISTRARSTAFF->user_id)->where('semester_id',$activeClearancePurpose->purpose->semester_id)->first()->id;
 
    //     }
         
 
    //     $clearanceRequestSTCOUNCIL = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffSTCOUNCIL_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestCASHIER = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffCASHIER_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestLIBRARY = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffLIBRARY_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestOSAS = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffOSAS_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestPROGRAMDIRECTOR = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffPD_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestDEAN = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffDEAN_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRARSTAFF = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id', $staffREGISTRARSTAFF_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
    //     $clearanceRequestREGISTRAR = ClearanceRequest::where('student_id',$student->id)
    //     ->where('staff_id',$staffREGISTRAR_id)->where('purpose_id',$activeClearancePurpose->id)
    //     ->first();
 
    //     $clearanceREGS = $clearanceRequestREGISTRARSTAFF ? $clearanceRequestREGISTRARSTAFF : $clearanceRequestREGISTRAR;




	// 	$format = "mdyhis";
	// 	$file_name = $student->slug . "-".
    //                 Carbon::now()->format($format) . ".pdf";
      
    //        $pdf = PDF::loadView('lhspdf',compact('student'
    //        , 'file_name'
    //        ,'purpose'
    //        ,'staffPD'
    //        ,'staffDEAN'
    //        ,'staffCASHIER'
    //        ,'staffSTCOUNCIL'
    //        ,'staffLIBRARY'
    //        ,'staffOSAS'
    //        ,'staffREGISTRARSTAFF'
    //        ,'clearanceRequestCASHIER'
    //        ,'clearanceRequestPROGRAMDIRECTOR'
    //        ,'clearanceRequestDEAN'
    //        ,'clearanceRequestSTCOUNCIL'
    //        ,'clearanceRequestLIBRARY'
    //        ,'clearanceRequestOSAS'
    //        ,'clearanceREGS'
    //        ,'clearance'
    //     ));
       
    // 	// $data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
    //     // $pdf = PDF::loadView('pdf', $student);
  
    //     return $pdf->output();
    // }
}