<?php 

App::uses('MainList', 'Model');
App::uses('Ordered', 'Model');
App::uses('Task', 'Model');

class DateList extends MainList{
    
    protected $_list;
    protected $_model;
    protected $_userId;
    
    public function __construct($userId, $date){
        $this->_list = $date;
        $this->_userId = $userId;
        $this->_model = new Task();    
    }
    
    public function addToList($foreignKey, $toFirst = false ){
        $ordered = new Ordered(); 
        $ordered->add($this->_model->alias, $this->_list, $foreignKey, $this->_userId, $toFirst);
    }
    
    public function deleteFromList($foreignKey){
        
    }
    
    public function reorder($foreignKey, $order){
        
    }
    
    public function getAll(){
        $ordered = new Ordered(); 
        
        /*$ordered->bindModel(array('belongsTo' => array(
			$this->_model->alias => array(
    				'className' => $this->_model->alias,
                    'foreignKey' => 'foreign_key',
                    'type' => 'inner',
                    )
                )
            )
        );
        $data = $ordered->find('all', 
                        array(
                            'order' => array(
                               $ordered->alias . '.order' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 $ordered->alias . '.user_id' => $this->_userId, 
                                 $ordered->alias . '.list' => $this->_list,
                                 $ordered->alias . '.model' => $this->_model->alias
                            ),
                            //'fields' => $this->_taskFields,
                        ));
        */
        $this->_model->bindModel(array('hasOne' => array(
			$ordered->alias => array(
    				'className' => $ordered->alias,
                    'foreignKey' => 'foreign_key',
                    'type' => 'inner',
                    )
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                               $ordered->alias . '.order' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 $ordered->alias . '.user_id' => $this->_userId, 
                                 $ordered->alias . '.list' => $this->_list,
                                 $ordered->alias . '.model' => $this->_model->alias
                            ),
                            'contain' => array(
                                'Tag' => array('fields' => array('name')),
                                'Ordered' => array('fields' => array('order')),
                            ),
                            //'fields' => $this->_taskFields,
                        ));
        return $data;
        
    }
}
