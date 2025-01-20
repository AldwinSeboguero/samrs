<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegistered;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','email', 'password','picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
    public function role(){
        return $this->hasOne('App\UserRole','user_id','id');
    }
    public function studentAccount(){
        return $this->hasOne('App\Student','user_id','id');
    }
    public function programs(){
        return $this->belongsToMany('App\Program');
    }

    public function hasAnyRoles($roles){
        if($this->roles()->whereIn('name', $roles)->first()){
            return true;
        }

        return false;
    }
    public function designees(){
        return $this->hasMany('App\SignatoryV2'::class,'user_id','id');
 
    }
    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }

        return false;
    } 
    // public function role(){
    //     return $this->belongsTo('App\UserRole');
    // }
    public function userRole($id){
    
        return $this->role()->where('user_id', $id)->first();
    } 
    public function isAdmin(){
        return strtolower($this->hasRole('admin'));
    }
    public function userInformation()
    {
        return $this->name;
    }
    public function secrets()
{
    return $this->hasMany('App\Secret');
}
public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
}

}
