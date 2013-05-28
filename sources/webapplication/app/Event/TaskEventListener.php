 <?php
App::uses('TagList', 'Model');
App::uses('DateList', 'Model');
App::uses('PlannedList', 'Model');
App::uses('CakeEventListener', 'Event');
 
class TaskEventListener implements CakeEventListener {
 
  public function implementedEvents() {
    return array(
      'Model.Task.afterSetDeleted' => 'eventAfterSetDeletedTask',
      'Model.Task.afterCreate' => 'eventAfterCreateTask', 
      'Model.Task.afterMoveToDate' => 'eventAfterMoveToDateTask',
      'Model.Task.afterChangeTime' => 'eventAfterChangeTimeTask',
    );
  }
 
  public function eventAfterSetDeletedTask($event) {
    $ordered = ClassRegistry::init('Ordered');
    $options['conditions'] = array(
                'Ordered.model' => $event->subject->alias,
                'Ordered.foreign_key' => $event->subject->data[$event->subject->alias]['id'],
                'Ordered.user_id' => $event->subject->data[$event->subject->alias]['user_id'],
    );
    $options['contain'] = array();
    $ordereds = $ordered->find('all', $options);
    foreach($ordereds as $item){
        $ordered->set($item);
        $ordered->delete($item['Ordered']['id']);
    }
  }
  
  public function eventAfterCreateTask($event){
    $task = $event->subject->data[$event->subject->alias];
    if($task['future']){
        $PlannedList = new PlannedList($task['user_id'], 'planned');
        $PlannedList->addToList($task['id'], true);    
    }else{
        $DateList = new DateList($task['user_id'], $task['date']);
        if($task['time']){
            $DateList->addToListWithTime($task['id'], $task['time']);    
        }else{
            $DateList->addToList($task['id'], $task['time']);
        }
    }
  }
  
  public function eventAfterMoveToDateTask($event){
    $task = $event->subject->data[$event->subject->alias];
    $originTask = $event->data['originTask'];
    
    if($originTask['future']){
        $originList = new PlannedList($originTask['user_id'], 'planned');
    } else {
        $originList = new DateList($originTask['user_id'], $originTask['date']);
    }
    if($originList->removeFromList($originTask['id'])){
        //add to new list
         if($task['future']){
            $PlannedList = new PlannedList($task['user_id'], 'planned');
            $PlannedList->addToList($task['id'], true);    
        }else{
            $DateList = new DateList($task['user_id'], $task['date']);
            if($task['time']){
                $DateList->addToListWithTime($task['id'], $task['time']);    
            }else{
                $DateList->addToList($task['id'], $task['time']);
            }
        }   
    }
  }
  
  public function eventAfterChangeTimeTask($event){
    $task = $event->subject->data[$event->subject->alias];
    $DateList = new DateList($task['user_id'], $task['date']);
    if($DateList->removeFromList($task['id'])){
        $DateList->addToListWithTime($task['id'], $task['time'], true);
    }
  }
 
}