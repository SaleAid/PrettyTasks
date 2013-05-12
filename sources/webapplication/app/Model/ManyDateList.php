<?php 

App::uses('MainList', 'Model');
App::uses('Ordered', 'Model');
App::uses('Task', 'Model');

class ManyDateList extends MainList{
    
    public function __construct($userId, $arrayDates = array()){
        parent::__construct($userId, $arrayDates);
        $this->_model = ClassRegistry::init('Task');
    }
    
    public static function arrayDates($beginDate, $endDate, $arrayDates = array()){
        $dates = array();
        while( $beginDate <= $endDate ) { 
            $dates[] = $beginDate;
            $beginDate = date("Y-m-d", strtotime($beginDate . "+1 day"));
        }
        $arrayDates = array_merge($dates, $arrayDates);
        $arrayDates = array_unique($arrayDates);
        sort($arrayDates);
        return $arrayDates;
    }
    
    public function getItems(){
        $ordered = new Ordered(); 
        $this->_model->bindModel(array('hasOne' => array(
                    $ordered->alias => array(
        				'className' => $ordered->alias,
                        'foreignKey' => 'foreign_key',
                        'type' => 'inner',
                    ),
                )
            )
        );
        $data = $this->_model->find('all', 
                        array(
                            'order' => array(
                              $ordered->alias . '.list' => 'ASC',
                              $ordered->alias . '.order' => 'ASC',
                            ), 
                            'conditions' => array(
                                 $ordered->alias . '.user_id' => $this->_userId, 
                                 $ordered->alias . '.list' => $this->_name,
                                 $ordered->alias . '.model' => $this->_model->alias
                            ),
                            //'contain' => array('Ordered', 'Tag'),
                            'fields' => array('Task.*'),
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
