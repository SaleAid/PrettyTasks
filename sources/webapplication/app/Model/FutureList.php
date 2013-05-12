<?php 

App::uses('MainList', 'Model');
App::uses('Ordered', 'Model');
App::uses('Task', 'Model');

class FutureList extends MainList{
    
    public function __construct($userId){
        parent::__construct($userId, 'planned');
        $this->_model = ClassRegistry::init('Task');   
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
