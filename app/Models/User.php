<?php

namespace App\Models;

use App\Models\BaseModel;

class User extends BaseModel
{
    protected $table = "users";

    /**
     * Get the current User that's logged in
     */
    public static function getUserLoggedIn()
    {
        return User::where('remember_token', '=', session()->get('remember_token'))->get();
    }

    /**
     * Try authenticating the user with given credentials
     * @param String $email User's email
     * @param String $password User's unencrypted password
     * @param boolean $remember Create Cookie?
     */
    public static function authenticate($email, $password, $remember = false)
    {
        // TODO: Authenticate
    }
}
