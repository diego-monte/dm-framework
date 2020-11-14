<?php

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
        $return = file_put_contents("./storage/logs/" . $fileName, $string."\n", FILE_APPEND);
        if($return) {
            return true;
        } else {
            return false;
        }
    }
}