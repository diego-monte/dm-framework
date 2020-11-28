<?php

use Core\Controllers as Controllers;

class Index_controller extends Controllers\ControllersClass {

    public function __construct() {
        parent::__construct();
        $this->load_model("Index_model");
        //$this->sendEmail();
    }

    public function setIndex($obj) { 
        // chama a validacao de dados
        $retError = $this->valida($obj);

        if($retError != "") {
            return $retError;
        }
        return $this->model->setIndex($obj);
    }

    // funcao valida dados
    private function valida($obj) {

        $ret = array();
        $html = "";

        if(!isset($obj['name']) || trim($obj['name']) == '') {
            $status = 1;
            $ret[] = "Empty or invalid name field.";
        }
        if(!isset($obj['email']) || trim($obj['email']) == '') {
            $ret[] = "Empty or invalid email field.";
        }
        if(!isset($obj['subject']) || trim($obj['subject']) == '') {
            $ret[] = "Empty or invalid subject field.";
        }
        if(!isset($obj['message']) || trim($obj['message']) == '') {
            $ret[] = "Empty or invalid message field.";
        }

        foreach($ret as $item) {
            $html .= "<p>" . $item . "</p>\n";
        }
        return $html;
    }

}