<?php
namespace Libraries\Integration;

$path = dir("./Libraries");

while($libraries = $path -> read()){

    if($libraries != "." && $libraries != ".." && $libraries != "Integration.php") { 
        require_once("Libraries/$libraries");
    }
    
}

use Libraries\FtpClient as FtpClient;
use Libraries\Telegram as Telegram;
use Libraries\BBcode as BBcode;
use Libraries\QRcode as QRcode;
use Libraries\Mask as Mask;

class LibrariesClass {

    public $FtpClient;
    public $Telegram;
    public $BBcode;
    public $QRcode;
    public $Mask;

    public function __construct() {

    }
    
    public function loadLibrarie() {

        $this->FtpClient = new FtpClient\FtpClass;
        $this->Telegram = new Telegram\TelegramClass;
        $this->BBcode = new BBcode\BBcodeClass;
        $this->QRcode = new QRcode\QRcodeClass;
        $this->Mask = new Mask\MaskClass;

    }
}


