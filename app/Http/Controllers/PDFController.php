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
}