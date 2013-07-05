<?php 

App::uses('Ordered', 'Model');

class MainList{
    
    protected $_name;
    protected $_listId;
    protected $_model;
    protected $_userId;
    protected $_ordered;
    
    public function __construct($userId, $name){
        $this->_name = $name;
        $this->_userId = $userId;
        $this->_ordered = ClassRegistry::init('Ordered');
    }
    
    public function addToList($foreignKey, $toFirst = false){
        $this->_ordered->add($this->_model->alias, $this->_name, $this->_listId, $foreignKey, $this->_userId, $toFirst);
    }
    
    public function removeFromList($foreignKey){
        $idItem = $this->isInList($foreignKey);
        if($idItem){
            return $this->_ordered->delete($idItem);    
        }
        return false;
    }
    
    public function reOrder($foreignKey, $position){
        $idItem = $this->isInList($foreignKey);
        if($idItem){
            $this->_ordered->delete($idItem);    
            $this->insert($foreignKey, $position);
            return true;
        }
        return false;
    }
    
    /**
     * Inserts an item on a certain position
     *
     */
    public function insert($foreignKey, $position){
        $this->_ordered->insert($this->_model->alias, $this->_name, $this->_listId, $foreignKey, $this->_userId, $position);
    }
    
    /**
     * Return id if item in the list.
     *
     */
	public function isInList($foreignKey) {
	   return false;
	}
}
