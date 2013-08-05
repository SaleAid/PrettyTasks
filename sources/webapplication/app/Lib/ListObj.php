<?php

class ListObj {
    /*
    type: DateList
     name: 2013-07-21
    
    type: TagList
    name: TagName
    
    type: defined
    name: expired
    
    */
    public $type = null;
    public $name = null;
    public $list = array();
    
    public $_explicitType = null;

    public function __construct($type, $name, array $list) {
        $this->list = $list;
        $this->type = $type;
        $this->name = $name;
    }
} 