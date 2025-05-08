<?php

namespace App\Imports;

use App\Models\ExamResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Applicant;
class ExamResultImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $applicant = Applicant::where('uuid',  $row[0])->first();
        return new ExamResult([
            'uuid' => $row[0],
            'equity_group' => $row[1],
            'applicant_id' => $applicant->id,
            'percentile_rank' => $row[2],
            'reading' => $row[3],
            'math' => $row[4],
            'language' => $row[5],
            'status_1' => $row[6],
            'status_2' => $row[7],
            'endorsed_for' => $row[8],
        ]);
    }
}
