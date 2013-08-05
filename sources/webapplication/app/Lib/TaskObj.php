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
        $this->time = isset($task['time']) ? $task['time'] : null;
        $this->timeend = isset($task['timeend']) ? $task['timeend'] : null;
        $this->priority = isset($task['priority']) ? (int)$task['priority'] : 0;
        $this->repeatid = isset($task['repeatid']) ? (int)$task['repeatid'] : null;
        $this->continued = isset($task['continued']) ? (int)$task['continued'] : 0;
        $this->future = isset($task['future']) ? (int)$task['future'] : 0;
        $this->deleted = isset($task['deleted']) ? (int)$task['deleted'] : 0;
        $this->done = isset($task['done']) ? (int)$task['done'] : 0;
        $this->datedone = isset($task['datedone']) ? $task['datedone'] : null;
        $this->comment = isset($task['comment']) ? $task['comment'] : null;
        $this->tags = (isset($task['tags']) && is_array($task['tags'])) ? $task['tags'] : array();
    }
} 