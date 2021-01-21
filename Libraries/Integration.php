<?php
namespace Libraries\Integration;

require_once("Libraries/FtpClient.php");
require_once("Libraries/Telegram.php");

use Libraries\FtpClient as FtpClient;
use Libraries\Telegram as Telegram;

class LibrariesClass {

    public $FtpClient;
    public $Telegram;

    public function __construct() {

    }
    public function loadLibrarie() {

        $this->FtpClient = new FtpClient\FtpClass;
        $this->Telegram = new Telegram\TelegramClass;

    }
}


