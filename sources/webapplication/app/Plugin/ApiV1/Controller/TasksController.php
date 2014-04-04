<?php

App::uses('CakeTime', 'Utility');
App::uses('ApiV1AppController', 'ApiV1.Controller');
App::uses('TaskObj', 'Lib');
App::uses('TasksListObj', 'Lib');
App::uses('MessageObj', 'Lib');
App::uses('DateList', 'Model');
App::uses('ManyDateList', 'Model');
App::uses('PlannedList', 'Model');
App::uses('OverdueList', 'Model');
App::uses('CompletedList', 'Model');
App::uses('DeletedList', 'Model');
App::uses('ContinuedList', 'Model');
App::uses('TagList', 'Model');
App::uses('Task', 'Model');
App::uses('TaskEventListener', 'Event');
App::uses('Validation', 'Utility');

/**
 * Clients Controller
 *
 * @property Client $Client
 * @property Task $Task
 */
class TasksController extends ApiV1AppController {
	
	public $uses = array('Task');
    
    public function lists(){
        if ( !$this->request->is('get') ) {
            throw new ForbiddenException();
        }
        if( isset($this->request->query['type']) && !empty($this->request->query['type']) ){
            $result = $tasks = array();
            //type of requested list. Values: day, expired, future, deleted, completed.
            $type = $this->request->query['type'];
            $date = isset($this->request->query['date']) ? $this->request->query['date'] : null;
            $page = isset($this->request->query['page']) ? $this->request->data['page'] : 1;
            if (!is_numeric($page) || intval($page) < 1) {
                 $page = 1;
            }
            $count = Configure::read("Tasks.Lists." .ucfirst($this->request->query['type']) .".limit");
            if($count < 1){
                $count = Configure::read("Tasks.Lists.Default.limit");
            }
            $user_id = $this->OAuth->user('id');
        	switch ( $type ) {
                case 'completed' :
                    {
                        $CompletedList = new CompletedList($user_id);
                        $result['data'] = new TasksListObj('defined', 'completed', $CompletedList->getItems($count, $page), $count);
                        break;
                    }
                case 'expired' :
                    {
                        $date = CakeTime::format('Y-m-d', time(), false, $this->_userTimeZone());
                        $OverdueList = new OverdueList($user_id, $date);
                        $result['data'] = new TasksListObj('defined', 'expired', $OverdueList->getItems($count, $page), $count);
                        break;
                    }
                case 'future' :
                    {
                        $beginDate = CakeTime::format('Y-m-d', time(), false, $this->_userTimeZone());
                        $endDate = CakeTime::format('Y-m-d', '+7 days', false, $this->_userTimeZone());
                        $arrayDates = ManyDateList::arrayDates($beginDate, $endDate);
                        $ManyDateList = new ManyDateList($user_id, $arrayDates);
                        $result['data'] = new TasksListObj('defined', 'future', $ManyDateList->getItems($count, $page), $count);
                        break;
                    }
                case 'deleted' :
                    {
                        $DeletedList = new DeletedList($user_id);
                        $result['data'] = new TasksListObj('defined', 'deleted', $DeletedList->getItems($count, $page), $count);
                        break;
                    }
                case 'continued' :
                    {
                        $ContinuedList = new ContinuedList($user_id);
                        $result['data'] = new TasksListObj('defined', 'continued', $ContinuedList->getItems($count, $page), $count);
                        break;
                    }
                case 'planned' :
                	{
                        $PlannedList = new PlannedList($user_id);
                        $result['data'] = new TasksListObj('defined', 'planned', $PlannedList->getItems($count, $page), $count);
                		break;
                	}
                case 'day' :
                    {
                        if ( Validation::date($date) ) {
                            //$tasks = $this->Task->getForDate($user_id, $date, $count, $page);
                            //$date = CakeTime::format($date, '%Y-%m-%d');
                            $DateList = new DateList($user_id, $date);
                            $result['data'] = new TasksListObj('DateList', $date, $DateList->getItems());
                            $result['data']->day = $this->Task->Day->getDay($user_id, $date);    
                        }
                        break;
                    }
                default :
                    {
                        $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, некорректный тип')); 
                    }
            }
        } else {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных')); 
            
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function create(){
        if ( !$this->request->isPost() ) {
            $result['errors'][] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $listFields = array(
                'title',
                'priority',
                'done',
                'comment',
                'date',
                'time',
                'timeend'
            );
            $saveData = $this->saveData( $listFields );
            $tag = isset($this->request->data['tag']) ? $this->request->data['tag'] : null ;
            if( empty($tag)) {
                $result['errors'][] = array(
	                'message' => __d('tasks', 'errors, the wrong tag')
	            );
            }
            if( isset($saveData['time']) and ( !isset($saveData['date']) or empty($saveData['date'])) ) {
                $result['errors'][] = array(
	                'message' => __d('tasks', 'errors, date field required')
	            );
            }
        	if( isset($saveData['timeEnd']) and ( !isset($saveData['time']) or empty($saveData['time'])) ) {
                $result['errors'][] = array(
	                'message' => __d('tasks', 'errors, time field required')
	            );
            }
            if ( !isset($result) ) {
                $task = $this->Task->create($this->OAuth->user('id'), $saveData)->save();
                if ( $task ) {
                	$result = $this->taskObj($task);
                    $result->tag = $tag;
            	} else {
            	    $result['tag'] = $tag;
            		$result['errors'] = $this->Task->validationerrorss;
            	}
            }

        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function update(){
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originTask) {
                $listFields = array(
                	'id',
                    'title',
                    'priority',
                    'done',
                    'deleted',
                    'comment',
                    'date',
                    'time',
                    'timeend'
                );
                $saveData = $this->saveData( $listFields );
                if( isset($saveData['time']) and ( !isset($saveData['date']) or empty($saveData['date'])) ) {
                    $result['message'] = new MessageObj('error', __d('tasks', 'errors, date field required'));
                }
            	if( isset($saveData['timeEnd']) and ( !isset($saveData['time']) or empty($saveData['time'])) ) {
                    $result['message'] = new MessageObj('error', __d('tasks', 'errors, time field required'));
                }
                if ( !isset($result) ) {
                	$task = $this->Task->update($saveData);
                    if ( $task ) {
                    	$result['data'] = $task;
                	} else {
                		$result['message'] = new MessageObj('error', 
                                                __d('tasks', 'Ошибка, Задача  не изменена'),
                                                $this->Task->validationErrors
                                                );
        	       }
                }
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи'));
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function updateWidget(){
        if ( !$this->request->isPost() ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $result = $data = $done = $notDone = array();
            $data = $this->request->input('json_decode');
            $user_id = $this->OAuth->user('id');
            //Select ids of new tasks
            $newIds =  array();
            if(isset($data->new) and is_array($data->new) and count($data->new)){
            	foreach($data->new as $task){
            		if (!empty($task->id)){
            			$newIds[] = $task->id;
            		}
            	}
            }
            //Saving tasks
            if(isset($data->tasks) and is_array($data->tasks)){
                foreach($data->tasks as $task){
                    if (!isset($task->done) or empty($task->id)){
                        continue;
                    }
                    if (in_array($task->id, $newIds) && isset($task->title) && !empty($task->title)) {
                        // this is new task
                        $saveData = array('Task' => array(
                                'title' => $task->title,
                                'done' => (int) $task->done,
                                'date' => ($data->date && !((int)$task->future))?$data->date:null,
                                'user_id' => $user_id,
                                'priority' => (int)$task->priority,
                                'comment' => null,
                                'time'=> null,
                                'timeend' => null,
                                'future' => (int)$task->future,
                        ));
                        $this->Task->create();
                        $res = $this->Task->save($saveData);
                        continue;
                    }
                    if((int)$task->done == 1)
                       $done[] = $task->id;
                    if((int)$task->done == 0)
                       $notDone[] = $task->id;
                }
                if(!empty($done)){
                    $this->Task->updateAll(
                        array('Task.done' => 1),
                        array(
                            'Task.id' => $done,
                            'Task.user_id' => $user_id,
                        )
                    );    
                }
                if(!empty($notDone)){
                    $this->Task->updateAll(
                        array('Task.done' => 0),
                        array(
                            'Task.id' => $notDone,
                            'Task.user_id' => $user_id,
                        )
                    );
                }
            }
            if(isset($data->date)){
                $date = trim($data->date);
                if ( Validation::date($date) ) {
                    $DateList = new DateList($user_id, $date);
                    $result['data'] = new TasksListObj('DateList', $date, $DateList->getItems());
                    $result['data']->day = $this->Task->Day->getDay($user_id, $date);    
                }
            }
                
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function move(){
       if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['errors'][] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originTask) {
                $params = array();
                if( isset($this->request->data['todate']) ) {
                    $params['todate'] = $this->request->data['todate'];
                }
                if( isset($this->request->data['after']) ) {
                    if( empty($this->request->data['after']) ) {
                        $params['position'] = 1;
                    } else {
                        $afterTask = $this->Task->findByIdAndUser_id($this->request->data['after'], $this->OAuth->user('id'));
                        if ( $afterTask ) {
                           $params['position'] = $afterTask['Task']['order'] + 1;
                           $params['todate'] = $afterTask['Task']['date'];      
                        }else {
                            $result['errors'][] = array(
                                'message' => __d('tasks', 'Ошибка, Вы не являетесь хозяином этой задачи')
                            );   
                        }    
                    }
                } else if ( isset($this->request->data['position']) ) {
                    $params['position'] = $this->request->data['position'];
                } else {
                    $result['errors'][] = array(
                        'message' => __d('tasks', 'Ошибка, необходимо передать новую позицию для задачи или айди задачи куда нужно перенести')
                    );
                }
               
                if ( !isset($result) ) {
                	$task = $this->Task->move($params);
                	if ( $task ) {
                    	$result = $this->taskObj($task);
                	} else {
                		$result['errors'][] = $this->Task->validationerrorss;
                	}
                }               
            } else {
                $result['errors'][] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
            
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }
    
    public function delete() {
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['errors'][] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originTask) {
                    if ($this->Task->delete()) {
                        $result = true;
                    } else {
                        $result['errors'][] = array(
                            'message' => __d('tasks', 'Ошибка, Задача  не изменена')
                        );
                    }             
            } else {
                $result['errors'][] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
            
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }
    
    protected function saveData($listToSave = array() ){
        $saveData = array();
        foreach($listToSave as $item ) {
            if ( isset($this->request->data[$item]) ) {
                $saveData[$item] = $this->request->data[$item];
            }    
        }
        return $saveData;
    }
    
    protected function taskObj( $task ) {
        $taskObj = new TaskObj();
		$taskObj->id = $task['Task']['id'];
		$taskObj->title = $task['Task']['title'];
		$taskObj->date = $task['Task']['date'];
        $taskObj->time = $task['Task']['time'];
        $taskObj->timeend = $task['Task']['timeend'];
        $taskObj->priority = (int) $task['Task']['priority'];
        $taskObj->order = (int) $task['Task']['order'];
        $taskObj->future = (int) $task['Task']['future'];
        $taskObj->deleted = (int) $task['Task']['deleted'];
        $taskObj->done = (int) $task['Task']['done'];
        $taskObj->datedone = $task['Task']['datedone'];
        $taskObj->comment = $task['Task']['comment'];
        
        return $taskObj;
    }
    

    
    
    
    ///----------------------------------------------------------------
    
  


}
