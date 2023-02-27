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

    /** 
     * the main functions for this class 
     */

    public function display($template, $data = [])
    {
        $this->engine->assign('template', $template . '.html');
        $this->engine->assign('data', $data);

        $this->setUserFunction();

        return $this->engine->display('BaseTemplate.html');
    }

    /** 
     * the auxiliary functions for this class
     */

    public function setUserFunction()
    {
        $this->engine->registerPlugin("function", "user_session_succes_out", array($this, "sessionSuccesOut"));
        $this->engine->registerPlugin("function", "user_session_errors_out", array($this, "sessionErrorsOut"));
        $this->engine->registerPlugin("function", "user_first_last_item_in_row", array($this, "firstLastItemInRow"));
        $this->engine->registerPlugin("function", "user_get_field_value", array($this, "getFieldValue"));
        $this->engine->registerPlugin("function", "user_delete_form_data", array($this, "deleteFormData"));
    }
    
    public function sessionSuccesOut()
    {
        $tmp = $_SESSION['success'];
        unset($_SESSION['success']);
        return $tmp;
    }

    public function sessionErrorsOut()
    {
        $tmp = $_SESSION['errors'];
        unset($_SESSION['errors']);
        return $tmp;
    }

    public function firstLastItemInRow($params)
    {
        extract($params);
        if ($iteration === 1 || $iteration%5 == 0) {
            return 'first ';
        } elseif ($iteration%4  == 0) {
            return 'last ';
        }
    
        return '';
    }

    public function getFieldValue($params)
    {
        extract($params);
        return isset($_SESSION['form_data'][$key]) ? 
            h($_SESSION['form_data'][$key]) :
            '';
    }

    public function deleteFormData()
    {
        if(isset($_SESSION['form_data'])) {
            unset($_SESSION['form_data']);
        } 
    }

}
