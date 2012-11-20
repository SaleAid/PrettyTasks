<?php
//App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 * @property User $User
 */
class Task extends ApiV1AppModel {
    
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
            )
        ), 
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ), 
        'title' => array(
            'notempty' => array(
                'rule' => array(
                    'notempty'
                ),
                'message' => 'Поле должно быть заполнено' 
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
    
    public function comparisonTime($data) {
        if ($data['timeend'] > $this->data[$this->alias]['time']) {
            return true;
        }
        return false;
    }
    
    //------------------------------ 

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

    //------------------------------ lists 
    public function getCompleted($user_id, $count = 50, $page = 1) {
        $this->contain();
        $conditions = array(
                        'Task.user_id' => $user_id,
                        'Task.done' => 1,
                        'Task.deleted' => 0
                    );
        $order =  array(
                    'Task.date' => 'DESC', 
                    'Task.order' => 'ASC'
                );
                
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions,
                            'fields' => $this->_taskFields,
                            'limit' => $count,
                            'page' => $page
                        ));
    }
    
    public function getExpired($user_id, $count = 50, $page = 1) {
        $this->contain();
        $conditions = array(
                        'Task.user_id' => $user_id, 
                        'Task.done' => 0, 
                        'Task.date <' => date('Y-m-d'),
                        'Task.deleted' => 0
                    );
        $order =  array(
                    'Task.date' => 'DESC', 
                    'Task.order' => 'ASC'
                );
                
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions,
                            'fields' => $this->_taskFields,
                            'limit' => $count,
                            'page' => $page
                        ));
    }
    
    public function getFuture($user_id, $count = 50, $page = 1) {
        $this->contain();
        $conditions = array(
                        'Task.user_id' => $user_id, 
                        'Task.future' => 1,
                        'Task.deleted' => 0
                    );
        $order =  array(
                    'Task.date' => 'DESC', 
                    'Task.order' => 'ASC'
                );
                
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions,
                            'fields' => $this->_taskFields,
                        ));
    }

      public function getDeleted($user_id, $count = 50, $page = 1) {
        $this->contain();
        $conditions = array(
                        'Task.user_id' => $user_id, 
                        'Task.deleted' => 1, 
                    );
        $order =  array(
                        'Task.date' => 'DESC', 
                        'Task.modified' => 'DESC'
                    );
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions,
                            'fields' => $this->_taskFields,
                        ));
    }
   
    public function getForDate($user_id, $date, $count = 50, $page = 1) {
        $this->contain();
        $conditions = array(
                        'Task.user_id' => $user_id, 
                        'Task.date' => $date,
                        'Task.deleted' => 0
                    );
        $order =  array(
                        'Task.date' => 'ASC', 
                        'Task.order' => 'ASC'
                    );
                    
        return $this->find('all', 
                        array(
                            'order' => $order, 
                            'conditions' => $conditions,
                            'fields' => $this->_taskFields,
                        ));
    }


//---------------------------------------------------------------------- end code 

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
        $this->contain();
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
                                'fields' => $this->_taskFields,
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

    

    //TODO Need to comment each function
    /**
     * 
     * Enter description here ...
     * @param unknown_type $user_id
     * @param unknown_type $date
     */
    public function deleteDayFromConfig($user_id, $date) {
        $config = array();
        $config = $this->User->getConfig($user_id);
        unset($config['day'][array_search($date, $config['day'])]);
        return $this->User->setConfig($user_id, $config);
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
                    if(!in_array($key, $this->_taskFields)){
                        unset($save[$this->alias][$key]);
                    }
                }
                return $save;
            }
            else{
                return false;
            }
    }

}
