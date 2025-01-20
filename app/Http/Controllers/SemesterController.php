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

class SemesterController extends Controller
{
    public function index()
    {
        return Semester::all();
    }

}
