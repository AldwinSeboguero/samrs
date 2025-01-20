<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitClearance extends Model
{
    
    protected $table='submit_clearances';
    protected $fillable=['clearance_id','staff_id'];
    public function clearance()
    {
        return $this->belongsTo('App\Models\Clearance','clearance_id');
    }
    public function staff()
    {
        return $this->belongsTo('App\Models\Staff','staff_id');
    }
}
