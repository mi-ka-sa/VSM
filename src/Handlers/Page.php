<?php

declare(strict_types = 1);

namespace App\Handlers;

use App\App;

use Symfony\Component\HttpFoundation\Response;
use App\Template\Renderer;
use App\Page\PageReader;
use App\Page\InvalidPageException;

class Page
{
    private $request;
    private $response;
    private $renderer;
    private $pageReader;

    public function __construct(
        Response $response,
        Renderer $renderer,
        PageReader $pageReader
    )
    {
        $this->response = $response;
        $this->renderer = $renderer;
        $this->pageReader = $pageReader;
    }

    public function show($params)
    {
        $slug = $params['slug'];
        // debug($slug, true);
        try {
            $data['content'] = $this->pageReader->readBySlug($slug);
        } catch (InvalidPageException $e) {
            $this->response->setStatusCode(404);
            return $this->response->setContent('404 - Page not found');
        }
        
        $html = $this->renderer->display('Page', $data);
        $this->response->setContent($html);
    }
}
