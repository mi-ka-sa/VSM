<?php 

declare(strict_types = 1);

namespace App\Template;

use Smarty;

class AppSmartyRenderer implements Renderer
{
    private $engine;

    public function __construct(Smarty $engine)
    {
        $this->engine = $engine;

        $this->engine->setTemplateDir(TMP . '/templates/');
        $this->engine->setCompileDir(TMP . '/templates_c/');
        $this->engine->setConfigDir(TMP . '/configs/');
        $this->engine->setCacheDir(TMP . '/cache/');
    }

    public function display($template, $data = [])
    {
        $this->engine->assign('name', $data['name']);
        return $this->engine->display($template);
    }
}