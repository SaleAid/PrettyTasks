<?php 
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('MainList', 'Model');

class TagList extends MainList{
    
    public function __construct($userId, $name, $model){
        parent::__construct($userId, $name);
        $this->_model = ClassRegistry::init($model);
        $this->_listId = get_class($this);
    }
    
    /**
     * Return id if item in the list.
     *
     */
	public function isInList($foreignKey) {
		$result = $this->_ordered->find('first', 
                        array(
                            'conditions' => array(
                                'Ordered.user_id' => $this->_userId, 
                                 'Ordered.list' => $this->_name,
                                 'Ordered.list_id' => $this->_listId,
                                 'Ordered.model' => $this->_model->alias,
                                 'Ordered.foreign_key' => $foreignKey,
                            ),
                        )
                    );
         if($result){
            $this->_ordered->set($result);
            return $result[$this->_ordered->alias]['id'];
         }
         return false;
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
                                 'Ordered.list_id' => $this->_listId,
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
