<?php 

class MainList{
    
    protected $_name;
    protected $_model;
    protected $_userId;
    
    public function __construct($userId, $name){
        $this->_name = $name;
        $this->_userId = $userId;
    }
    
    public function addToList($foreignKey, $toFirst = false){
        $ordered = new Ordered(); 
        $ordered->add($this->_model->alias, $this->_name, $foreignKey, $this->_userId, $toFirst);
    }
}
