<?php
App::uses('DateList', 'Model');
App::uses('PlannedList', 'Model');
class MigrationTasksTask extends Shell {
    
    public $uses = array('Task');
    
    public function execute() {
        $this->createTasksOrders();
    }
    
    protected function createTasksOrders(){
        $this->Task->contain();
        $tasks = $this->Task->find('all', array(
                'order' => array(
                        'Task.user_id' => 'ASC',
                        'Task.date' => 'ASC',
                        'Task.order' => 'ASC',
                ),
            )
        );
        //pr($tasks);die;
        foreach($tasks as $task){
            $this->Task->updateTask = true;
            $originTask = $this->Task->isOwner($task['Task']['id'], $task['Task']['user_id']);
            if ($originTask) {
                if (!$originTask->future) {
                    $taskObj = $this->Task->setTitle($task['Task']['title'])->saveTask();
                }else {
                    $taskObj = $this->Task->setTitle($task['Task']['title'], null, false)->saveTask();
                }
            }
            
            if($task['Task']['future']){
                $PlannedList = new PlannedList($task['Task']['user_id'], 'planned');
                $PlannedList->addToList($task['Task']['id'], true);    
            }else{
                $DateList = new DateList($task['Task']['user_id'], $task['Task']['date']);
                if($task['Task']['time']){
                    $DateList->addToListWithTime($task['Task']['id'], $task['Task']['time']);    
                }else{
                    $DateList->addToList($task['Task']['id']);
                }
            }
            
           
        }
        $this->out(print_r('ALL done.', true));
    }
}