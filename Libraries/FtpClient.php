<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Libraries\FtpClient;

use Core\Logs as Logs;

class FtpClass {

    protected $ftpId;
    private $log;

    public function __construct() {
        $this->log = new Logs\Log;
    }

    public function connect($host, $port) {
        try {
            $this->ftpId = ftp_connect($host, (int) $port);

            if ($this->ftpId === false) {

                throw new \InvalidArgumentException("Ftp connection error");
                
            } else {

                return true;

            }
        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }
    }

    public function login($username, $password) {
        try {

            if(ftp_login($this->ftpId, $username, $password)) {

                return true;

            } else {

                throw new \InvalidArgumentException("Unable to connect with user ftp $username");
                
            }

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }

    }

    public function isConn() {

		if (is_resource($this->ftpId)) {

            return true;
            
		} else {

            return false;

        }
    }
    
    public function changeDir($path) {
        try {

            if (!$this->isConn()) {

                return false;
                
            } else {

                if (ftp_chdir($this->ftpId, $path)) {

                    return ftp_pwd($this->ftpId);

                } else {

                    throw new \InvalidArgumentException("Could not change directory");
                    
                }

            }	
        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }
    }
    
    public function mkdir($path) {
        try {
            if (!$this->isConn()) {
                return false;
            }

            if (ftp_mkdir($this->ftpId, $path)) {

                return true;
                
            } else {

                throw new \InvalidArgumentException("There was a problem creating the directory $path");

            }
        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }
        
    }
    
    public function listFiles($path = '.') {

        if (!$this->isConn()) {
            return false;
        }

        return ftp_nlist($this->ftpId, $path);
        
    }
    
    public function upload($destinoPath, $origemPath) {

        if (!$this->isConn()) {
			return false;
		}

        $file = fopen($origemPath, 'r');

        if (ftp_fput($this->ftpId, $destinoPath . basename($origemPath), $file, FTP_ASCII)) {
            return true;
        } else {
            echo "There was a problem while uploading $origemPath\n";
        }

        ftp_close($this->ftpId);
        fclose($fp);
    }
    
    public function download($localFile, $serverFile) {
        try{

            if (!$this->isConn()) {
                return false;
            }

            if (ftp_get($this->ftpId, $localFile, $serverFile, FTP_ASCII)) {

                return true;

            } else {

                throw new \InvalidArgumentException("Problem when downloading via FTP");

            }

            ftp_close($this->ftpId);

        } catch (\Exception $e) {
                $this->log->write(array(
                    "MSG"=> $e->getMessage(), 
                    "CLASS" => __CLASS__
                ));
                return false;
        }
    }
    
    public function rename($oldFile, $newFile) {
        try {
            if (!$this->isConn()) {
                return false;
            }

            if (ftp_rename($this->ftpId, $oldFile, $newFile)) {

                return true;
                
            } else {

                throw new \InvalidArgumentException("There was a problem while renaming $oldFile to $newFile");

            }

            ftp_close($this->ftpId);

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }
    }
    
	public function delete($file) {
        try {
            if (!$this->isConn()) {
                return false;
            }

            if (ftp_delete($this->ftpId, $file)) {

                    throw new \InvalidArgumentException("Unable to delete the file $file");
            }

            ftp_close($this->ftpId);

        } catch (\Exception $e) {
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            return false;
        }
	}

}