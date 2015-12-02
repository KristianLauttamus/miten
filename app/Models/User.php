<?php namespace App\Models;

use App\Models\Model;

class User extends Model
{
    protected $table = "users";

    /**
     * Get the current User that's logged in
     */
    public static function getUserLoggedIn(){
    	$user = User::where('remember_token', session()->get('remember_token'))->get();

    	if($user == null){
    		return null;
    	} else {
    		return $user;
    	}
    }
}
