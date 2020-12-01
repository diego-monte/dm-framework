<?php
namespace Libraries\Integration;

require_once("Libraries/FtpClient.php");
require_once("Libraries/Upload.php");

use Libraries\FtpClient as FtpClient;
use Libraries\Upload as Upload;

class LibrariesClass {

    public $FtpClient;
    public $Upload;

    public function __construct() {

    }
    public function loadLibrarie() {

        $this->FtpClient = new FtpClient\FtpClass;
        $this->Upload = new Upload\UploadClass;

    }
}


