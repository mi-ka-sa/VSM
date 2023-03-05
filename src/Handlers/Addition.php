<?php

declare(strict_types = 1);

namespace App\Handlers;

trait Addition
{
    public function addScore()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['errors'] = 'Only a registered user can rate';
            exit;
        }

        $id_titles = $this->request->request->get('id');
        $score = $this->request->request->get('value');

        $sth = $this->db->prepare("REPLACE INTO titles_score(id_titles, id_users, score)
                            VALUES (?,?,?)");
        if ($sth->execute([$id_titles, $_SESSION['user']['id'], $score])) {
            $_SESSION['success'] = 'NEW score';
        };
    }

    public function deleteScore()
    {
        $id_titles = $this->request->request->get('id');

        $sth = $this->db->prepare("DELETE FROM titles_score
                                WHERE id_titles = ? AND id_users = ?");
        echo $sth->execute([$id_titles, $_SESSION['user']['id']]);
    }

    private function getTitle($slug_title, $name_table_add, ...$columns)
    {
        $add_sql = '';
        $user_sql = '';

        if (isset($_SESSION['user'])) {
            $add_sql = "ts.score AS user_score, ";
            $user_sql = "LEFT JOIN titles_score ts ON ts.id_users = {$_SESSION['user']['id']} AND ts.id_titles = t.id";
        }

        foreach ($columns as $column) {
            $add_sql .= $name_table_add . "." . $column . ", ";
        }

        $sth = $this->db->prepare("SELECT t.id, t.type AS global_type, t.name, t.name_alt, t.date_start, t.date_end, t.synopsis, t.img, t.new,
                            $add_sql
                            GROUP_CONCAT(g.name SEPARATOR '|') AS genre
                            FROM titles t
                            JOIN {$name_table_add}
                            ON t.id = {$name_table_add}.title_id
                            JOIN titles_genres tg
                            ON t.id = tg.id_title
                            JOIN genres g
                            ON g.id = tg.id_genre
                            {$user_sql}
                            WHERE t.slug = :slug AND t.display = 1
                            GROUP BY tg.id_title");
        $sth->execute(['slug' => $slug_title]);
        
        $item = $sth->fetch();

        if (empty($item)) {
            debug('No data in DB', 1);
        }

        $item['genre'] = explode('|', $item['genre']);

        return $item;
    }

    private function getAllTitles($name_table_add, ...$columns)
    {
        $add_sql = '';

        foreach ($columns as $column) {
            $add_sql .= $name_table_add . "." . $column . ", ";
        }

        $sth = $this->db->query("SELECT t.id, t.name, t.name_alt, t.img, t.type AS 'global_type', t.new, t.slug,
                                    $add_sql
                                    GROUP_CONCAT(g.name SEPARATOR ' / ') AS genre 
                                    FROM titles t
                                    JOIN {$name_table_add}
                                    ON t.id = {$name_table_add}.title_id
                                    JOIN titles_genres tg
                                    ON t.id = tg.id_title
                                    JOIN genres g
                                    ON g.id = tg.id_genre
                                    WHERE t.display = 1
                                    GROUP BY tg.id_title");
        $items = $sth->fetchAll();

        if (empty($items)) {
            debug('No items', 1);
        }

        return $items;
    }

    private function getScore($id)
    {
        $sth = $this->db->prepare("SELECT ROUND(AVG(ts.score), 2) AS score FROM titles_score ts
                                    WHERE ts.id_titles = :id");
        $sth->execute(['id' => $id]);
        $data = $sth->fetch();
        return $data['score'];
    }
}