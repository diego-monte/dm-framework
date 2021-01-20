<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
 namespace Core\Views;
 use Core\Alerts as Alerts;
 use Core\Logs as Logs;

class ViewsClass extends Alerts\Actions {

    public $controller;
    public $set_template;
    private $log;

    public function __construct() {
        $this->log = new Logs\Log;
    }
    // VIEW LOAD FUNCTION
    public function load_view($route, $uris) {
        try {
            $route_no_extencion = str_replace(".php","", $route);
            // Load files inside Assets example css and js
            $assets = $this->load_assets($route_no_extencion); 
            // File path views
            $file_view = "." . DIRECTORY_SEPARATOR . PATH_VIEW . DIRECTORY_SEPARATOR . ucfirst($route_no_extencion) . ".php"; 
            // Check if the view file exists
            if(file_exists($file_view)) { 
                // Includes the file
                require_once($file_view); 
                // Check if the class exists in the view file
                if (class_exists($route_no_extencion)) { 
                    // Instance to class
                    new $route_no_extencion($uris);
                } else {
                    throw new \InvalidArgumentException($file_view . " " . MSG_ERROR_500);
                }
            } else if(file_exists($assets['path'])) {  
                // Blocking directory reading
                if(!is_dir($assets['path'])) {
                    // Validating the reading of the file
                    if(is_readable($assets['path'])) {
                        // Arrow in the header the file type
                        header("Content-type: " . $assets["header"] . "; charset: UTF-8");
                        // Includes the file 
                        require_once(strip_tags($assets["path"])); 
                    }
                } else {
                    // If the file entered in the url is not found it will display an error
                    die($this->errorBild(404, $route_no_extencion . " FILE NOT FOUND"));
                }
            } else {
                // If the file entered in the url is not found it will display an error
                die($this->errorBild(404, $route_no_extencion . " FILE NOT FOUND"));
            }
        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )); 
        }
    }
    // LOAD FUNCTION TO CONTROLLER
    public function load_controller($file) {
        try {
            // Path of controller files
            $file_controller = "." . DIRECTORY_SEPARATOR . PATH_CONTROLLER . DIRECTORY_SEPARATOR . ucfirst($file) . ".php";  
            // Check if the controller file exists
            if(file_exists($file_controller)) { 
                // Check if the class exists in the controller file
                require_once($file_controller); 
                // Check if the class exists in the view file
                if (class_exists($file)) { 
                    // Instance to class
                    $this->controller = new $file(); 
                } else {;
                    throw new \InvalidArgumentException($file . " " . MSG_ERROR_500);
                }
            } else {
                // If the file entered in the url is not found it will display an error
                die($this->errorBild(404, $route_no_extencion . " FILE NOT FOUND"));
            }
        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )); 
        }

    }
    // FUNCTION LOAD TEMPLATE FILES
    public function load_html($file) {
        // Path of controller files
        $file_html = "." . DIRECTORY_SEPARATOR . PATH_TEMPLATE  . DIRECTORY_SEPARATOR . TEMPLATE . DIRECTORY_SEPARATOR . ucfirst($file) . ".html";
        // Check if the template's html file exists
        if(file_exists($file_html)) {
            return file_get_contents($file_html);
        } else {
            // If the file entered in the url is not found it will display an error
            die($this->errorBild(404, $route_no_extencion . " FILE NOT FOUND"));
        }
    }
    // INSTANCE PHP FUNCTION IN HTML
    public function setDATA_HTML($tag, $value, $html) {
        try {
            // Tag validation
            if(!preg_match('/^\{\{([a-zA-Z0-9-_]+)\}\}$/', $tag)) { 
                throw new \InvalidArgumentException($tag . " " . MSG_ERROR_TAG);
            }
            return str_replace($tag, $value, $html);

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )); 
        }
    }
    // TAKE THE REQUEST FOR POST
    public function POST() {

        $metodo = $_POST;

        if(isset($metodo)) {

            $arr = array();

            foreach($metodo as $key => $value) {
                $arr[$key] = htmlentities($value);
            }
            return $arr;
        }
    }
    // TAKE THE REQUEST FOR GET
    public function GET() {

        $metodo = $_GET;

        if(isset($metodo)) {

            $arr = array();

            foreach($metodo as $key => $value) {
                $arr[$key] = htmlentities($value);
            }
            return $arr;
        }
    }
    // FUNCTION LOADS ASSETS FROM TEMPLATE
    public function load_assets($route) {

        $fileArray = explode(".", $route);
        $extension = array_pop($fileArray);
        $file_bootstrap = array();

        if($extension == "css") {
            $file_bootstrap['header'] = "text/css";
        } else if($extension == "js") {
            $file_bootstrap['header'] = "text/js";
        } else if($extension == "woff") {
            header("Content-type: application/x-font-woff; charset: UTF-8");
            file($route);
            exit;
        } else if($extension == "ttf") {
            header("Content-type: application/x-font-ttf; charset: UTF-8");
            file($route);
            exit;
        } else if($extension == "woff2") {
            header("Content-type: application/x-font-woff2; charset: UTF-8");
            file($route);
            exit;
        }
        // Path of the bootstrap files
        $file_bootstrap['path'] = "." . DIRECTORY_SEPARATOR . PATH_TEMPLATE . DIRECTORY_SEPARATOR . TEMPLATE . DIRECTORY_SEPARATOR . PATH_ASSETS . DIRECTORY_SEPARATOR . $route;

        return $file_bootstrap;
    }

}