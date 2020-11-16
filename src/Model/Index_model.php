<?php

class Index_model extends ModelsClass {

    public function __construct() {
        parent::__construct();
    }

    public function setIndex($obj) {

        $this->set(array(
            "ct_name" => $obj['name'],
            "ct_email" => $obj['email'],
            "ct_subject" => $obj['subject'],
            "ct_message" => $obj['message'],
            "ct_timestamp" => "now()"
        ));
        $this->from("contacts");

        if($this->insert()) {
            return "Inserido com sucesso.";
        } else {
            return "Erro ao inserir no banco";
        } 
    }

}