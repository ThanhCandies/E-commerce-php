<?php

namespace App\models;

use App\core\Application;
use App\core\DbModel;
use App\core\Model;

class LoginForm extends Model
{
    public function authenticate()
    {
        $user = User::where('username', $this->username)
            ->orWhere('email', $this->username)
            ->first();

        if (!$user || !password_verify($this->password, $user->getAttribute('password'))) {
            $this->addError('username', "Email or password incorrect.");
            $this->addError('password', "Email or password incorrect.");
            return $this->success = false;
        }
        Application::$app->login($user);
        return $this->success = true;
    }


    public function rules(): array
    {
        return [
            "username" => [self::RULE_REQUIRED],
            "password" => [self::RULE_REQUIRED]
        ];
    }
}
