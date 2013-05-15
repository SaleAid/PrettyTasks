<?php
App::uses('AppModel', 'Model');
App::uses('DateList', 'Model');
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
        //'order' => array(
//            'numeric' => array(
//                'rule' => array(
//                    'numeric'
//                )
//            )
//        ),
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
        'continued' => array(
            'numeric' => array(
                'rule' => array(
                    'boolean'
                )
            )
        ),
        'repeatid' => array(
            'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            ),
        	//'uuid'
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
    
    public $_taskFields = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'future', 'deleted', 'done' ,'datedone', 'continued', 'repeatid', 'comment');
    
    private $_taskFieldsSave = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'future', 'deleted', 'done' ,'datedone', 'continued', 'repeatid', 'comment', 'tags');
    
    public function getFields(){
        return $this->_taskFields;
    }
    
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
    
    public function getTasksById($tasksId) {
        $this->contain('Tag.name');
        return $this->find('all', 
                        array(
                            'conditions' => array(
                                'Task.id' => $tasksId, 
                            ),
                            'fields' => $this->_taskFields,
                        ));
    }

    public function isOwner($task_id, $user_id) {
        $this->contain('Tag.name');
        $task = $this->findByIdAndUser_id($task_id, $user_id);
        if ($task) {
            $this->_originData = $task;
            $this->set($task);
            return $task;
        }
        return false;
    }

    public function afterSave($created){
        if ($this->data[$this->alias]['date']){
            $list = $this->data[$this->alias]['date'];
            $toFirst = false;
        } else {
            $list = 'planned';
            $toFirst = true;
        }
        if( $created ){
            $DateList = new DateList($this->data[$this->alias]['user_id'], $list);
            if(empty($this->data[$this->alias]['time'])){
                $DateList->addToList($this->id, $toFirst);    
            }else{
                $DateList->addToListWithTime($this->id, $this->data[$this->alias]['time']);    
            }
        } else { 
        
            if ($this->_isDeleted()){
                $DateList = new DateList($this->data[$this->alias]['user_id'], $list);
                $DateList->removeFromList($this->data[$this->alias]['id']);    
            }
            //if day changed
            if ($this->_isDraggedOnDay()){
                $originDate = empty($this->_originData[$this->alias]['date']) ? 'planned' : $this->_originData[$this->alias]['date'];
                $originDateList = new DateList($this->data[$this->alias]['user_id'], $originDate);
                if($originDateList->removeFromList($this->_originData[$this->alias]['id'])){
                    //add to new list
                    $DateList = new DateList($this->data[$this->alias]['user_id'], $list);
                    if(empty($this->data[$this->alias]['time'])){
                        $DateList->addToList($this->id, true);    
                    }else{
                        $DateList->addToListWithTime($this->id, $this->data[$this->alias]['time'], true);    
                    }    
                }
            }
            //if only time chenged and not nulls
            if ($this->_isTimeChanged() and !$this->_isDraggedOnDay()){
                $DateList = new DateList($this->data[$this->alias]['user_id'], $list);
                if($DateList->removeFromList($this->data[$this->alias]['id'])){
                    $DateList->addToListWithTime($this->id, $this->data[$this->alias]['time'], true);
                }
            }
        }
        
    }
    
    public function createTask($user_id, $title, $date = null, $time = null, $priority = null, $future = null, $clone = null) {
        $this->data = $this->_prepareTask($user_id, $title, $date, $time, $priority, $future);
        
        if($clone){
            unset($this->id);
        }
        return $this;
    }

    private function _prepareTask($user_id, $title, $date = null, $time = null, $priority = null, $future = null) {
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
        if (!$date) {
            $future = 1; 
            $time = null;
        }else{
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

    private function _isTitleChanged() {
        if ( !isset($this->_originData[$this->alias]['title']) || $this->_originData[$this->alias]['title'] != $this->data[$this->alias]['title'] ) {
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

    private function _isDeleted() {
        if( isset($this->data[$this->alias]['deleted']) && $this->data[$this->alias]['deleted'] ){
            return true;
        }
        return false;
    }
    
    private function _isTimeChanged() {
        if(!empty($this->data[$this->alias]['time']) && CakeTime::format('H:i', $this->_originData[$this->alias]['time']) != CakeTime::format('H:i', $this->data[$this->alias]['time'])){
            return true;
        }
        return false;
    }
    
    public function beforeSave() {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        //check and add tags
        if( $this->_isTitleChanged() ){
            $this->_checkTags('title');
        }
        return true;
    }

    public function setEdit($title, $priority, $continued=0, $comment=null, $date=null, $time=null, $timeEnd=null, $done=null){
        $this->setDate($date)
             ->setTime($time, $timeEnd)
             ->setDone($done)
             ->setTitle($title, $priority, false)
             ->setCommnet($comment)
             ->setContinued($continued);
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
        if ( !$date ) {
            $this->setFuture(1);
        } else {
            $this->setFuture(0);
        }
        $this->data[$this->alias]['date'] = $date;
        return $this;
    }

    
    public function setFuture($future) {
        $this->data[$this->alias]['future'] = $future;
        return $this;
    }
    public function setContinued($continued) {
        $this->data[$this->alias]['continued'] = $continued;
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
                $this->data[$this->alias]['title'] = substr($title, 5);
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
    
    public function setDayToConfig($user_id, $date) {
        $config = $this->User->getConfig($user_id);
        if ( !array_key_exists('day', $config) or !in_array($date, $config['day']) ) {
            $config['day'][] = $date;
            $this->User->setConfig($user_id, $config);
        }
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
            if($key !== false){
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
                unset($save['Tag']);
                return $save;
            }
            else{
                return false;
            }
    }
    
    public function repeated($recur, $task_id = null){
        $taskDate = $this->data[$this->alias]['date'];
        $days = $this->_repeatedDays($recur, $taskDate);
        if($days){
            $repeatid = $this->data[$this->alias]['id'];
            $repeatedTask = $this->data[$this->alias];
            
            $repeatedTask['repeatid'] = $this->data[$this->alias]['id'];
            //$repeatedTask['order'] = 1;
            foreach($days as $day){
                unset($this->_originData); 
                unset($this->data);
                unset($this->id);
                $this->createTask(  $repeatedTask['user_id'],
                                    $repeatedTask['title'],
                                    $day,
                                    $repeatedTask['time'],
                                    null,
                                    $repeatedTask['priority'],
                                    $repeatedTask['future'],
                                    null
                );
                $this->data[$this->alias]['repeatid'] = $repeatid;
                $this->save();
                if($this->validationErrors)
                    pr($this->validationErrors);
            }
        }
        return true;
    }
    
    protected function _repeatedDays($recur, $beginDate){
        /*
            recur:RRULE:FREQ=DAILY;INTERVAL=2
            recur:RRULE:FREQ=WEEKLY;BYDAY=SU,TU,TH
            recur:RRULE:FREQ=WEEKLY;INTERVAL=4;BYDAY=SU
            recur:RRULE:FREQ=MONTHLY;BYDAY=1SU
            recur:RRULE:FREQ=MONTHLY + day task
            recur:RRULE:FREQ=YEARLY;INTERVAL=5
            recur:RRULE:FREQ=YEARLY;UNTIL=20300303;INTERVAL=5
            recur:RRULE:FREQ=YEARLY;COUNT=5;INTERVAL=8
        */
        $days = array();
        $week = array('sun','mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
        $countRepeated = Configure::read('Repeated.MaxCount');
        $endDateRepeated = null;
        $begin = new DateTime( $beginDate );
        extract($recur);
        
        if( !isset($freq) or !isset($interval)){
            return false;
        }
        $interval = $interval * 1;
        if( isset($until) ){
            switch($until){
                case 'after':
                    if(isset($count) and Validation::naturalNumber($count) and $count <= $countRepeated){
                        $countRepeated = $count;
                    }
                break;
                case 'date':
                    if( isset($date) and Validation::date($date)){
                        $endDateRepeated = new DateTime($date);
                    }
                break;
            }
        }
        switch($freq){
                case 'dally': 
                    $begin->modify("+$interval day");
                    while($countRepeated > 0 and (!$endDateRepeated or $endDateRepeated >= $begin) ){
                        $days[] = $begin->format('Y-m-d');
                        $begin->modify("+$interval day");
                        $countRepeated--;
                    }
                break;
                case 'weekly':
                    if( isset($byDays) and is_array($byDays)){
                      foreach($byDays as $k => $v){
                          if(!in_array($v, $week)){
                                unset($byDays[$k]);    
                          }    
                      }
                      array_unique($byDays);
	                }
                    $begin->modify("+$interval week");
                    while($countRepeated > 0 and count($days) < Configure::read('Repeated.MaxCount') 
                           and (!$endDateRepeated or $endDateRepeated >= $begin)) {
		                if(isset($byDays)){
                            foreach($byDays as $v){
                                $days[] = $begin->format('Y-m-d');
                                $begin->modify("$v this week");
                            }
                            $begin->modify("+$interval week");
                            $countRepeated--;    
                        } else {
                            $days[] = $begin->format('Y-m-d');
                            $begin->modify("+$interval week");
                            $countRepeated--;
                        }
                    }
                break;
                case 'monthly':
                    $begin->modify("+$interval month"); 
                    while($countRepeated > 0 and (!$endDateRepeated or $endDateRepeated >= $begin)){
                        $days[] = $begin->format('Y-m-d');
                        $begin->modify("+$interval month");
                        $countRepeated--;
                    }
                break;
                case 'yearly':
                    $begin->modify("+$interval year"); 
                    while($countRepeated > 0 and (!$endDateRepeated or $endDateRepeated >= $begin)){
                        $days[] = $begin->format('Y-m-d');
                        $begin->modify("+$interval year");
                        $countRepeated--;
                    }
                break;
            }
        sort($days);
        $days = array_slice($days, 0, Configure::read('Repeated.MaxCount')); 
        return $days;
    }
    
}
