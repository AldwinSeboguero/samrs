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

      

                return redirect()->intended('dashboard');

       

            }



            else



            {

                // $newUser = User::create([

                //     'name' => $user->name,

                //     'email' => $user->email,

                //     'google_id'=> $user->id,

                //     'password' => encrypt('123456dummy')

                // ]);

      

                // Auth::login($newUser);

      

                return redirect()->intended('notregister');

            }

      

        // } catch (Exception $e) {

        //     dd($e->getMessage());

        // }
    }
}
