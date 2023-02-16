<?php 

declare(strict_types = 1);

namespace App\Handlers;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Template\Renderer;


class Homepage
{
    private $request;
    private $response;
    private $renderer;

    public function __construct(
        Request $request, 
        Response $response,
        Renderer $renderer
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }

    public function show()
    {

        $data = [
            'name' => $this->request->get('name', 'stranger'),
        ];

        $this->renderer->display('Homepage.tpl', $data);
        
    }
}