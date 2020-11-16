<?php
// Disable errors
//error_reporting(0);
// Including classes
require_once("vendor/autoload.php");
require_once("Core/Logs.php");
require_once("Config/Constants.php");
require_once("Core/Alerts.php");
require_once("Core/Views.php");
require_once("Core/Controllers.php");
require_once("Core/Models.php");
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.1.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
use Core\Views as Views;

class Main {

    private $data;
    private $route;

    public function __construct() {
        // Taking requests
        $uris = htmlentities($_GET['url']);
        // Calling the views class
        $this->route = new Views\ViewsClass;
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


