<?php

declare(strict_types = 1);

namespace App;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Template\Renderer;
use PDO;

abstract class App
{
    protected $request;
    protected $response;
    protected $renderer;
    protected $db;

    public function __construct(
        Request $request, 
        Response $response,
        Renderer $renderer,
        PDO $db
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
        $this->db = $db;
        session_start();
    }
}
