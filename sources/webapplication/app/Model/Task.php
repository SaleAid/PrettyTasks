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
                'rule' => array(
                    'alphanumeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'user_id' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'title' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ), 
                'message' => 'Your custom message here'
            )
        ),  //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'datetime' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
                'rule' => array(
                    'numeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'done' => array(
            'numeric' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'future' => array(
            'numeric' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'repeatid' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'transfer' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'priority' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),  //'message' => 'Your custom message here',
        //'allowEmpty' => false,
        //'required' => false,
        //'last' => false, // Stop validation after this rule
        //'on' => 'create', // Limit validation to 'create' or 'update' operations
        'created' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            )
        ) //'message' => 'Your custom message here',
    ); //'allowEmpty' => false,
    //'required' => false,
    //'last' => false, // Stop validation after this rule
    //'on' => 'create', // Limit validation to 'create' or 'update' operations
    //'modified' => array(
    //'datetime' => array(
    //'rule' => array('datetime'),
    //'message' => 'Your custom message here',
    //'allowEmpty' => false,
    //'required' => false,
    //'last' => false, // Stop validation after this rule
    //'on' => 'create', // Limit validation to 'create' or 'update' operations
    //),
    //),
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
            'conditions' => '', 
            'fields' => '', 
            'order' => ''
        ),
    );
    private $_originData = array();

    //------------------------------
    public function get($task_id) {
        $this->contain();
        $task = $this->findById($task_id);
        if ($task) {
            $this->_originData = $task;
            $this->set($task);
            return $task;
        }
        return false;
    }

    public function isOwner($task_id, $user_id) {
        $this->contain();
        $task = $this->findByIdAndUser_id($task_id, $user_id);
        if ($task) {
            $this->_originData = $task;
            $this->set($task);
            return $task;
        }
        return false;
    }

    public function create($user_id, $title, $date = null, $time = null, $order = null, $priority = null, $future = null, $checktime = null) {
        $this->data = $this->_prepareTask($user_id, $title, $date, $time, $order, $priority, $future, $checktime);
        if($this->data[$this->alias]['time']){
            $this->_originData[$this->alias]['time'] = null;
            $this->_originData[$this->alias]['order'] = $this->data[$this->alias]['order'];
            $this->_originData[$this->alias]['date'] = $this->data[$this->alias]['date'];
        }
        return $this;
    }

    private function _prepareTask($user_id, $title, $date = null, $time = null, $order = null, $priority = null, $future = null, $checktime = null) {
        $data[$this->alias]['user_id'] = $user_id;
        $data[$this->alias]['title'] = $title;
        $data[$this->alias]['date'] = $date;
        $data[$this->alias]['time'] = $time;
        if (strpos($title, '!') === false) {
            $data[$this->alias]['priority'] = 0;
        } else {
            $data[$this->alias]['priority'] = 1;
        }
        $data[$this->alias]['order'] = $order ? $order : $this->getLastOrderByUser_idAndDate($user_id, $date) + 1;
        if (! $date) {
            $future = 1;
        }
        $data[$this->alias]['future'] = $future ? $future : 0;
        if( !$time ){
            $pattern = '/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?/';
            preg_match($pattern, $title, $matches);
            if( isset($matches[0]) ){
                $data[$this->alias]['time'] = $matches[0].':00';
                $data[$this->alias]['title'] = substr($title,5);
            }    
        }
        return $data;
    }

    public function getLastOrderByUser_idAndDate($user_id, $date) {
        $lastOrder = $this->find('first', 
                                array(
                                    'fields' => array(
                                        'Task.order'
                                    ), 
                                    'order' => array(
                                        'Task.order' => 'desc'
                                    ), 
                                    'conditions' => array(
                                        'AND' => array(
                                            array(
                                                'Task.user_id' => $user_id
                                            ), 
                                            array(
                                                'Task.date' => $date
                                            )
                                        )
                                    )
                                ));
        if ($lastOrder) {
            return $lastOrder[$this->alias]['order'];
        }
        return false;
    }

    public function getAllForDate($user_id, $date) {
        $this->contain();
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'AND' => array(
                                    array(
                                        'Task.user_id' => $user_id
                                    ), 
                                    array(
                                        'Task.date' => $date
                                    )
                                )
                            )
                        ));
    }

    private function _isOrderChanged() {
        if ($this->_originData[$this->alias]['order'] != $this->data[$this->alias]['order'] and $this->_originData[$this->alias]['date'] == $this->data[$this->alias]['date']) {
            return true;
        }
        return false;
    }

    private function _isDraggedOnDay() {
        if ($this->_originData[$this->alias]['date'] != $this->data[$this->alias]['date']) {
            return true;
        }
        return false;
    }

    private function _isOrderChangedWithTime() {
        if ((CakeTime::format('H:i', $this->_originData[$this->alias]['time']) != CakeTime::format('H:i', $this->data[$this->alias]['time']) and ! empty($this->data[$this->alias]['time']) and $this->_originData[$this->alias]['date'] == $this->data[$this->alias]['date']) or ($this->_originData[$this->alias]['date'] != $this->data[$this->alias]['date'] and ! empty(
                                                                                                                                                                                                                                                                                                                                                                            $this->data[$this->alias]['time']))) {
            return true;
        }
        return false;
    }

    private function _changeOrder() {
        if ($this->_originData[$this->alias]['order'] < $this->data[$this->alias]['order']) {
            $operation = '-1';
            $start = $this->_originData[$this->alias]['order'];
            $end = $this->data[$this->alias]['order'];
        } else {
            $operation = '+1';
            $start = $this->data[$this->alias]['order'];
            $end = $this->_originData[$this->alias]['order'];
        }
        $now = "'".date("Y-m-d H:i:s")."'";
        if ($this->updateAll(array(
            'Task.order' => 'Task.order ' . $operation,
            'modified' => $now
        ), 
                            array(
                                'Task.date ' => $this->data[$this->alias]['date'], 
                                'Task.user_id' => $this->data[$this->alias]['user_id'], 
                                'Task.order between  ? and ?' => array(
                                    $start, 
                                    $end
                                )
                            ))) {
            return true;
        }
        return false;
    }

    private function _dragOnDay() {
        $now = "'".date("Y-m-d H:i:s")."'";
        if ($this->updateAll(array(
            'Task.order' => 'Task.order -1',
            'modified' => $now
        ), 
                            array(
                                'Task.date ' => $this->_originData[$this->alias]['date'], 
                                'Task.user_id' => $this->data[$this->alias]['user_id'], 
                                'Task.order >' => $this->_originData[$this->alias]['order'], 
                                'Task.id <>' => $this->data[$this->alias]['id']
                            )) and $this->updateAll(array(
            'Task.order' => 'Task.order +1',
            'modified' => $now
        ), 
                                                array(
                                                    'Task.date ' => $this->data[$this->alias]['date'], 
                                                    'Task.user_id' => $this->data[$this->alias]['user_id'],  
                                                    'Task.order >' => $this->data[$this->alias]['order'] - 1, 
                                                    'Task.id <>' => $this->data[$this->alias]['id']
                                                ))) {
            return true;
        }
        return false;
    }

    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        if ($this->_originData) {
            if ($order = $this->_getPositionByTime()) {
                $this->setOrder($order);
            }
            // change order
            if ($this->_isOrderChanged()) {
                return $this->_changeOrder();
            }
            // drag on the day
            if ($this->_isDraggedOnDay()) {
                return $this->_dragOnDay();
            }
        }
        return true;
    }

    public function beforeDelete() {
        $now = "'".date("Y-m-d H:i:s")."'";
        if ($this->updateAll(array(
            'Task.order' => 'Task.order -1',
            'modified' => $now
        ), array(
            'Task.date ' => $this->data[$this->alias]['date'], 
            'Task.user_id' => $this->data[$this->alias]['user_id'], 
            'Task.order >' => $this->data[$this->alias]['order']
        ))) {
            return true;
        }
        return false;
    }

    private function _getPositionByTime() {
        $id = isset($this->data[$this->alias]['id']) ? $this->data[$this->alias]['id'] : 0;
        $user_id = $this->data[$this->alias]['user_id'];
        $date = $this->data[$this->alias]['date'];
        $newOrderID = 0;
        if ($this->_isOrderChangedWithTime()) {
            $this->contain();
            $listTaskWithTime = $this->find('all', 
                                            array(
                                                'conditions' => array(
                                                    "not" => array(
                                                        "Task.time" => null, 
                                                        "Task.id" => $id
                                                    ), 
                                                    "Task.user_id" => $user_id, 
                                                    "Task.date" => $date
                                                ), 
                                                'order' => array(
                                                    'Task.time' => 'ASC', 
                                                    //'Task.order' => 'desc'
                                                )
                                            ));
        foreach ( $listTaskWithTime as $task ) {
            if ($this->data[$this->alias]['time'] > $task[$this->alias]['time']) {
                $newOrderID = $task[$this->alias]['order'] + 1;
            }
        }
	    if(!empty($listTaskWithTime) and $newOrderID == 0){
            $newOrderID = $listTaskWithTime[0][$this->alias]['order'] - 1;
        }
	   if ( ! $this->_isDraggedOnDay() ) {
            $lastOrder = $this->getLastOrderByUser_idAndDate($user_id, $date);
	        if($newOrderID > $lastOrder){
	            $newOrderID = $lastOrder;
	        }
	    }
        if(!$newOrderID){
           $newOrderID = 1;
        }
        return $newOrderID;
        }
        return false;
    }

    public function setEdit($title, $comment=null, $date=null, $time=null, $timeEnd=null, $done=null){
        $this->setDate($date)
             ->setTime($time, $timeEnd)
             ->setDone($done)
             ->setTitle($title)
             ->setCommnet($comment);
        return $this;
    }
    
    public function setTime($time, $timeEnd=null){
        $this->data[$this->alias]['time'] = $time;  
        $this->data[$this->alias]['timeend'] = $timeEnd;  
        if(!$time){
            $this->data[$this->alias]['timeend'] = null;
        }
        return $this;
    }
    
    public function setDate($date) {
        if (! $date) {
            $this->setFuture(1);
        } else {
            $this->setFuture(0);
        }
        $this->data[$this->alias]['date'] = $date;
        return $this;
    }

    public function setOrder($order) {
        $this->data[$this->alias]['order'] = $order;
        return $this;
    }

    public function setFuture($future) {
        $this->data[$this->alias]['future'] = $future;
        return $this;
    }

    public function setTitle($title) {
        $this->data[$this->alias]['title'] = $title;
        if (strpos($title, '!') === false) {
            $this->data[$this->alias]['priority'] = 0;
        } else {
            $this->data[$this->alias]['priority'] = 1;
        }
        return $this;
    }
    
    public function setCommnet($comment) {
        $this->data[$this->alias]['comment'] = $comment;
        return $this;
    }

    public function setDone($done) {
        $this->data[$this->alias]['done'] = $done;
        $this->data[$this->alias]['datedone'] = null;
        if($done){
            $this->data[$this->alias]['datedone'] = date("Y-m-d H:i:s");
        }
        return $this;
    }

    public function getAllExpired($user_id) {
        $this->contain();
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 0, 
                                'Task.date <' => date('Y-m-d')
                            )
                        ));
    }
    
    public function getAllOverdue($user_id) {
        $result = array();
        $this->contain();
        $tasks = $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 0, 
                                'Task.date <' => date('Y-m-d')
                            )
                        ));
        foreach($tasks as $item){
            $result[$item['Task']['date']][] = $item;
        }
        return $result;
    }
    
    public function getAllCompleted($user_id) {
        $result = array();
        $this->contain();
        $tasks = $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 1, 
                                //'Task.date <' => CakeTime::format('Y-m-d', time())
                            )
                        ));
        foreach($tasks as $item){
            $result[$item['Task']['date']][] = $item;
        }
        return $result;
    }

    public function getAllFuture($user_id) {
        $this->contain();
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'ASC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.future' => 1
                            )
                        ));
    }

    public function getDays($user_id, $from, $to, $arrDays = null) {
        $days = array();
        do {
            $days[] = $from;
            $from = date("Y-m-d", strtotime($from . "+1 day"));
        } while($from < $to);
        if(is_array($arrDays)){
            sort($arrDays);
            $days = array_merge($days, $arrDays);
            $days = array_unique($days);
        }
        $this->contain();
        $result = $this->find('all', 
                            array(
                                'order' => array(
                                    'Task.date' => 'ASC', 
                                    'Task.order' => 'ASC'
                                ), 
                                'conditions' => array(
                                    'Task.user_id' => $user_id, 
                                    'Task.date' => $days
                                )
                            ));
        foreach ( $days as $v ) {
            $data[$v] = array();
        }
        foreach($result as $item){
            $data[$item['Task']['date']][] = $item;
        }
   
        return $data;
        
    }
    
    private function _setDayToConfig($user_id, $date) {
        $config = $this->User->getConfig($user_id);
        if (! is_array($config) || ! in_array($date, $config)) {
            $config['day'][] = $date;
        }
        $this->User->setConfig($user_id, $config);
    }

    public function getTasksForDay($user_id, $date) {
        $this->_setDayToConfig($user_id, $date);
        $this->contain();
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'ASC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.date' => $date
                            )
                        ));
    }

    public function deleteDayFromConfig($user_id, $date) {
        $config = array();
        $config = $this->User->getConfig($user_id);
        unset($config['day'][array_search($date, $config['day'])]);
        return $this->User->setConfig($user_id, $config);
    }
}
