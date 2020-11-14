<?php
/**
 * DM-FRAMEWORK 2020-2020
 * Version: 1.0.0.0
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
class Controllers extends Alerts {

    public $model;
    private $log;

    public function __construct() {
        $this->log = new Log;
    }
    // Function loads the model
    public function load_model($file) {
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
                $this->log->write(array("MSG"=> $file_model . " " . MSG_ERROR_500, "CLASS" => __CLASS__));
                // Displays an error if the class is poorly structured
                die($this->errorBild(500, $file_model . "<br><br>" . MSG_ERROR_TAG)); 
            }
        } else {
            $this->log->write(array("MSG"=> $file_model . " " . MSG_ERROR_404));
            // If the file entered in the url is not found it will display an error
            die($this->errorBild(404, $file_model . "<br><br>" . MSG_ERROR_404)); 
        }   
    }
} 