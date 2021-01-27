<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Libraries\Mask;

use Core\Logs as Logs;
use Core\Caches as Caches;

class MaskClass {

    private $log;
    private $cache;

    public function __construct() {

        $this->log = new Logs\Log;
        $this->cache = new Caches\Cache();

    }

    public function string($mask,$str){

        $str = preg_replace('/[^0-9]/', '',$str);

        for($i=0;$i<strlen($str);$i++){
            $mask[strpos($mask,"#")] = $str[$i];
        }
    
        return $mask;
    
    }

}