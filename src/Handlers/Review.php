<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;
use App\Validate;

class Review extends App
{
    private array $fields = [
        'comment',
        'id_titles',
        'rate'
    ];

    private array $rules = [
        'required' => ['comment', 'id_titles', 'rate'],
        'integer' => [
            ['id_titles']
        ],
        'max' => [
            ['rate', 5]
        ],
        'optional' => [
            ['rate']
        ]
    ];

    public function add()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['errors'] = ' Only a registered user can rate';
            redirect();
        }

        $data_user = $this->request->request->all();

        Validate::$rules = $this->rules;
        Validate::setData($data_user);
        
        // required fields must be in the form
        Validate::setFields($this->fields);
        if (Validate::check()) {
            $good_data = Validate::getData();
            $good_data['id_users'] = $_SESSION['user']['id'];
            $sth = $this->db->prepare("INSERT INTO titles_reviews(id_users, id_titles, rate, comment) 
                            VALUES(:id_users, :id_titles, :rate, :comment)");
            $sth->execute($good_data);

            $_SESSION['success'] = 'New review added';
            redirect();
        }

        $_SESSION['form_data'] = $data_user;
        redirect();
    }
}
