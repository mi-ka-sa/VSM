<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Anime extends App
{
    public function show($param)
    {
        extract($param);
        if ($slug == 'catalog')
        {
            $this->catalogShow();
        } else {
            $sth = $this->db->prepare("SELECT t.*, tv.*, g.name AS genre FROM titles t
                                    JOIN titles_add_video tv
                                    ON t.id = tv.title_id
                                    JOIN titles_genres tg
                                    ON t.id = tg.id_title
                                    JOIN genres g
                                    ON g.id = tg.id_genre
                                    WHERE t.slug = :slug AND t.display = 1");
            $sth->execute(['slug' => $slug]);
            $res = $sth->fetchAll();

            if (empty($res)) {
                debug('Page not found', 1);
            }

            foreach ($res as $item) {
                $genres[] = $item['genre'];
            }
            $data['item'] = array_shift($res);
            $data['item']['genre'] = $genres;

            $this->renderer->display('Anime', $data);
        }
    
    }

    public function catalogShow ()
    {
        $sth = $this->db->query("SELECT t.id, t.name, t.name_alt, t.img, t.type AS 'type', t.new, t.slug,
                                        tv.type AS type_type, tv.episodes, tv.duration, 
                                        GROUP_CONCAT(g.name SEPARATOR ' / ') AS genre 
                                    FROM titles t
                                    JOIN titles_add_video tv
                                    ON t.id = tv.title_id
                                    JOIN titles_genres tg
                                    ON t.id = tg.id_title
                                    JOIN genres g
                                    ON g.id = tg.id_genre
                                    WHERE t.display = 1
                                    GROUP BY tg.id_title");
        $res = $sth->fetchAll();
        // debug($res, 1);

        if (empty($res)) {
            debug('No items', 1);
        }

        $data['db_data'] = $res;

        $this->renderer->display('AnimeCatalog', $data);
    }
}
