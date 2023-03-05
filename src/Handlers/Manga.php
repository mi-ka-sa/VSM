<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Manga extends App
{
    use Addition;
    
    public function show($param)
    {
        extract($param);

        $item = $this->getTitle($slug, 'titles_add_text', 'type', 'status', 'volumes', 'chapters', 'author_story', 'author_art');
        $item['score'] = $this->getScore($item['id']);
        $data['title'] = $item;

        $this->renderer->display('Title', $data);
    }

    public function catalogShow()
    {
        $items = $this->getAllTitles('titles_add_text', 'type',  'chapters');
        $data['db_data'] = $items;

        $this->renderer->display('Catalog', $data);
    }
}
