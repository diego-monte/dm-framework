<?php
namespace Libraries\Integration;

require_once("Libraries/FtpClient.php");

use Libraries\FtpClient as FtpClient;

class LibrariesClass {

    public $FtpClient;
    public $Upload;

    public function __construct() {

    }
    public function loadLibrarie() {

        $this->FtpClient = new FtpClient\FtpClass;

    }
}


