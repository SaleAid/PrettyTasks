<?php

App::uses('CakeTime', 'Utility');
App::uses('ApiV1AppController', 'ApiV1.Controller');
App::uses('TaskObj', 'Lib');
App::uses('Validation', 'Utility');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class TasksController extends ApiV1AppController {
	
	
    public function lists(){
        if ( !$this->request->is('get') ) {
            throw new ForbiddenException();
        }
        if( isset($this->request->query['type']) && !empty($this->request->query['type']) ){
            $result = $tasks = array();
            //type of requested list. Values: day, expired, future, deleted, completed.
            $type = $this->request->query['type'];
            $date = isset($this->request->query['date']) ? $this->request->query['date'] : null;
            $count = isset($this->request->query['count']) ? $this->request->query['count'] : 0;
            if ( $count > 100 ) $count = 100;
            $page = isset($this->request->query['page']) ? $this->request->query['page'] : 0;
            $user_id = $this->OAuth->user('id');
        	
            switch ( $type ) {
                case 'completed' :
                    {
                        $tasks = $this->Task->getCompleted($user_id, $count, $page);
                        break;
                    }
                case 'expired' :
                    {
                        $tasks = $this->Task->getExpired($user_id, $count, $page);
                        break;
                    }
                case 'future' :
                    {
                        $tasks = $this->Task->getFuture($user_id, $count, $page);
                        break;
                    }
                case 'deleted' :
                    {
                        $tasks = $this->Task->getDeleted($user_id, $count, $page);
                        break;
                    }
                case 'day' :
                    {
                        if ( Validation::date($date) ) {
                            $tasks = $this->Task->getForDate($user_id, $date, $count, $page);    
                        }
                        break;
                    }
                default :
                    {
                        $result['error'] = array(
                            'message' => __d('tasks', 'Ошибка, некорректный тип')
                        );
                    }
            }
            foreach ($tasks as $task) {
        		$result[] = $this->taskObj($task);
        	}
        } else {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function create(){
        if ( !$this->request->isPost() ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $listFields = array(
                'id',
            	'title',
                'priority',
                'done',
                'comment',
                'date',
                'time',
                'timeend'
            );
            $saveData = $this->saveData( $listFields );
            if( isset($saveData['id']) and !Validation::uuid($saveData['id']) ) {
                $result['error'] = array(
	                'message' => __d('tasks', 'error, the wrong ID')
	            );
            }
            if( isset($saveData['time']) and ( !isset($saveData['date']) or empty($saveData['date'])) ) {
                $result['error'] = array(
	                'message' => __d('tasks', 'Error, date field required')
	            );
            }
        	if( isset($saveData['timeEnd']) and ( !isset($saveData['time']) or empty($saveData['time'])) ) {
                $result['error'] = array(
	                'message' => __d('tasks', 'Error, time field required')
	            );
            }
            if ( !isset($result) ) {
                $task = $this->Task->create($this->OAuth->user('id'), $saveData)->save();
                //pr($task);die;
            	if ( $task ) {
                	$result = $this->taskObj($task);
            	} else {
            		$result['error'] = $this->Task->validationErrors;
            	}
            }

        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function update(){
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
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
                    $result['error'] = array(
		                'message' => __d('tasks', 'Error, date field required')
		            );
                }
            	if( isset($saveData['timeEnd']) and ( !isset($saveData['time']) or empty($saveData['time'])) ) {
                    $result['error'] = array(
		                'message' => __d('tasks', 'Error, time field required')
		            );
                }
                if ( !isset($result) ) {
                	$task = $this->Task->update($saveData);
                	if ( $task ) {
                    	$result = $this->taskObj($task);
                	} else {
                		$result['error'] = $this->Task->validationErrors;
                	}
                }
                
            } else {
                $result['error'] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function move(){
       if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['error'] = array(
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
                            $result['error'] = array(
                                'message' => __d('tasks', 'Ошибка, Вы не являетесь хозяином этой задачи')
                            );   
                        }    
                    }
                } else if ( isset($this->request->data['position']) ) {
                    $params['position'] = $this->request->data['position'];
                } else {
                    $result['error'] = array(
                        'message' => __d('tasks', 'Ошибка, необходимо передать новую позицию для задачи или айди задачи куда нужно перенести')
                    );
                }
               
                if ( !isset($result) ) {
                	$task = $this->Task->move($params);
                	if ( $task ) {
                    	$result = $this->taskObj($task);
                	} else {
                		$result['error'] = $this->Task->validationErrors;
                	}
                }               
            } else {
                $result['error'] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
            
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }
    
    public function delete() {
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originTask) {
                    if ($this->Task->delete()) {
                        $result = true;
                    } else {
                        $result['error'] = array(
                            'message' => __d('tasks', 'Ошибка, Задача  не изменена')
                        );
                    }             
            } else {
                $result['error'] = array(
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
