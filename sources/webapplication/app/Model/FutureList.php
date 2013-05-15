<?php 

App::uses('MainList', 'Model');
App::uses('Task', 'Model');

class FutureList extends MainList{
    
    public function __construct($userId){
        parent::__construct($userId, 'planned');
        $this->_model = ClassRegistry::init('Task');   
    }
    
    public function getItems($count = 50, $page = 1){
        $this->_model->bindModel(array('hasOne' => array(
			'Ordered' => array(
    				'className' => 'Ordered',
                    'foreignKey' => 'foreign_key',
                    'type' => 'inner',
                    )
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                               'Ordered.order' => 'ASC', 
                            ), 
                            'conditions' => array(
                                 'Ordered.user_id' => $this->_userId, 
                                 'Ordered.list' => $this->_name,
                                 'Ordered.model' => $this->_model->alias
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
