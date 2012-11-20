<?php


App::uses('ApiV1AppController', 'ApiV1.Controller');
App::uses('TaskObj', 'Lib');
App::uses('Validation', 'Utility');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class TasksController extends ApiV1AppController {
	
	public $components = array('OAuth.OAuth');
	
	
/**
 * beforeFilter
 *  
 */
//	public function beforeFilter() {
//		parent::beforeFilter();
//    }
    
 
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
        	switch ( $type ) {
                case 'completed' :
                    {
                        $tasks = $this->Task->getCompleted($this->OAuth->user('id'), $count, $page);
                        break;
                    }
                case 'expired' :
                    {
                        $tasks = $this->Task->getExpired($this->OAuth->user('id'), $count, $page);
                        break;
                    }
                case 'future' :
                    {
                        $tasks = $this->Task->getFuture($this->OAuth->user('id'), $count, $page);
                        break;
                    }
                case 'deleted' :
                    {
                        $tasks = $this->Task->getDeleted($this->OAuth->user('id'), $count, $page);
                        break;
                    }
                case 'day' :
                    {
                        if ( Validation::date($date) ) {
                            $tasks = $this->Task->getForDate($this->OAuth->user('id'), $date, $count, $page);    
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
        		$taskObj = new TaskObj();
        		$taskObj->id = $task['Task']['id'];
        		$taskObj->title = $task['Task']['title'];
        		$taskObj->date = $task['Task']['date'];
                $taskObj->time = $task['Task']['time'];
                $taskObj->timeend = $task['Task']['timeend'];
                $taskObj->priority = $task['Task']['priority'];
                $taskObj->order = $task['Task']['order'];
                $taskObj->future = $task['Task']['future'];
                $taskObj->deleted = $task['Task']['deleted'];
                $taskObj->done = $task['Task']['done'];
                $taskObj->datedone = $task['Task']['datedone'];
                $taskObj->comment = $task['Task']['comment'];
                
        		$result[] = $taskObj;
        	}
        } else {
            $result['message'] = __d('tasks', 'Ошибка при передаче данных');
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    
    
    ///----------------------------------------------------------------
    
  


}
