<?php
// Disable errors
error_reporting(0);
// Including classes
require_once("vendor/autoload.php");
require_once("config/constants.php");
require_once("core/class_alerts.php");
require_once("core/class_views.php");
require_once("core/class_controllers.php");
require_once("core/class_models.php");
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.0.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
class Main {

    private $data;
    private $route;

    public function __construct() {
        // Taking requests
        $uris = htmlentities($_GET['url']);
        // Calling the views class
        $this->route = new Views();
        // If the route is not found, the index will be informed as the default
        if($uris != "") {
            // Uris for array
            $array_uris = explode("/", $uris);
            // Informing the route to the views
            echo $this->route->load_view($uris, $array_uris);
        } else {
            // Informing the index as default
            header("location: " . "/" . DEPLOY . "/" . PAGE_DEFAULT);
        }
    } 
}

new Main();


