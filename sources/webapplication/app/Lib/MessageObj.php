<?php

class MessageObj {
    public $type = null;
    public $message = null;
    public $code = 0;
    public $errors = array();
    public $_explicitType = "Message";

    public function __construct($type, $message, $errors = array()) {
        $this->type = $type;
        $this->message = $message;
        $this->errors = $errors;
    }
} 