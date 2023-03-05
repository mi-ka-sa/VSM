<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;
use App\Validate;

class User extends App
{
    private array $fields_register = [
        'name',
        'nickname',
        'age', 
        'email', 
        'password'
    ];
    private array $fields_login = [
        'email', 
        'password'
    ];

    private $good_data;

    /** 
     * the main functions for this class 
     */

    public function show()
    {
        if (User::checkAuth()) {
            $this->renderer->display('UserCabinet');
        } else {
            $this->renderer->display('RegisterForm');
        }
    }

    public function login()
    {
        $data_user = $this->request->request->all();

        Validate::setData($data_user);

        // required fields must be in the form
        Validate::setFields($this->fields_login);

        if (Validate::check()) {
            $this->good_data = Validate::getData();
            if ($this->checkUser()) {
                redirect(base_url() . 'user');
            } else {
                $_SESSION['errors'] = 'Wrong password or there is no such user';
            };
        }

        $_SESSION['form_data'] = $data_user;
        $this->renderer->display('RegisterForm');
    }

    public function singup()
    {
        $data_user = $this->request->request->all();

        Validate::setData($data_user);
        
        // required fields must be in the form
        Validate::setFields($this->fields_register);
        if (Validate::check()) {
            $this->good_data = Validate::getData();
            $this->good_data['password'] = password_hash($this->good_data['password'], PASSWORD_DEFAULT);
            if ($this->checkUnique()) {
                $id_new_user = $this->addNewUser();
                if ($id_new_user) {
                    $_SESSION['user']['id'] = $id_new_user;
                    foreach ($this->good_data as $key => $val) {
                        if ($key == 'password') {
                            continue;
                        }
                        $_SESSION['user'][$key] = $val;
                    }
                    redirect(base_url() . 'user');
                } else {
                    $_SESSION['errors'] = 'Unexpected error, try later';
                    $this->renderer->display('RegisterForm');
                    die;
                }
            } else {
                $_SESSION['errors'] = 'The user with this email is already registered';
                $this->renderer->display('RegisterForm');
                die;
            }
            
            
        }

        $_SESSION['form_data'] = $data_user;
        $this->renderer->display('RegisterForm');
    }

    public function logout()
    {
        if (User::checkAuth()) {
            unset($_SESSION['user']);
            redirect (base_url() . 'user');
        }
    }

    /** 
     * the auxiliary functions for this class
     */
    
    private function addNewUser() 
    {
        $sth = $this->db->prepare("INSERT INTO users(nickname, name, age, email, password) 
                            VALUES(:nickname, :name, :age, :email, :password)
                            ");
        $sth->execute($this->good_data);
        $id_user = $this->db->lastInsertId();
        return is_numeric($id_user) ? $id_user : false;
    }

    private function checkUser()
    {
        $sth = $this->db->prepare("SELECT id, nickname, email, password FROM users
                                    WHERE email = ?
                                    ");
        $sth->execute([$this->good_data['email']]);
        $user = $sth->fetch();
        // debug($this->good_data['password']);
        // debug($user, 1);
        if (!empty($user)) {
            if (password_verify($this->good_data['password'], $user['password'])) {
                foreach ($user as $key => $val) {
                    if ($key == 'password') {
                        continue;
                    }
                    $_SESSION['user'][$key] = $val;
                }
                return true;
            }
        }

        return false;
    }

    private function checkUnique()
    {
        $sth = $this->db->prepare("SELECT id, email FROM users
                                    WHERE email = ?
                                    ");
        $sth->execute([$this->good_data['email']]);
        $user = $sth->fetchAll();
        return empty($user);
    }

    private static function checkAuth()
    {
        return isset($_SESSION['user']);
    }
}
