<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table='sections';
    protected $fillable=['program_id','name'];
    public function program()
    {
        return $this->belongsTo('App\Models\Program','program_id');
    }
}
