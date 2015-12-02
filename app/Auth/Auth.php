<?php

namespace App\Auth;

class Auth {

    protected $model;

    public function __construct(UserContract $model)
    {
        $this->model = $model;
    }

    public function retrieveById($identifier)
    {

    }

    public function retrieveByToken($identifier, $token)
    {

    }

    public function updateRememberToken(UserContract $user, $token)
    {

    }

    public function retrieveByCredentials(array $credentials)
    {

    }

    public function validateCredentials(UserContract $user, array $credentials)
    {

    }

}
