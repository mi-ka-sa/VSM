<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

class Anime extends App
{
    use Addition;

    public function show($param)
    {
        extract($param);
               
        $item = $this->getTitle($slug, 'titles_add_video', 'type', 'status', 'episodes', 'duration', 'studios', 'rating');
        $item['score'] = $this->getScore($item['id']);
        $data['title'] = $item;

        $this->renderer->display('Title', $data);
    }

    public function catalogShow()
    {
        $items = $this->getAllTitles('titles_add_video', 'type', 'status', 'episodes', 'duration');
        $data['db_data'] = $items;

        $this->renderer->display('Catalog', $data);
    }
}
