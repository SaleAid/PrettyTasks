<?php 

class TaskObj {
    
    public $id = null;
    public $title = null;
    public $date= null;
    public $time = null;
    public $timeend = null;
    public $priority = null;
    public $repeatid = null;
    public $continued = null;
    public $future = null;
    public $deleted = null;
    public $done = null;
    public $datedone = null;
    public $comment = null;
    public $tags = array();
    public $_explicitType='Task';
    
    public function __construct(array $task) {
        
        $this->id = $task['id'];
        $this->title = $task['title'];
        $this->date = $task['date'];
        $this->time = $task['time'];
        $this->timeend = $task['timeend'];
        $this->priority = $task['priority'];
        $this->repeatid = $task['repeatid'];
        $this->continued = $task['continued'];
        $this->future = $task['future'];
        $this->deleted = $task['deleted'];
        $this->done = $task['done'];
        $this->datedone = $task['datedone'];
        $this->comment = $task['comment'];
        $this->tags = is_array($task['tags']) ? $task['tags']: array();
    }
} 