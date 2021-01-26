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

    public function getIndex() {
        $this->select("ct_id as id, ct_name as name, ct_email as email, ct_subject as subject, ct_message as message, ct_timestamp as date");
        $this->from("contacts");
        $this->get();
        return $this->result();
    }

}