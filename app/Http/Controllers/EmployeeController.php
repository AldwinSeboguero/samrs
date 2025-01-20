<?php

namespace App\Http\Controllers;

use Request;
use Inertia\Inertia;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\EmployeeType;
use App\Models\EmploymentStatus;

use App\Models\Position;
use App\Models\Division;
use Illuminate\Http\Request as Request1;

use DB;


class EmployeeController extends Controller
{
    public function index()
    {
         
        $offices = Division::get();

        // Create a blank object
        $blankOffice = new \stdClass();
        $blankOffice->id = null; // or any other default values
        $blankOffice->name = 'All Offices'; // Ensure any required fields are present
    
        // Prepend the blank object to the collection
        $offices->prepend($blankOffice);

        $positions = Position::get();

        // Create a blank object
        $blankPosition = new \stdClass();
        $blankPosition->id = null; // or any other default values
        $blankPosition->name = 'All'; // Ensure any required fields are present
    
        // Prepend the blank object to the collection
        $positions->prepend($blankPosition);

        $statuses = EmployeeType::get();

        // Create a blank object
        $blankStatus = new \stdClass();
        $blankStatus->id = null; // or any other default values
        $blankStatus->name = 'All'; // Ensure any required fields are present
    
        // Prepend the blank object to the collection
        $statuses->prepend($blankStatus);

        return Inertia::render('Employees', [
            'filters' =>  Request::only(['search','selectedOffice','selectedPosition','selectedStatus']),
            'offices' => $offices,
            'positions' => $positions,
            'statuses' => $statuses,

            'table_data' => Employee::query()
            ->when(Request::input('selectedOffice'), function($inner, $search) {
                $inner->where('division_id',$search);
            })
            ->when(Request::input('selectedPosition'), function($inner, $search) {
                $inner->where('position_id',$search);
            })
            ->when(Request::input('selectedStatus'), function($inner, $search) {
                $inner->where('employee_type_id',$search);
            })
            ->when(Request::input('search'), function($inner, $search) {
                $inner->where(DB::raw("TRIM(CONCAT(last_name, ' ', first_name, ' ', COALESCE(middle_name, '')))"), 'LIKE', "%" . $search . "%");
            })->orderBy('last_name')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($employee) => [
                'id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'first_name' => $employee->first_name, 
                'last_name' => $employee->last_name, 
                'middle_name' => $employee->middle_name, 
                'position' => $employee->position->name, 
                'sg' => $employee->position->sg, 

                'division' => $employee->division->name, 
                'status' => $employee->employeeType->name, 
                'age' => $employee->age,
                'gender' => $employee->gender, 


                'birthday' => $employee->date_of_birth ?  $employee->date_of_birth->format('M d, Y ') : '', 



            ]),
            ]);
          //  'create_url' => route('users.create'),
        
    }
    public function edit()
    {
        $employee = Employee::query()
            ->when(Request::input('employee'), function ($query, $search) {
                $query->where('id', $search);
            })
            ->first(); // Get the first employee or null
    
        return Inertia::render('Employee/Edit', [
            'statuses' => EmploymentStatus::get(),
            'employee' => $employee ? [
                'id' => $employee->id,
                'employee_code' => $employee->employee_code,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'middle_name' => $employee->middle_name,
                'suffix_name' => $employee->suffix,
                'preferred_name' => $employee->preferred_name,
                'salutation' => $employee->salutation,
                'start_date' => $employee->start_date->format('Y-m-d') ,



                'position' => $employee->position->name,
                'sg' => $employee->position->sg,
                'division' => $employee->division->name,
                'status' => $employee->employeeType->name,
                'age' => $employee->age,
                'gender' => $employee->gender,
                'email' => $employee->email_address,
                
                'birthday' => $employee->date_of_birth ? $employee->date_of_birth->format('m/d/Y') : '',
            ] : null, // Return null if no employee is found
        ]);
    }
}
