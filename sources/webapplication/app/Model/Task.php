<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 * @property User $User
 */
class Task extends AppModel {
    
    public $actsAs = array('Taggable');
    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';
    
    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'tasks';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            ),
        	'uuid'
        ), 
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            ),
        	'uuid'
        ), 
        'title' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Поле должно быть заполнено' 
            ),
            'maxLength' => array(
                'rule'    => array('maxLength', 255),
                'message' => 'Максимальная длина задачи не больше %d символов'
            )
        ),
        'comment' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', 1000),
                'message' => 'Максимальная длина комментария не больше %d символов'
            )
        ),  
        'date' => array(
            'date' => array(
                'rule'    => array('date', 'ymd'),
                'allowEmpty' => true,
                'message' => 'Некорректная дата'
            )
        ),
        'time' => array(
            'time' => array(
                'rule' => array('time'),
                    'allowEmpty' => true,
                    'message' => 'Некорректное время'
            )
        ),
        'timeend' => array(
            'time' => array(
                'rule' => array('time'),
                    'allowEmpty' => true,
                    'message' => 'Некорректное время'
            ),
            'comparisonTime' => array(
                'rule'    => array('comparisonTime'),
                'message' => 'Время окончания должно быть больше начала'
            )
        ),  
        'order' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),
        'done' => array(
            'numeric' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),
        'datedone' => array(
            'datetime' => array(
                'rule' => array('datetime'),
                'allowEmpty' => true,
            )
        ),
        'future' => array(
            'numeric' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),
        'repeatid' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),
        'transfer' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),
        'priority' => array(
            'numeric' => array(
                'rule' => array(
                    'numeric'
                )
            )
        ),
        'created' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            )
        ),
        'day_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ), 
    );
    
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
    
    private $_taskFields = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'order', 'future', 'deleted', 'done' ,'datedone', 'comment');
    
    private $_taskFieldsSave = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'order', 'future', 'deleted', 'done' ,'datedone', 'comment', 'tags');
    /**
     * set true if method 
     */
    private $_move = false;
    
    public function comparisonTime($data) {
        if ($data['timeend'] > $this->data[$this->alias]['time']) {
            return true;
        }
        return false;
    }
    
    //------------------------------
    public function get($task_id) {
        $this->contain('Tag.name');
        $result = $this->find('first', 
                        array(
                            'conditions' => array(
                                'Task.id' => $task_id, 
                            ),
                            'fields' => $this->_taskFields,
                        ));
        $task[$this->alias] = $result[$this->alias];
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

    public function create($user_id, $title, $date = null, $time = null, $order = null, $priority = null, $future = null, $clone = null) {
        $this->data = $this->_prepareTask($user_id, $title, $date, $time, $order, $priority, $future);
        if($this->data[$this->alias]['time']){
            $this->_originData[$this->alias]['time'] = null;
            $this->_originData[$this->alias]['order'] = $this->data[$this->alias]['order'];
            $this->_originData[$this->alias]['date'] = $this->data[$this->alias]['date'];
        }
        if($clone){
            unset($this->id);
        }
        return $this;
    }

    private function _prepareTask($user_id, $title, $date = null, $time = null, $order = null, $priority = null, $future = null) {
        $data[$this->alias]['user_id'] = $user_id;
        $data[$this->alias]['title'] = $title;
        $data[$this->alias]['date'] = $date;
       
        if($priority == null){
            if (strpos($title, '!') === false) {
                $data[$this->alias]['priority'] = 0;
            } else {
                $data[$this->alias]['priority'] = 1;
            }    
        }else{
            $data[$this->alias]['priority'] = $priority;
        }
        //$data[$this->alias]['order'] = $order ? $order : $this->getLastOrderByUser_idAndDate($user_id, $date) + 1;
        if (! $date) {
            $future = 1;
            $time = null;
            $data[$this->alias]['order'] = 1;
        }else{
            $data[$this->alias]['order'] = $order ? $order : $this->getLastOrderByUser_idAndDate($user_id, $date) + 1;
            $future = 0;
        }
         $data[$this->alias]['time'] = $time;
        $data[$this->alias]['future'] = $future ? $future : 0;
        if( !$time and !$future ){
            $pattern = '/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?/';
            preg_match($pattern, $title, $matches);
            if( isset($matches[0]) ){
                $data[$this->alias]['time'] = CakeTime::format('H:i:s', $matches[0]);
                $data[$this->alias]['title'] = substr($title, 5);
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
                                            ),
                                            array(
                                                'Task.deleted' => 0
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
                                    ),
                                    array(
                                        'Task.deleted' => 0
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
        if ($this->_originData[$this->alias]['date'] != $this->data[$this->alias]['date'] && isset($this->data[$this->alias]['id'])) {
            return true;
        }
        return false;
    }

    private function _isOrderChangedWithTime() {
        if ((CakeTime::format('H:i', $this->_originData[$this->alias]['time']) != CakeTime::format('H:i', $this->data[$this->alias]['time']) and 
                ! empty($this->data[$this->alias]['time']) and 
                $this->_originData[$this->alias]['date'] == $this->data[$this->alias]['date']) 
            or 
                //($this->_originData[$this->alias]['date'] != $this->data[$this->alias]['date'] and
                ! empty($this->data[$this->alias]['time'])) {
            return true;
        }
        return false;
    }
    private function _isRecovered(){
        if( isset($this->data[$this->alias]['deleted']) && !$this->data[$this->alias]['deleted'] && $this->_originData[$this->alias]['deleted']){
            return true;
        }
        return false;
    }
    
    private function _isDeleted() {
        if( isset($this->data[$this->alias]['deleted']) && $this->data[$this->alias]['deleted'] ){
            return true;
        }
        return false;
    }
    
    private function _isCreateFuture() {
        if( !isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['future'] ){
            return true;
        }
        return false;
    }

    private function _changeOrder() {
        $now = "'".date("Y-m-d H:i:s")."'";
        if( $this->_isDeleted()){
            if ($this->updateAll(array(
                'Task.order' => 'Task.order -1',
                'modified' => $now
            ), array(
                'Task.date ' => $this->data[$this->alias]['date'], 
                'Task.user_id' => $this->data[$this->alias]['user_id'], 
                'Task.order >' => $this->_originData[$this->alias]['order']
            ))) {
                return true;
            }
            return false;    
        }

        if ($this->_originData[$this->alias]['order'] < $this->data[$this->alias]['order'] ) {
            $operation = '-1';
            $start = $this->_originData[$this->alias]['order'];
            $end = $this->data[$this->alias]['order'];
        } else {
            $operation = '+1';
            $start = $this->data[$this->alias]['order'];
            $end = $this->_originData[$this->alias]['order'];
        }
        
        if ($this->updateAll(array(
            'Task.order' => 'Task.order ' . $operation,
            'modified' => $now
        ), 
                            array(
                                'Task.date ' => $this->data[$this->alias]['date'], 
                                'Task.user_id' => $this->data[$this->alias]['user_id'],
                                'Task.deleted' => 0,
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
    
    public function _changeOrderAfterRecovered(){
        $now = "'".date("Y-m-d H:i:s")."'";
        if ($this->updateAll(array(
            'Task.order' => 'Task.order + 1',
            'modified' => $now
        ), array(
            'Task.date ' => $this->data[$this->alias]['date'], 
            'Task.user_id' => $this->data[$this->alias]['user_id'], 
             'Task.order >' => $this->data[$this->alias]['order'] - 1, 
             'Task.id <>' => $this->data[$this->alias]['id']
        ))) {
            return true;
        }
        return false;    
    }
    
    public function _changeOrderAfterCreateFuture(){
        $now = "'".date("Y-m-d H:i:s")."'";
        if ($this->updateAll(array(
            'Task.order' => 'Task.order + 1',
            'modified' => $now
        ), array(
            'Task.future' => 1, 
            'Task.user_id' => $this->data[$this->alias]['user_id'], 
            'Task.deleted' => 0, 
        ))) {
            return true;
        }
        return false;    
    }

    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        //check and add tags
        if(isset($this->data[$this->alias]['title'])){
            $this->_checkTags($this->data[$this->alias]['title'], 'title');
        }
        if( $this->_isCreateFuture() ) {
            return $this->_changeOrderAfterCreateFuture();
        }
        if ($this->_originData) {
            if ($order = $this->_getPositionByTime() and ! $this->_isDeleted()  and !$this->_move) {
                $this->setOrder($order);
            }
            //change order after recoverd task
            if($this->_isRecovered()){
                return $this->_changeOrderAfterRecovered();
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
                                                        //"Task.id" => $id,
                                                        //"Task.order" => 0
                                                        'Task.deleted' => 1
                                                    ), 
                                                    "Task.user_id" => $user_id, 
                                                    "Task.date" => $date
                                                ), 
                                                'order' => array(
                                                    'Task.time' => 'ASC', 
                                                    'Task.order' => 'ASC'
                                                )
                                            ));
            foreach ( $listTaskWithTime as $task ) {
                if ($this->data[$this->alias]['time'] > $task[$this->alias]['time']) {
                    if ( $id == $task[$this->alias]['id'] ){
                        $newOrderID = $task[$this->alias]['order'];
                    } else {
                        $newOrderID = $task[$this->alias]['order'] + 1;
                    }
                }
            }
            //pr($newOrderID);
            if(!empty($listTaskWithTime) and $newOrderID == 0){
                $newOrderID = $listTaskWithTime[0][$this->alias]['order'];
                //$end = end($listTaskWithTime);
                //if($newOrderID >= $end[$this->alias]['order'] or 
//                    (!$this->_isDraggedOnDay() and !$this->_isRecovered())
//                ){
//                    $newOrderID = $newOrderID - 1;
//                }
            }
            //pr($newOrderID);            
//    	    if(!empty($listTaskWithTime) and $newOrderID == 0 and ($this->_isDraggedOnDay() or !$id or $this->_isRecovered())){
//                $newOrderID = $listTaskWithTime[0][$this->alias]['order'];// - 1;
//            }
//            if(!empty($listTaskWithTime) and $newOrderID == 0 and (!$this->_isDraggedOnDay() and !$this->_isRecovered())){
//                $newOrderID = $listTaskWithTime[0][$this->alias]['order'] - 1;
//            }
           
    	   if ( (!$this->_isDraggedOnDay() and !$this->_isRecovered()) and isset($this->data[$this->alias]['id']) ) {
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

    public function setEdit($title, $priority, $comment=null, $date=null, $time=null, $timeEnd=null, $done=null){
        $this->setDate($date)
             ->setTime($time, $timeEnd)
             ->setDone($done)
             ->setTitle($title, $priority, false)
             ->setCommnet($comment);
        //$this->data = $this->_prepareTask($user_id, $title, $date, $time, $order, $priority, $future, $checktime);
        return $this;
    }
    
    public function setTime($time, $timeEnd=null){
        if ($this->data[$this->alias]['future']){
            $time = null;
        }
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
    
    public function setMove(){
        $this->_move = true;
        return $this;
    }

    public function setFuture($future) {
        $this->data[$this->alias]['future'] = $future;
        return $this;
    }

    public function setTitle($title, $priority = null, $checkTime = true) {
        $this->data[$this->alias]['title'] = $title;
        if($priority != null){
            $this->data[$this->alias]['priority'] = $priority;
        }else{
            if (strpos($title, '!') === false) {
                $this->data[$this->alias]['priority'] = 0;
            } else {
                $this->data[$this->alias]['priority'] = 1;
            }
        }
        if($checkTime){
            $pattern = '/^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?/';
            preg_match($pattern, $title, $matches);
            if( isset($matches[0]) ){
                $this->data[$this->alias]['time'] = $matches[0].':00';
                $this->data[$this->alias]['title'] = substr($title,5);
            }
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

    public function setDelete($delete) {
        $this->data[$this->alias]['deleted'] = $delete;
        return $this;
    }
    
    public function checkPositionWithTime($position, $date = null){
    	if (!$this->data[$this->alias]['time']){
            return true;
        }
        $user_id = $this->data[$this->alias]['user_id'];
    	$id = $this->data[$this->alias]['id'];
    	if (!$date) {
            $date =  $this->data[$this->alias]['date']; 
    	}
    	$this->contain();
        $tasksWithTime = $this->find('all', 
                                            array(
                                                'conditions' => array(
                                                    "not" => array(
                                                        "Task.time" => null, 
                                                        'Task.deleted' => 1,
                                            			'Task.id' => $id
                                                    ), 
                                                    "Task.user_id" => $user_id, 
                                                    "Task.date" => $date
                                                ), 
                                                'order' => array(
                                                    'Task.time' => 'ASC', 
                                                    'Task.order' => 'ASC'
                                                ),
                                                'fields' => array('id', 'order', 'time')
                                            ));
        
    	if(isset($tasksWithTime[0][$this->alias])){
            foreach ($tasksWithTime as $task){
        	$tasks[$task['Task']['order']] = strtotime($task['Task']['time']);
            }
    	}
        $task = strtotime($this->data[$this->alias]['time']);
        if(isset($tasks[$position]) and !$tasks[$position] == $task){
            return false;
        }
        $tasks[$position] = $task;
        ksort($tasks);
        //debug($tasks);die;
        foreach ( $tasks as $k => $v ) {
            $next = next($tasks);
            if ( $next and $v > $next) {
                return false;
            }
        }
        return true;
    }

    public function getAllExpired($user_id) {
        $this->contain('Tag');
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 0, 
                                'Task.date <' => date('Y-m-d'),
                                'Task.deleted' => 0
                            ),
                            'fields' => $this->_taskFields,
                        ));
    }
    
    public function getAllOverdue($user_id) {
        $result = array();
        $this->contain('Tag');
        $tasks = $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 0, 
                                'Task.date <' => date('Y-m-d'),
                                'Task.deleted' => 0,
                                'not' => array('Task.date'=> null,
                                               'Task.date'=> '0000-00-00'
                                              )
                            ),
                            'fields' => $this->_taskFields,
                        ));
        foreach($tasks as $item){
            $result[$item['Task']['date']][] = $item;
        }
        return $result;
    }
    
    public function getAllCompleted($user_id) {
        $result = array();
        $this->contain('Tag');
        $tasks = $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.done' => 1,
                                'Task.deleted' => 0, 
                                'not' => array('Task.date'=> null,
                                               'Task.date'=> '0000-00-00'
                                              )
                                //'Task.date <' => CakeTime::format('Y-m-d', time())
                            ),
                            'fields' => $this->_taskFields,
                        ));
        foreach($tasks as $item){
            $result[$item['Task']['date']][] = $item;
        }
        return $result;
    }

    public function getAllDeleted($user_id) {
        $result = array();
        $this->contain('Tag');
        $tasks = $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'DESC', 
                                'Task.modified' => 'DESC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.deleted' => 1, 
                                //'not' => array('Task.date'=> null,
                                //               'Task.date'=> '0000-00-00'
                                //              )
                                //'Task.date <' => CakeTime::format('Y-m-d', time())
                            ),
                            'fields' => $this->_taskFields,
                        ));
        foreach($tasks as $item){
            $result[$item['Task']['date']][] = $item;
        }
        return $result;
    }
    
    public function getAllFuture($user_id) {
        $this->contain('Tag');
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'ASC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.future' => 1,
                                'Task.deleted' => 0
                            ),
                            'fields' => $this->_taskFields,
                        ));
    }

    public function getDays($user_id, $from, $to, $arrDays = null) {
        $days = array();
        do {
            $days[] = $from;
            $from = date("Y-m-d", strtotime($from . "+1 day"));
        } while($from <= $to);
        if(is_array($arrDays)){
            sort($arrDays);
            $days = array_merge($days, $arrDays);
            $days = array_unique($days);
        }
        $this->contain('Tag');
        $result = $this->find('all', 
                            array(
                                'order' => array(
                                    'Task.date' => 'ASC', 
                                    'Task.order' => 'ASC'
                                ), 
                                'conditions' => array(
                                    'Task.user_id' => $user_id, 
                                    'Task.date' => $days,
                                    'Task.deleted' => 0,
                                    'not' => array('Task.date'=> null,
                                               'Task.date'=> '0000-00-00'
                                              )
                                ),
                                //'fields' => $this->_taskFields,
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
        if ( !array_key_exists('day', $config) or !in_array($date, $config['day']) ) {
            $config['day'][] = $date;
            $this->User->setConfig($user_id, $config);
        }
    }

    public function getTasksForDay($user_id, $date) {
        $this->_setDayToConfig($user_id, $date);
        $this->contain('Tag');
        return $this->find('all', 
                        array(
                            'order' => array(
                                'Task.date' => 'ASC', 
                                'Task.order' => 'ASC'
                            ), 
                            'conditions' => array(
                                'Task.user_id' => $user_id, 
                                'Task.date' => $date,
                                'Task.deleted' => 0
                            ),
                            'fields' => $this->_taskFields,
                        ));
    }

    //TODO Need to comment each function
    /**
     * 
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function deleteDayFromConfig($user_id, $date) {
        $config = $this->User->getConfig($user_id);
        if(array_key_exists('day', $config)){
            $key = array_search($date, $config['day']);
            if($key){
                unset($config['day'][$key]);
                return $this->User->setConfig($user_id, $config);
            }    
        }
        return true;
    }

    //TODO Maybe this function move to another model, for example to Day?
    public function getWeekDay($index){
        $weekday = array(
                        'Sunday' => __d('tasks', 'Sunday'),
                        'Monday' => __d('tasks', 'Monday'),
                        'Tuesday' => __d('tasks', 'Tuesday'),
                        'Wednesday' => __d('tasks', 'Wednesday'),
                        'Thursday' => __d('tasks', 'Thursday'),
                        'Friday' => __d('tasks', 'Friday'),
                        'Saturday' => __d('tasks', 'Saturday')
                        );
        if(array_key_exists($index, $weekday)){
            return $weekday[$index];
        }                        
        return false; 
    }
    public function saveTask(){
            $save = $this->save();
            if (is_array($save)){
                foreach($save[$this->alias] as $key => $value){
                    if(!in_array($key, $this->_taskFieldsSave)){
                        unset($save[$this->alias][$key]);
                    }
                }
                return $save;
            }
            else{
                return false;
            }
    }
    
    //----------------------------------------------------
   

}
