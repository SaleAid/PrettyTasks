<?php

class ListObj {
    public $type = null;
    public $name = null;
    public $list = array();
    
    public $_explicitType="TasksList";

    public function __construct(array $list) {
    }
} 