<?php 

declare(strict_types = 1);

namespace App\Template;

interface Renderer
{
    public function display($template, $data = []);
}