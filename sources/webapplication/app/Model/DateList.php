<?php 

App::uses('MainList', 'Model');
App::uses('Ordered', 'Model');
App::uses('Task', 'Model');

class DateList extends MainList{
    
    public function __construct($userId, $name){
        parent::__construct($userId, $name);
        $this->_model = ClassRegistry::init('Task');
        $this->_ordered = ClassRegistry::init('Ordered');   
    }
    
    public function removeFromList($foreignKey){
        $idItem = $this->isInList($foreignKey);
        if($idItem){
            return $this->_ordered->delete($idItem);    
        }
        return false;
    }
    
    /**
     * Return id if item in the list.
     *
     */
	public function isInList($foreignKey) {
		$result = $this->_ordered->find('first', 
                        array(
                            'conditions' => array(
                                 $this->_ordered->alias . '.user_id' => $this->_userId, 
                                 $this->_ordered->alias . '.list' => $this->_name,
                                 $this->_ordered->alias . '.model' => $this->_model->alias,
                                 $this->_ordered->alias . '.foreign_key' => $foreignKey,
                            ),
                        )
                    );
         if($result){
            
            $this->_ordered->set($result);
            return $result[$this->_ordered->alias]['id'];
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
    
    public function addToList($foreignKey, $toFirst = false ){
        $this->_ordered->add($this->_model->alias, $this->_name, $foreignKey, $this->_userId, $toFirst);
    }
    
    public function addToListWithTime($foreignKey, $time){
        $position = $this->getPositionItemWithTime($time);
        if(!$position){
            $this->addToList($foreignKey);
        } else {
            $this->insert($foreignKey, $position);
        }
        
    }
    /**
     * Inserts an item on a certain position
     *
     */
    public function insert($foreignKey, $position){
        $this->_ordered->insert($this->_model->alias, $this->_name, $foreignKey, $this->_userId, $position);
    }
    
    protected function getPositionItemWithTime($time){
        $items = $this->getItemsWithTime();
        if(!$items){
            return false;
        }
        $position = 0;
        foreach($items as $item){
            if($time <= $item[$this->_model->alias]['time']){
                $position = $item[$this->_ordered->alias]['order'];
                break;
            }
        }
        if(!$position){
            $item = end($items);
            $position = $item[$this->_ordered->alias]['order'] + 1;
        }
        return $position;
        
    }
    
    protected function getItemsWithTime(){
        $this->_model->bindModel(array('hasOne' => array(
			$this->_ordered->alias => array(
    				'className' => $this->_ordered->alias,
                    'foreignKey' => 'foreign_key',
                    'type' => 'inner',
                    )
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                                $this->_model->alias . '.time' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 $this->_ordered->alias . '.user_id' => $this->_userId, 
                                 $this->_ordered->alias . '.list' => $this->_name,
                                 $this->_ordered->alias . '.model' => $this->_model->alias,
                                 'not' => array( $this->_model->alias . '.time' => null ), 
                            ),
                            'contain' => array('Ordered'),
                            //'fields' => array('Task.*')
                        ));
        return $data;
    }
    
    
    
    public function getItems($count = 50, $page = 1){
        $ordered = new Ordered(); 
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
                                 $ordered->alias . '.list' => $this->_name,
                                 $ordered->alias . '.model' => $this->_model->alias
                            ),
                            'contain' => array('Ordered', 'Tag'),
                            'fields' => array('Task.*'),
                            'limit' => $count,
                            'page' => $page
                        ));
        $data = array_map( 
            function($task) { 
                return $task['Task']; 
            }, 
            $data 
        ); 
        return $data;
        
    }
}
