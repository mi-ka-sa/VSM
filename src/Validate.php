<?php

declare(strict_types = 1);

namespace App;

use Valitron\Validator;

class Validate
{
    private static array $data = [];
    private static array $rules = [
        'required' => ['nickname', 'email', 'password'],
        'email' => ['email'],
        'lengthBetween' => [
            ['password', 6, 20],
        ],
        'integer' => [
            ['age']
        ],
        'regex' => [
            ['nickname', '/^[a-zA-Z0-9]{4,10}$/'],
            // ['password', '/^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!#$%]))/']
           
        ],
        'alpha' => [
            ['name']
        ],
        'optional' => [
            ['nickname'],
            ['email'],
            ['password']
        ]
    ];

    public static function check()
    {
        $validator = new Validator(self::$data);
        $validator->rules(self::$rules);
        if ($validator->validate()) {
            return true;
        } else {
            $errors = '<ul>';
            foreach ($validator->errors() as $error) {
                foreach ($error as $item) {
                    $errors .= "<li>{$item}</li>";
                }
            }
            $errors .= '</ul>';
            $_SESSION['errors'] = $errors;
            return false;
        }
    }

    public static function setData($data)
    {
        foreach ($data as $k => $v) {
            $data[$k] = trim($data[$k]);
        }
        self::$data = $data;
    }

    public static function setFields($fields)
    {
        foreach (self::$data as $key => $val) {
            if (!in_array($key, $fields)) {
                unset(self::$data[$key]);
            }
        }
    }

    public static function getData()
    {
        return self::$data;
    }
}
