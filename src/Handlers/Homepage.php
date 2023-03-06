<?php 

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Homepage extends App
{
    use Addition;

    public function show()
    {

        $stmt = $this->db->query("SELECT t.id, t.name, t.name_alt, t.img, t.type, t.new, t.slug, 
                                    GROUP_CONCAT(g.name SEPARATOR ' / ') AS 'genre' 
                                    FROM titles_genres tg
                                    JOIN titles t
                                    ON t.id = tg.id_title
                                    JOIN genres g
                                    ON tg.id_genre = g.id
                                    WHERE t.display = 1
                                    GROUP BY tg.id_title
                                    ORDER BY t.id DESC");
  
        $data['db_data'] = $stmt->fetchAll();
        $data['name'] = $this->request->get('name', 'stranger');

        $this->renderer->display('Homepage', $data);
        
    }
}