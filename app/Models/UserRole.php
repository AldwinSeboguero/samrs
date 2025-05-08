<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class UserRole extends Model
{
    protected $table='role_user';
    protected $fillable = ['role_id','user_id'];
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
     {
         // Create a new LogOptions instance and configure it
         $logOptions = new LogOptions();
         $logOptions->logAll(); // Log all attributes
         // Or customize with specific attributes you want to log
         $logOptions->logOnly([ 
            'role_id','user_id']); // Log only specified attributes
 
         return $logOptions; // Return the configured LogOptions instance
     }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }
}
