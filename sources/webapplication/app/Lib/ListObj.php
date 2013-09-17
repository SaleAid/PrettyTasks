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
    public $hide = false;
    
    public $_explicitType = null;

    public function __construct($type, $name, array $list, $count = 50) {
        $this->list = $list;
        $this->type = $type;
        $this->name = $name;
        if(count($list) < $count){
            $this->hide = true;
        }
    }
} 