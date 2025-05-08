<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'uuid',
        'equity_group',
        'applicant_id',
        'percentile_rank',
        'reading',
        'math',
        'language',
        'status_1',
        'status_2',
        'endorsed_for',
];
    public function applicant()
{
    return $this->belongsTo('App\Models\Applicant','applicant_id');
}
}
