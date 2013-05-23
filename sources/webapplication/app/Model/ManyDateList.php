<?php 

App::uses('MainList', 'Model');
App::uses('Task', 'Model');

class ManyDateList extends MainList{
    
    public function __construct($userId, $arrayDates = array()){
        parent::__construct($userId, $arrayDates);
        $this->_model = ClassRegistry::init('Task');
        $this->_listId = 'DateList';
    }
    
    public static function arrayDates($beginDate, $endDate, $arrayDates = array()){
        $dates = array();
        $currentDate = $beginDate;
        while( $currentDate <= $endDate ) { 
            $dates[] = $currentDate;
            $currentDate = date("Y-m-d", strtotime($currentDate . "+1 day"));
        }
        $arrayDates = array_merge($dates, $arrayDates);
        $arrayDates = array_unique($arrayDates);
        sort($arrayDates);
        return $arrayDates;
    }
    
    public function getItems(){
        $this->_model->bindModel(array('hasOne' => array(
                    'Ordered' => array(
        				'className' => 'Ordered',
                        'foreignKey' => 'foreign_key',
                        'type' => 'inner',
                    ),
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                                 'Ordered.list' => 'ASC',
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
