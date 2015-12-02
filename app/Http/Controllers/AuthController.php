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
        return $request->all();
    }

    public function getRegister(){
        return view('register');
    }

    public function postRegister(Request $request){
        return $request->all();
    }
}
