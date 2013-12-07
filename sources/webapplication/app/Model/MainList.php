<?php 
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('Ordered', 'Model');
App::uses('CakeTime', 'Utility');

/**
 * TODO Description
 * 
 * @property Ordered $_ordered
 */
class MainList{
    
    /**
     * 
     * @var unknown_type
     */
    protected $_name;
    
    /**
     * 
     * @var unknown_type
     */
    protected $_listId;
    
    /**
     * 
     * @var unknown_type
     */
    protected $_model;
    
    /**
     * 
     * @var unknown_type
     */
    protected $_userId;
    
    /**
     * 
     * @var unknown_type
     */
    protected $_ordered;
    
    /**
     * 
     * @param unknown_type $userId
     * @param unknown_type $name
     */
    public function __construct($userId, $name){
        $this->_name = $name;
        $this->_userId = $userId;
        $this->_ordered = ClassRegistry::init('Ordered');
    }
    
    /**
     * 
     * @param unknown_type $foreignKey
     * @param unknown_type $toFirst
     */
    public function addToList($foreignKey, $toFirst = false){
        $this->_ordered->add($this->_model->alias, $this->_name, $this->_listId, $foreignKey, $this->_userId, $toFirst);
    }
    
    /**
     * 
     * @param unknown_type $foreignKey
     * @return boolean
     */
    public function removeFromList($foreignKey){
        $idItem = $this->isInList($foreignKey);
        if($idItem){
            return $this->_ordered->delete($idItem);    
        }
        return false;
    }
    
    /**
     * 
     * @param unknown_type $foreignKey
     * @param unknown_type $position
     * @return boolean
     */
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
     * @param unknown_type $foreignKey
     * @param unknown_type $position
     */
    public function insert($foreignKey, $position){
        $this->_ordered->insert($this->_model->alias, $this->_name, $this->_listId, $foreignKey, $this->_userId, $position);
    }
    
    /**
     * Return id if item in the list.
     *
     * @param unknown_type $foreignKey
     * @return boolean
     */
	public function isInList($foreignKey) {
	   return false;
	}
}
