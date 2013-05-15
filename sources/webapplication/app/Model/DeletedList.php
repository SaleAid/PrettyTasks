<?php 

App::uses('MainList', 'Model');
App::uses('Task', 'Model');

class DeletedList extends MainList{
    
    public function __construct($userId){
        parent::__construct($userId, 'deleted');
        $this->_model = ClassRegistry::init('Task');   
    }
    
    public function getItems($count = 50, $page = 1){
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                                $this->_model->alias . '.date' => 'DESC',
                                $this->_model->alias . '.modified' => 'DESC', 
                            ), 
                            'conditions' => array(
                                 $this->_model->alias . '.user_id' => $this->_userId, 
                                 $this->_model->alias . '.deleted' => 1,
                            ),
                            'contain' => array('Tag'),
                            'fields' =>  $this->_model->getFields(),
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
