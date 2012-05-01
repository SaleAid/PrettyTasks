<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 * @property User $User
 */
class Task extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'datetime' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		//'checktime' => array(
//			'boolean' => array(
//				'rule' => array('boolean'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'order' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'done' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'future' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'repeatid' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'transfer' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'priority' => array(
		      'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    private $_originData = array();
    //------------------------------
    
    public function isOwner($task_id,$user_id){
        $this->contain();
        if($task = $this->findByIdAndUser_id($task_id,$user_id)){
            $this->_originData = $task;
            $this->set($task);
            return $task;    
        }
        return false;    
    }
    
    public function create($user_id, $title, $date=null, $time=null, $order=null, $priority=null, $future=null, $checktime=null){
        $this->data = $this->_prepareTask( $user_id, $title, $date, $time, $order, $priority, $future, $checktime);  
        return $this;
    }
    
    private function _prepareTask($user_id, $title, $date=null, $time=null, $order=null, $priority=null, $future=null, $checktime=null){
        $data[$this->alias]['user_id'] = $user_id;
        $data[$this->alias]['title'] = $title;
        $data[$this->alias]['date'] = $date; 
        $data[$this->alias]['time'] = $time;
        if(strpos($title, '!') === false){
            $data[$this->alias]['priority'] = 0;     
        }else{
            $data[$this->alias]['priority'] = 1;
        }
        $data[$this->alias]['order'] = $order ? $order : $this->getLastOrderByUser_idAndDate($user_id, $date) + 1;  
        if(!$date){
            $future = 1;
        }
        $data[$this->alias]['future'] = $future ? $future : 0;
        return $data;
    }
    
    public function getLastOrderByUser_idAndDate($user_id, $date){
        $lastOrder =  $this->find('first', array(
                        'fields' => array('Task.order'),
                        'order' => array('Task.order' => 'desc'),
                        'conditions' => array('AND' => array(
                                                     array('Task.user_id' => $user_id),
                                                     array('Task.date' => $date),
                                        )), 
         ));
         if($lastOrder){
            return $lastOrder[$this->alias]['order'];
         }
         return false;        
    }
    
    public function getAllForDate($user_id, $date){
        $this->contain();
        return $this->find('all', array(
                        'order' => array('Task.order' => 'ASC'),
                        'conditions' => array('AND' => array(
                                                     array('Task.user_id' => $user_id),
                                                     array('Task.date' => $date),
                                        )), 
         ));
    }
    
    
    public function beforeSave() {
    	//TODO разнести по функциям
        if($this->_originData){
            // change order
            if($this->_originData[$this->alias]['order'] <> $this->data[$this->alias]['order'] and 
            $this->_originData[$this->alias]['date'] == $this->data[$this->alias]['date']){
                if($this->_originData[$this->alias]['order'] < $this->data[$this->alias]['order']){
                    $operation = '-1';
                    $start = $this->_originData[$this->alias]['order'];
                    $end =  $this->data[$this->alias]['order']; 
                }else{
                    $operation = '+1';
                    $start = $this->data[$this->alias]['order'];
                    $end = $this->_originData[$this->alias]['order'];
                }
                //TODO Когда делаем апдейт, всегда нужно также менять поле modified, 
                //возможно оно нам понадобиться для синхронизации.
                //Проверить, чтобы везде было так
                if ($this->updateAll(array('Task.order' => 'Task.order '.$operation),
                                     array('Task.date '=> $this->data[$this->alias]['date'],  
                                           'Task.user_id' => $this->data[$this->alias]['user_id'],
                                           'Task.order between  ? and ?' => array($start, $end),
                                           ))){
                    return true;
                }
                return false;
            }
            
            // drag on the day
            if($this->_originData[$this->alias]['date'] <> $this->data[$this->alias]['date']){
                if ($this->updateAll(array('Task.order' => 'Task.order -1'),
                                     array('Task.date '=> $this->_originData[$this->alias]['date'],  
                                           'Task.user_id' => $this->data[$this->alias]['user_id'],
                                           'Task.order >' => $this->_originData[$this->alias]['order'],
                                           'Task.id <>' => $this->data[$this->alias]['id'],
                                           )) and 
                    $this->updateAll(array('Task.order' => 'Task.order +1'),
                                     array( 'Task.date '=> $this->data[$this->alias]['date'],
                                            'Task.user_id' => $this->data[$this->alias]['user_id'],
                                            'Task.order >' => 0,
                                            'Task.id <>' => $this->data[$this->alias]['id'],)
                                     )
                    ){
                    return true;
                }
                return false;
            }
            
        }
        return true;
    }
    
    public function beforeDelete() {
        if($this->updateAll(array('Task.order' => 'Task.order -1'),
                         array('Task.date '=> $this->data[$this->alias]['date'],  
                               'Task.user_id' => $this->data[$this->alias]['user_id'],
                               'Task.order >' => $this->data[$this->alias]['order']
                    ))){
            return true;                
                    }
        return false;
    }
    
    public function setTime($time){
        $this->data[$this->alias]['time'] = $time;
        return $this;
    }
        
    public function setDate($date){
        $this->data[$this->alias]['date'] = $date;
        return $this;
    }
    
    public function setOrder($order){
        $this->data[$this->alias]['order'] = $order;
        return $this;
    }
    
     public function setFuture($future){
        $this->data[$this->alias]['future'] = $future;
        return $this;
    }
    
    public function setTitle($title){
        $this->data[$this->alias]['title'] = $title;
        if(strpos($title, '!') === false){
            $this->data[$this->alias]['priority'] = 0;     
        }else{
            $this->data[$this->alias]['priority'] = 1;
        }
        return $this;
    }
    
    public function setDone($done){
        $this->data[$this->alias]['done'] = $done;
        return $this;
    }
    
    public function getAllExpired($user_id){
        $this->contain();
        return $this->find('all', array(
                        'order' => array('Task.date' => 'DESC', 'Task.order' => 'ASC'),
                        'conditions' => array(
                                              'Task.user_id' => $user_id,
                                              'Task.done' => 0,
                                              'Task.date <' => CakeTime::format('Y-m-d',time()),
                                        )
                        ) 
                );
    }
    
    public function getAllFuture($user_id){
        $this->contain();
        return $this->find('all', array(
                        'order' => array('Task.date' => 'ASC', 'Task.order' => 'ASC'),
                        'conditions' => array(
                                              'Task.user_id' => $user_id,
                                              'Task.future' => 1,
                                        )
                        )
                );
    }
}
