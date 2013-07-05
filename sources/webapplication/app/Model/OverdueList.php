<?php 

App::uses('MainList', 'Model');
App::uses('Task', 'Model');

class OverdueList extends MainList{
    
    public function __construct($userId){
        parent::__construct($userId, 'overdue');
        $this->_model = ClassRegistry::init('Task');   
    }
    
    public function getItems($count = 50, $page = 1){
        $this->_model->bindModel(array('hasOne' => array(
			'Ordered' => array(
    				'className' => 'Ordered',
                    'foreignKey' => 'foreign_key',
                    'type' => 'inner',
                    'conditions' => array(
                            'Ordered.list = Task.date',
                            'Ordered.model' => 'Task',
                            'Ordered.list_id' => 'DateList',
                        )
                    )
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                                $this->_model->alias . '.date' => 'DESC',
                                'Ordered.order' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 $this->_model->alias . '.user_id' => $this->_userId, 
                                 $this->_model->alias . '.done' => 0,
                                 $this->_model->alias . '.deleted' => 0,
                                 $this->_model->alias . '.date <' => date('Y-m-d'),
                                 
                            ),
                            'contain' => array('Ordered', 'Tag'),
                            'fields' => $this->_model->getFields(),
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
