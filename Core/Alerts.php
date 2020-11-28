<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Core\Alerts;

class Actions {

    public function __construct() {}
    // Responsible function in assembling an error build.
    public function errorBild($type, $msg=null) {

        if($type == 404) {

            return file_get_contents("./src/Errors/404.html");

        } else if($type == 500) {

          return file_get_contents("./src/Errors/500.html");

        } else {
          return false;
        }
    }
}