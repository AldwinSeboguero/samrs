<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class School extends Model
{
    use HasFactory,LogsActivity;
    protected $fillable=['name','address'];
     // Implement the getActivitylogOptions method
     
    
     public function getActivitylogOptions(): LogOptions
     {
         // Create a new LogOptions instance and configure it
         $logOptions = new LogOptions();
         $logOptions->logAll(); // Log all attributes
         // Or customize with specific attributes you want to log
         $logOptions->logOnly(['name', 'address']); // Log only specified attributes
 
         return $logOptions; // Return the configured LogOptions instance
     }

}
