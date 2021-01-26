<?php 
use Core\Views as Views;
use Core\Caches as Caches;

class Index extends Views\ViewsClass {

    private $cache;

    public function __construct($metodos) {

        $this->load_controller("Index_controller");
        $this->setIndex();
        $this->htmlRender();

    }

    private function setIndex() {

        $post = $this->POST();

        if($post != null) {
            print $this->controller->setIndex($post);
            exit;
        }
    }

    private function getIndex() {

        $this->cache = new Caches\Cache();
        $cache = $this->cache->read('cache_getIndex');

        $ret = $this->controller->getIndex();

        if (!$cache) {
            $cache = $ret;
            $this->cache->save('cache_getIndex', $cache, '30 seconds');
        }

        return $cache;

    }

    private function htmlRender() {

        $this->cache = new Caches\Cache();
        $cache = $this->cache->read('cache_view_index');

        //$getIndex = $this->getIndex();

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