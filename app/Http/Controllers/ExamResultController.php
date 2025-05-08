<?php

namespace App\Http\Controllers;
use App\Imports\ExamResultImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
class ExamResultController extends Controller
{
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,csv|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Log the file information
        \Log::info('Uploaded file:', [
            'original_name' => $request->file('file')->getClientOriginalName(),
            'path' => $request->file('file')->getRealPath(),
        ]);
        // dd($request->file('file'));
    
        Excel::import(new ExamResultImport, $request->file('file'));

        return redirect()->back()->with('success', 'Import successful!');
    }
}
