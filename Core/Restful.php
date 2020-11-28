<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Core\Restful;
use Core\Logs as Logs;
use \Firebase\JWT\JWT;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RestFulClass {

    private $log;

    public function __construct() {
        $this->log = new Logs\Log;
    }
    // JWT ENCRYPTION FUNCTION
    public function jwt_encode($data) {
        try {
            $this->acceptJson();

            $jwt = array();
            $time = time();

            $obj = array(
                "data" => $data,
                "iat" => $time,
                "exp" => $time + 604800
            );

            $jwt['Bearer'] = JWT::encode($obj, KEY_JWT);

            $this->httpStatus(202);
            header('Content-Type: application/json');
            return json_encode($jwt);
            
        } catch (\Exception $e) {

            $this->httpStatus(203);
            $this->log->write($e->getMessage());

            die(json_encode(array(
                "TYPE" => HTTP_STATUS_203,
                "MESSAGE" => $e->getMessage()
            )));
        }
    }
    // JWT DESCRIPTOGRAPHY FUNCTION
    public function jwt_decode() {
        try {
            $this->acceptJson();

            $header = apache_request_headers();
            $header = $this->uppercaseToLowercase($header);

            if (preg_match('/Bearer/i', $header['authorization'])) {

                $jwt_token = str_ireplace("Bearer", "", $header['authorization']); 
                $jwt_token = trim($jwt_token);
                
            } else {
                throw new \InvalidArgumentException();
            }

            $jwt = JWT::decode($jwt_token, KEY_JWT, array('HS256'));

            if(empty($jwt)){
                throw new \InvalidArgumentException("Missing Bearer " . MSG_ERROR_500);
            }

            return (array)$jwt->data;

        } catch (\Exception $e) {
            $this->httpStatus(203);
            $this->log->write(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            die(json_encode(array(
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )));
        }
    }
    // FUNCTION TO LEAVE ALL TINY CHARACTERS
    private function uppercaseToLowercase($header) {
        $ret = array();
        foreach ($header as $key => $val) {
            $ret[strtolower($key)] = $val;
        }
        return $ret;
    }
    // FUNCTION INSERT HTTP CODE
    public function httpStatus($code) {

        header('Content-Type: application/json');

        if(is_numeric($code)){
            http_response_code($code);
        } else {
            http_response_code(500);
        }
    }
    // VALIDATE ACCEPT JSON FUNCTION
    public function acceptJson() {
        try {
            $requestAcceptJson = $_SERVER['HTTP_ACCEPT'];

            if (strpos($requestAcceptJson, 'application/json') === false) {

                $this->httpStatus(406);
                throw new \InvalidArgumentException(MESSAGE_ERROR_TYPE_ACCEPT);
            }

        } catch (\Exception $e) {
            $this->httpStatus(203);
            $this->log->write(array(
                "TYPE" => HTTP_STATUS_406, 
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            die(json_encode(array(
                "TYPE" => HTTP_STATUS_406, 
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )));
        }
    }
    // VALIDATE THE METHOD FUNCTION
    public function requestMethod($method) {
        try {
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            switch ($requestMethod) {
                case 'GET': $ret = true; break;
                case 'POST': $ret = true; break;
                case 'PUT': $ret = true; break;
                case 'PATCH': $ret = true; break;
                case 'DELETE': $ret = true; break;
                case 'OPTIONS': $ret = true; break;
                default: $ret = false; break;
            }

            if (strpos($requestMethod, $method) === false || $ret === false) {

                $this->httpStatus(405);
                throw new \InvalidArgumentException(MSG_ERROR_METHOD);
                
            }
        } catch (\Exception $e) {
            $this->httpStatus(203);
            $this->log->write(array(
                "TYPE" => HTTP_STATUS_405, 
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            ));
            die(json_encode(array(
                "TYPE" => HTTP_STATUS_405, 
                "MSG"=> $e->getMessage(), 
                "CLASS" => __CLASS__
            )));
        }
    }

}