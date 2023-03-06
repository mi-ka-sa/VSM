<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Wishlist extends App
{
    private $actions = [
        'add' => 'add',
        'mark-as-done' => 'done',
        'delete' => 'delete',
    ];

    public function main($param)
    {   
        extract($param);

        if (array_key_exists($action, $this->actions) && isset($_SESSION['user'])) {
            $id = $this->request->request->get('id');
            $funcname = $this->actions[$action];
            $this->$funcname($id);
        } else {
            $_SESSION['errors'] = "Not found page";
        }
    }

    private function add($id)
    {
        $sth = $this->db->prepare("INSERT INTO users_wishlist(id_titles, id_users, status)
                            VALUES (?,?, 'wish')");
        if ($sth->execute([$id, $_SESSION['user']['id']])) {
            $_SESSION['success'] = 'Title has been added to My Wishlist';
        };
    }

    private function done($id)
    {
        $sth = $this->db->prepare("UPDATE users_wishlist SET status = 'done'
                                WHERE id_titles = ? AND id_users = ?");
        if ($sth->execute([$id, $_SESSION['user']['id']])) {
            $_SESSION['success'] = 'Title has been marked as viewed/read';
        };
    }

    private function delete($id)
    {
        $sth = $this->db->prepare("DELETE FROM users_wishlist
                                WHERE id_titles = ? AND id_users = ?");
        $sth->execute([$id, $_SESSION['user']['id']]);
    }
}