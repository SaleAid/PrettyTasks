<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('TaskEventListener', 'Event');
App::uses('AppModel', 'Model');
App::uses('TaskObj', 'Lib');
App::uses('CakeTime', 'Utility');
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
    
    /**
     * 
     * @var unknown_type
     */
    private $_originData = array();
    
    /**
     * 
     * @var unknown_type
     */
    public $_taskFields = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'future', 'deleted', 'done' ,'datedone', 'continued', 'repeatid', 'comment');
    
    /**
     * 
     * @var unknown_type
     */
    private $_taskFieldsSave = array('id', 'title', 'date', 'time', 'timeend', 'priority', 'future', 'deleted', 'done' ,'datedone', 'continued', 'repeatid', 'comment', 'tags');
    
    /**
     * 
     * @var unknown_type
     */
    public $updateTask = false;
    /**
     * 
     * @return unknown_type
     */
    public function getFields(){
        return $this->_taskFields;
    }
    
    /**
     * 
     * @param unknown_type $data
     * @return boolean
     */
    public function comparisonTime($data) {
        if ($data['timeend'] > $this->data[$this->alias]['time']) {
            return true;
        }
        return false;
    }
    
    //------------------------------
    /**
     * 
     * @param unknown_type $task_id
     * @return unknown|boolean
     */
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
    
    /**
     * 
     * @param unknown_type $task_id
     * @param unknown_type $user_id
     * @return unknown|boolean
     */
    public function isOwner($task_id, $user_id) {
        $this->contain(array('Tag.name', 'Tag.id'));
        $task = $this->findByIdAndUser_id($task_id, $user_id);
        if ($task) {
            $this->_originData = $task; 
            $this->set($task);
            return new TaskObj($task['Task']);
        }
        return false;
    }
    
    /**
     * 
     * @param unknown_type $id
     * @param unknown_type $table
     * @param unknown_type $ds
     */
    public function __construct($id = false, $table = null, $ds = null) {
         parent::__construct($id, $table, $ds);
         $this->getEventManager()->attach(new TaskEventListener());
    }
    
    /**
     * (non-PHPdoc)
     * @see Model::afterSave()
     */
    public function afterSave($created, $options = array()){
        //$this->getEventManager()->attach(new TaskEventListener());
        //
        if( $created ){
            $this->getEventManager()->dispatch(new CakeEvent('Model.Task.afterCreate', $this));
        } else { 
            //delete task form lists
            if ($this->_isDeleted()){
                $this->getEventManager()->dispatch(new CakeEvent('Model.Task.afterSetDeleted', $this));    
            }
            //if day changed
            if ($this->_isDraggedOnDay() || $this->updateTask){
                $this->getEventManager()->dispatch(new CakeEvent('Model.Task.afterMoveToDate', $this, array('originTask' => $this->_originData[$this->alias])));
            }
            //if only time changed and not null
            if ($this->_isTimeChanged() and !$this->_isDraggedOnDay()){
                $this->getEventManager()->dispatch(new CakeEvent('Model.Task.afterChangeTime', $this));    
            }
        }
        
    }
    
    /**
     * 
     * @return boolean
     */
    public function createTasksForNewUser($user_id, $lang){
        $date = date("Y-m-d");
        $tasks = Configure::read('NewUser.Tasks.'.$lang);
        if($tasks){
            foreach($tasks as $task){
                $this->create();
                $this->createTask($user_id, $task, $date)->save();
            }
        }
    }
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $title
     * @param unknown_type $date
     * @param unknown_type $time
     * @param unknown_type $priority
     * @param unknown_type $future
     * @param unknown_type $clone
     * @return Task
     */
    public function createTask($user_id, $title, $date = null, $time = null, $timeend = null, $priority = null, $future = null, $clone = null) {
        $this->data = $this->_prepareTask($user_id, $title, $date, $time, $timeend, $priority, $future);
        if($clone){
            unset($this->id);
            $this->updateTask = true;
        }
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $title
     * @param unknown_type $date
     * @param unknown_type $time
     * @param unknown_type $priority
     * @param unknown_type $future
     * @return Ambigous <string, number>
     */
    private function _prepareTask($user_id, $title, $date = null, $time = null, $timeend = null, $priority = null, $future = null) {
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
    
    /**
     * 
     * @return boolean
     */
    private function _isTitleChanged() {
        if ( !isset($this->_originData[$this->alias]['title']) || $this->_originData[$this->alias]['title'] != $this->data[$this->alias]['title'] ) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @return boolean
     */
    private function _isDraggedOnDay() {
        if ($this->_originData[$this->alias]['date'] != $this->data[$this->alias]['date'] && isset($this->data[$this->alias]['id'])) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @return boolean
     */
    private function _isDeleted() {
        if( isset($this->data[$this->alias]['deleted']) && $this->data[$this->alias]['deleted'] ){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @return boolean
     */
    private function _isTimeChanged() {
        if(!empty($this->data[$this->alias]['time']) && CakeTime::format('H:i', $this->_originData[$this->alias]['time']) != CakeTime::format('H:i', $this->data[$this->alias]['time'])){
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @return boolean
     */
    private function _isRecovered(){
        if( isset($this->data[$this->alias]['deleted']) && !$this->data[$this->alias]['deleted'] && $this->_originData[$this->alias]['deleted']){
            return true;
        }
        return false;
    }
    
    /**
     * (non-PHPdoc)
     * @see Model::beforeSave()
     */
    public function beforeSave($options = array()) {
        $this->data[$this->alias]['modified'] = date("Y-m-d H:i:s");
        //check and add tags
        if( $this->_isTitleChanged() || $this->_isRecovered() || $this->updateTask ){
            $this->_checkTags('title');
        }
        
        return true;
    }
    
    /**
     * 
     * @param unknown_type $title
     * @param unknown_type $priority
     * @param unknown_type $continued
     * @param unknown_type $comment
     * @param unknown_type $date
     * @param unknown_type $time
     * @param unknown_type $timeEnd
     * @param unknown_type $done
     * @return Task
     */
    public function setEdit($title, $priority, $continued=0, $comment=null, $date=null, $time=null, $timeEnd=null, $done=null){
        $this->setDate($date)
             ->setTime($time, $timeEnd)
             ->setDone($done)
             ->setTitle($title, $priority, false)
             ->setCommnet($comment)
             ->setContinued($continued);
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $time
     * @param unknown_type $timeEnd
     * @return Task
     */
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
    
    /**
     * 
     * @param unknown_type $date
     * @return Task
     */
    public function setDate($date) {
        if ( !$date ) {
            $this->setFuture(1);
        } else {
            $this->setFuture(0);
        }
        $this->data[$this->alias]['date'] = $date;
        return $this;
    }

    /**
     * 
     * @param unknown_type $future
     * @return Task
     */
    public function setFuture($future) {
        $this->data[$this->alias]['future'] = $future;
        if($future)
            $this->data[$this->alias]['time'] = $this->data[$this->alias]['timeend'] = null;
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $continued
     * @return Task
     */
    public function setContinued($continued) {
        $this->data[$this->alias]['continued'] = $continued;
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $title
     * @param unknown_type $priority
     * @param unknown_type $checkTime
     * @return Task
     */
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
    
    /**
     * 
     * @param unknown_type $comment
     * @return Task
     */
    public function setCommnet($comment) {
        $this->data[$this->alias]['comment'] = $comment;
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $done
     * @return Task
     */
    public function setDone($done) {
        $this->data[$this->alias]['done'] = $done;
        $this->data[$this->alias]['datedone'] = null;
        if($done){
            $this->data[$this->alias]['datedone'] = date("Y-m-d H:i:s");
        }
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $delete
     * @return Task
     */
    public function setDelete($delete) {
        $this->data[$this->alias]['deleted'] = $delete;
        return $this;
    }
    
    /**
     * 
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function setDayToConfig($user_id, $date) {
        $days = $this->User->Setting->getValue('days', $user_id);
        
        if (empty($days) or !in_array($date, $days) ) {
            $days[] = $date;
            $this->User->Setting->setValue('days', $days, $user_id);
        }
    }

    /**
     * 
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function deleteDayFromConfig($user_id, $date) {
        $days = (array)$this->User->Setting->getValue('days', $user_id);
        $key = array_search($date, $days);
        if($key !== false){
            unset($days[$key]);
            return  $this->User->Setting->setValue('days', $days, $user_id);
        }    
        return true;
    }

    //TODO Maybe this function move to another model, for example to Day?
    /**
     * 
     * @param unknown_type $index
     * @return Ambigous <Ambigous <translated, void>, Ambigous <translated, void, string, mixed, string, unknown>>|boolean
     */
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
    
    
    
    /**
     * 
     * @return Ambigous <mixed, boolean, multitype:>|boolean
     */
    public function saveTask(){
            $save = $this->save();
            if (is_array($save)){
                foreach($save[$this->alias] as $key => $value){
                    if(!in_array($key, $this->_taskFieldsSave)){
                        unset($save[$this->alias][$key]);
                    }
                }
                //unset($save['Tag']);
                return new TaskObj($save['Task']);
            }
            else{
                return false;
            }
    }
    
    /**
     * 
     * @param unknown_type $recur
     * @param unknown_type $task_id
     * @return boolean
     */
    public function repeated($recur, $task_id = null){
        return true;
        $taskDate = $this->data[$this->alias]['date'];
        $days = $this->_repeatedDays($recur, $taskDate);
        if($days){
            $repeatid = $this->data[$this->alias]['id'];
            $repeatedTask = $this->data[$this->alias];
            
            $repeatedTask['repeatid'] = $this->data[$this->alias]['id'];
            //$repeatedTask['order'] = 1;
            foreach($days as $day){
                //pr($day);
                unset($this->_originData); 
                unset($this->data);
                unset($this->id);
                $this->createTask(  $repeatedTask['user_id'],
                                    $repeatedTask['title'],
                                    $day,
                                    $repeatedTask['time'],
                                    $repeatedTask['priority'],
                                    $repeatedTask['future'],
                                    null
                );
                $this->data[$this->alias]['repeatid'] = $repeatid;
                //pr($this->data);
                $this->save();
                if($this->validationErrors)
                    pr($this->validationErrors);
            }
        }
        return true;
    }
    
    /**
     * 
     * @param unknown_type $recur
     * @param unknown_type $beginDate
     * @return boolean|multitype:
     */
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
    
    public function update( $data ){
    	
    	if ( isset($data['title']) ) {
            $this->setTitle($data['title'], null);
	    }
        if ( isset($data['priority']) ) {
            if($data['priority'] != null){
                $this->data[$this->alias]['priority'] = (int)$data['priority'];
            }
	    }
        //check future ...
        if( isset($data['date']) ){
            $this->setDate($data['date']);
        }
        
        //check  delete ...
        if( isset($data['deleted'])){
            $this->setDelete($data['deleted']);
         }
        
        //check  done
        if( isset($data['done']) ){
            $this->setDone($data['done']);
        }
        return $this->saveTask();
    }
    
}
