<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Core\Controllers;

use Core\Restful as Restful;
use Core\Logs as Logs;

class ControllersClass extends Restful\RestFulClass {

    public $model;
    private $log;

    public function __construct() {

        $this->loadLibrarie();
        
        $this->log = new Logs\Log;
    }
    // Function loads the model
    public function load_model($file) {
        try {
            // Models files path
            $file_model = "." . DIRECTORY_SEPARATOR . PATH_MODEL . DIRECTORY_SEPARATOR . ucfirst($file) . ".php";
            // Checks whether the model file exists
            if(file_exists($file_model)) {
                // Includes the model file
                require_once($file_model);
                // Checks whether the class exists in the model file
                if (class_exists($file)) {
                    // Instance to class
                    $this->model = new $file;
                } else {
                    throw new \InvalidArgumentException($file_model . " " . MSG_ERROR_500);
                }
            } else {
                throw new \InvalidArgumentException($file_model . " " . MSG_ERROR_404);
            }   

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
        }
    }
} 