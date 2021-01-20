<?php 
use Core\Views as Views;
use Core\Caches as Caches;

class Index extends Views\ViewsClass {

    private $cache;

    public function __construct($metodos) {

        $this->cache = new Caches\Cache();

        $cache = $this->cache->read('cache_view_index');

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

        if (!$cache) {
            $cache = $render;
            $this->cache->save('cache_view_index', $cache, '30 seconds');
        }

        print $cache;
    }
 
}