<?php 

use Core\Views as Views;

class Index extends Views\ViewsClass {

    public function __construct($metodos) {

        $this->load_controller("Index_controller");
        $post = $this->POST();

        if($post != null) {
            echo $this->controller->setIndex($post);
            exit;
        }

        $render = $this->load_html("Index");
        $render = $this->setDATA_HTML("{{TITLE}}", 'DM Framework - Sua plataforma com facilidade', $render); 
        $render = $this->setDATA_HTML("{{SITE_NAME}}", 'DM Framework', $render);
        $render = $this->setDATA_HTML("{{PATH_IMAGES}}", PATH_TEMPLATE . "/" . TEMPLATE . "/" . PATH_ASSETS, $render);

        print $render;
    }
 
}