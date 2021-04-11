<?php

namespace App\core;


abstract class Model
{
	public const RULE_REQUIRED = "required";
	public const RULE_EMAIL = "email";
	public const RULE_MIN = "min";
	public const RULE_MAX = "max";
	public const RULE_UNIQUE = "unique";
	public const RULE_MATCH = "match";
	public bool $success = true;

	public function loadData($data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}
	abstract public function rules(): array;

	public array $errors = [];

	public function validate()
	{
		foreach ($this->rules() as $attribute => $rules) {
			$value = $this->{$attribute};
			foreach ($rules as $rule) {
				$ruleName = $rule;
				if (!is_string($ruleName)) {
					$ruleName = $rule[0];
				}
				if ($ruleName === self::RULE_REQUIRED && !$value) {
					$this->addErrorWithRule($attribute, self::RULE_REQUIRED);
				}
				if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
					$this->addErrorWithRule($attribute, self::RULE_EMAIL);
				}
				if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
					$this->addErrorWithRule($attribute, self::RULE_MIN, $rule);
				}
				if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
					$this->addErrorWithRule($attribute, self::RULE_MAX, $rule);
				}
				if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
					$this->addErrorWithRule($attribute, self::RULE_MATCH, $rule);
				}
				if ($ruleName === self::RULE_UNIQUE) {
					$className = $rule['class'];
					$uniqueAttr = $rule['attribute'] ?? $attribute;
					$tableName = $className::tableName();

					$statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr='$value'");
					$statement->execute();
					$record = $statement->fetchObject();
					if ($record) {
						$this->addErrorWithRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
					}
				}
			}
		}
		if (empty($this->errors)) {
			return true;
		} else {
			$this->success = false;
			return false;
		}
		// return !empty($this->errors)?:$this->success=false;
	}

	public function addErrorWithRule(string $attribute, string $rule, $params = [])
	{
		$message = $this->errorMessages()[$rule] ?? '';
		foreach ($params as $key => $value) {
			$message = str_replace("{{$key}}", $value, $message);
		}
		$this->errors[$attribute][] = $message;
	}
	public function addError(string $attribute, string $message)
	{
		$this->errors[$attribute][] = $message;
	}
	public function errorMessages()
	{
		return [
			self::RULE_REQUIRED => 'This field is required',
			self::RULE_EMAIL => 'This field must be valid email address',
			self::RULE_MIN => 'Min length of this field must be {min}',
			self::RULE_MAX => 'Max length of this field must be {max}',
			self::RULE_MATCH => 'This field must be the same as {match}',
			self::RULE_UNIQUE => 'Record with this {field} already exists',
		];
	}

	public function hasError($attribute)
	{
		return $this->errors[$attribute] ?? false;
	}
	public function getFirstError($attribute)
	{
		return $this->error[$attribute][0] ?? false;
	}
}
