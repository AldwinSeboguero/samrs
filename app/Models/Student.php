<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Campus;
class Student extends Model
{
	protected $guarded = [];
    protected $table='students';
    protected $fillable=['id','student_number','slug','name','year','section_id','program_id','user_id','initial_password','semester_id'];
	protected $searchable = [
		/**
		 * Columns and their priority in search results.
		 * Columns with higher values are more important.
		 * Columns with equal values have equal importance.
		 *
		 * @var array
		*/
		'columns' => [
			 
			'students.name' => 10,
		],

		// 'joins' => [
		// 	'programs' => ['programs.id', 'students.program_id'],
		// 	'users' => ['users.id', 'students.user_id'],
		// ],
    ];
    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id'); 
    }
    public function program()
    {
        return $this->belongsTo('App\Models\Program','program_id'); 
    }
	public function user()
    {
        return $this->belongsTo('App\Models\User','user_id'); 
    }
	public function deficiencies()
    {
        return $this->belongsToMany('App\Models\Deficiency','deficiency_student','student_id','deficiency_id')->withTimestamps();
	}
	public function clearancerequest(){
        return $this->hasMany('App\Models\ClearanceRequestV2'::class,'student_id','id')
		->whereHas('purpose',function($q){
			$q->where('semester_id',8);
		})->where('status',1);
 
    }
	public function clearances(){
        return $this->hasMany('App\Models\Clearance'::class,'student_id','id')
		->whereHas('purpose',function($q){
			$q->where('semester_id',8);
		});
 
    }
	// public function deficienciesCount(){
	// 	return $this->deficiencies();
	// }

}
