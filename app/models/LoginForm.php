<?php

namespace App\models;

use App\core\Application;
use App\core\DbModel;
use App\core\Model;

class LoginForm extends Model
{
	public string $username = '';
	public string $email = '';
	protected string $password = '';

	public function authenticate()
	{
		$user = User::findOne(['username' => $this->username, 'email' => $this->username], "OR");
		// dd(password_verify($this->password, $user->password));
		if (!$user || !password_verify($this->password, $user->getAttr('password'))) {
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
