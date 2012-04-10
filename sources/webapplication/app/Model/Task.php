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
				//'message' => 'Your custom message here',
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
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'future' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'repeatid' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		),
		
		'Day' => array(
			'className' => 'Day',
			'foreignKey' => 'day_id',
			'fields' => '',
			'order' => ''
		),
		
	);
    
    //------------------------------
    
    public function isOwn($task_id,$user_id){
        $this->contain();
        return $this->findByIdAndUser_id($task_id,$user_id);    
    }
    
    public function create($user_id, $title, $date=null, $time=null, $order=null, $priority=0, $future=0, $checktime=null){
     
        $this->data[$this->alias]['user_id'] = $user_id;
        $this->data[$this->alias]['title'] = $title;
        $this->data[$this->alias]['date'] = $date; 
        $this->data[$this->alias]['time'] = $time; 
        $this->data[$this->alias]['priority'] = $priority; 
        $this->data[$this->alias]['order'] = $this->getLastOrderByUser_idAndDate($user_id, $date) + 1;  
        $this->data[$this->alias]['future'] = $future;
        //debug($this->data);die;
        if($this->save($this->data)){
                return true;    
        }
        return false;
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
    
    public function changeTitle($task_id, $title){
        
        $this->data[$this->alias]['id'] = $task_id;
        $this->data[$this->alias]['title'] = $title;
        if (!$this->save($this->data)){
           return false;
        }
        return true;
    }
    
    
    public function changeOrders($task_id, $old_pos, $new_pos, $new_order){
        //���������� � ������� �������������� 
        if($old_pos < $new_pos){
            $oper = '-1';
            $start = $old_pos;
            $end =  $new_pos; 
        }else{
            $oper = '+1';
            $start = $new_pos;
            $end = $old_pos;
        }
        foreach($new_order as $k => $v){
            if(($k >= $start and $k <= $end) and $task_id <> $v){
                $arrId[] = $v;
            }
        }
        if ($this->updateAll(array('Task.order' => 'Task.order '.$oper),array('Task.id '=> $arrId)) and 
        $this->updateAll(array('Task.order' => "'".++$new_pos."'"),array('Task.id '=> $task_id))){
            return true;
        }
        return false;
    }
    
    public function deleteTask($task_id, $order){
        
        $arrId = array_slice($order, array_search($task_id, $order)+1); 
        if ($this->updateAll(array('Task.order' => 'Task.order -1'),array('Task.id '=> $arrId)) and 
        $this->delete($task_id)){
            return true;
        }
        return false;
    }
    
    public function setDone($task_id, $done){
        
        $this->data[$this->alias]['id'] = $task_id;
        $this->data[$this->alias]['done'] = $done;
        if (!$this->save($this->data)){
           return false;
        }
        return true;
    }
    
    public function getAllExpired($user_id){
        $this->contain();
        return $this->find('all', array(
                        'order' => array('Task.date' => 'ASC', 'Task.order' => 'ASC'),
                        'conditions' => array('AND' => array(
                                                     array('Task.user_id' => $user_id),
                                                     array('Task.done' => 0),
                                                     array('Task.date <' => CakeTime::format('Y-m-d',time())),
                                        )), 
         ));
    }
    
    public function getAllFuture($user_id){
        $this->contain();
        return $this->find('all', array(
                        'order' => array('Task.date' => 'ASC', 'Task.order' => 'ASC'),
                        'conditions' => array('AND' => array(
                                                     array('Task.user_id' => $user_id),
                                                     array('Task.future' => 1),
                                        )), 
         ));
    }
}
