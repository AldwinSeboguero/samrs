<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
class GoogleController extends Controller
{
    public function googlepage()
    {
        return Socialite::driver('google')->stateless()->redirect();

    }
    public function googlecallback()
    {
        // try {

      
            // dd(Socialite::driver('google')->stateless()->user()->id);

            $user = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('email', $user->email)->first();

    

            if($finduser)



            {

       

                Auth::login($finduser);

      
                if(Auth::user()){
                    if ( Auth::user()->hasRole('Admin')) {
                        return redirect()->route('application.requests');
                
                    }
                    else if (Auth::user()->hasRole('User')){
                   
                        return redirect()->route('home');
                
                        }
                }
               else{
                return redirect()->route('login');
            
               }
       

            }



            else



            {

                $newUser = User::create([

                    'name' => $user->name,

                    'email' => $user->email,

                    'google_id'=> $user->id,

                    'password' => encrypt('123456dummy@')

                ]);
                $newUser->assignRole('User');

      

                Auth::login($newUser);

      

                return redirect()->intended('/login');

            }

      

        // } catch (Exception $e) {

        //     dd($e->getMessage());

        // }
    }
}
