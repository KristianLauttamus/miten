<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Shows the loginpage
     */
    public function getLogin(){
        return view('login');
    }

    /**
     * Handles login request
     */
    public function postLogin(Request $request){
        if(User::authenticate($request->input('email'), $request->input('password'), $request->get('remember_me'))){
            flash('Kirjautuminen onnistui');

            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with();
        }
    }

    public function getRegister(){
        return view('register');
    }

    public function postRegister(Request $request){
        return $request->all();
    }
}
