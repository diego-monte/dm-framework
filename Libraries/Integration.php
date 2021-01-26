<?php
namespace Libraries\Integration;

require_once("Libraries/FtpClient.php");
require_once("Libraries/Telegram.php");
require_once("Libraries/BBcode.php");


use Libraries\FtpClient as FtpClient;
use Libraries\Telegram as Telegram;
use Libraries\BBcode as BBcode;

class LibrariesClass {

    public $FtpClient;
    public $Telegram;
    public $BBcode;

    public function __construct() {

    }
    public function loadLibrarie() {

        $this->FtpClient = new FtpClient\FtpClass;
        $this->Telegram = new Telegram\TelegramClass;
        $this->BBcode = new BBcode\BBcodeClass;

    }
}


