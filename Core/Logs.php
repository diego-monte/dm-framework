<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Core\Logs;

class Log {
    public function write($string=null) {
        if($string != null) {
            $string['DEPLOY'] = DEPLOY;
            $string['VERSION'] = VERSION;
            $string['DATE'] = date("Y-m-d H:i:s");
            return $this->saveLog(json_encode($string));
        }
    }
    
    public function saveLog($string) {
        $fileName = "errors_" . date("Y-m-d") . ".log";
        $return = file_put_contents("./" . PATH_LOGS . "/" . $fileName, $string."\n", FILE_APPEND);
        if($return) {
            return true;
        } else {
            return false;
        }
    }
}