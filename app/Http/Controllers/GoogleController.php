<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Exception;

class GoogleController extends Controller
{
    public function google_auth(){

        return Socialite::driver('google')->redirect();
    }
    public function google_callback(){
        try {
            $user =Socialite::driver('google')->user();
            $finduser = User::where('google_id',$user->id)->first();
            if( $finduser){
                Auth::login($finduser);
                return redirect()->intended('home');
            }else{
                $new_user =User::Create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'google_id'=>$user->id,
                    // 'passwork'=>encrypt('1234567dummy'),
                    
                ]);
                Auth::login($new_user);
                return redirect()->intended('home');
            }

        } 

        catch (Exception $th) {
           dd($th->getMessage());
        }
    }
}
