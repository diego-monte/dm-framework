<?php
/**
 * DM-FRAMEWORK
 * Author: Diego Monte
 * E-Mail: d.h.m@hotmail.com
 * 
 * OBS: The framework is free to change but keep the credits.
 */
namespace Libraries\Telegram;

use Core\Logs as Logs;

class TelegramClass {
    
    private $chatId;
    private $token;

    public function chatId($id) {
        if($id) {
            $this->chatId = $id;
        } else {
            die("error: missing chatId!");
        }

    }

    public function token($token) {
        if($token) {
            $this->token = $token;
        } else {
            die("error: missing token!");
        }

    }

    public function lastChatId() {

        $update_response = file_get_contents("https://api.telegram.org/bot".$this->token."/getUpdates");
        $response = json_decode($update_response, true);

        $chatId = $response["result"][0]['message']['chat']['id']; // /my_id @my_bot

        if(isset($chatId)) {
            return $chatId;
        } else {
            die('chatId not found.');
        }

    }

    public function sendMsg($msg=false) {
        
        $parameters = array(
            "chat_id" => $this->chatId,
            "text" => $msg,
            "parse_mode" => "HTML"
        );
        
        $options = array(
             'http' => array(
                 'method'  => 'POST',
                 'content' => json_encode($parameters),
                 'header'=>  "Content-Type: application/json\r\n" .
                 "Accept: application/json\r\n"
                 )
             );
        if($msg != false) {
            $context  = stream_context_create($options);
            $ret = file_get_contents("https://api.telegram.org/bot".$this->token."/sendMessage", false, $context);
            
            if($ret != NULL) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}