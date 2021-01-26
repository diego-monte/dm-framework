<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Libraries\QRcode;

use Core\Logs as Logs;
use Core\Caches as Caches;

class QRcodeClass {

    private $log;
    private $cache;

    public function __construct() {

        $this->log = new Logs\Log;
        $this->cache = new Caches\Cache();

    }

    public function render($string, $width, $height) {

        $cache = $this->cache->read('cache_QRcode');

        if(!isset($string)) die("Error QRcode string converter.");
        if(!is_numeric($width)) die("An unexpected error occurred in the width of the QRcode.");
        if(!is_numeric($height)) die("An unexpected error occurred in the height of the QRcode.");

        $source = file_get_contents("https://chart.googleapis.com/chart?chs=" . $width . "x" . $height . "&cht=qr&chl=" . $string);
        $imgBase64 = "data:image/png;base64," . base64_encode($source);
        $tag = '<img src="'.$imgBase64.'" width="'.$width.'" height="'.$height.'" title="QRcode" alt="QRcode" />';

        if (!$cache) {
            $cache = $tag;
            $this->cache->save('cache_QRcode', $cache, '30 seconds');
        }

        return $cache;

    }

    public function save($string, $width, $height, $path, $fileName) {

        if(!isset($string)) die("Error QRcode string converter.");
        if(!is_numeric($width)) die("An unexpected error occurred in the width of the QRcode.");
        if(!is_numeric($height)) die("An unexpected error occurred in the height of the QRcode.");
        if(!is_dir($path)) die("Directory not found.");
        if(!isset($fileName)) die("QRcode name is missing.");

        $source = file_get_contents("https://chart.googleapis.com/chart?chs=" . $width . "x" . $height . "&cht=qr&chl=" . $string);
        
        if(isset($source)) {
            file_put_contents($path . "/" . $fileName . ".png", $source);
        } else {
            return false;
        }
        
    }

    

}