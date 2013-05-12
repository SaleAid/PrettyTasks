<?php 

App::uses('MainList', 'Model');
App::uses('Ordered', 'Model');
App::uses('Task', 'Model');

class OverdueList extends MainList{
    
    public function __construct($userId){
        parent::__construct($userId, 'overdue');
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
                                $this->_model->alias . '.date' => 'DESC',
                                $ordered->alias . '.order' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 $this->_model->alias . '.user_id' => $this->_userId, 
                                 $this->_model->alias . '.done' => 0,
                                 $this->_model->alias . '.deleted' => 0,
                                 $this->_model->alias . '.date <' => date('Y-m-d'),
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
