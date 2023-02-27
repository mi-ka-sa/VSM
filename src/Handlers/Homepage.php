<?php 

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Homepage extends App
{

    public function show()
    {
        $stmt = $this->db->query("SELECT t.id, t.name, t.name_alt, t.img, t.type, t.new, t.slug, GROUP_CONCAT(g.name SEPARATOR ' / ') AS 'genre' FROM titles_genres tg
                                    JOIN titles t
                                    ON t.id = tg.id_title
                                    JOIN genres g
                                    ON tg.id_genre = g.id
                                    WHERE t.display = 1
                                    GROUP BY tg.id_title
                                    ORDER BY t.id DESC");
                                
                                // SELECT t.name, tf.type FROM titles t, titles_film tf
                                //     WHERE t.id = tf.title_id
                                //     UNION
                                //     SELECT t.name, tt.type FROM titles t, titles_text tt
                                //     WHERE t.id = tt.title_id

                                // "SELECT t.*, GROUP_CONCAT(g.name SEPARATOR ' / ') AS 'genre' FROM titles t
                                    // JOIN titles_genres tg
                                    // ON t.id = tg.id_title
                                    // JOIN genres g 
                                    // ON g.id = tg.id_genre
                                    // GROUP BY tg.id_title
                                    // ORDER BY t.id DESC

        // foreach($stmt as $row){
        //     debug($row);
        // }
        // exit;
  
        $data['db_data'] = $stmt->fetchAll();
        // debug($data['db_data']);
        // exit;




        $data['name'] = $this->request->get('name', 'stranger');

        // debug($data);
        // exit;
        $this->renderer->display('Homepage', $data);
        
    }
}