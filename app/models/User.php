<?php

namespace App\models;

use App\core\DbModel;
use App\core\UserModel;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    protected array $fillable = [
        'id',
        'firstname',
        'lastname',
        'email',
        'username',
        'password',
        'status',
        'role'
    ];

    protected array $hidden = [
        'password',
        'confirmPassword'
    ];

    public function save()
    {
        $this->setAttributes('password', password_hash($this->getAttribute('password'), PASSWORD_DEFAULT));
//        dump($this->password);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'username' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6], [self::RULE_MAX, 'max' => 256]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'terms' => [self::RULE_REQUIRED]
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
