<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
App::uses('Validation', 'Utility');
App::uses('DateList', 'Model');
App::uses('ManyDateList', 'Model');
App::uses('PlannedList', 'Model');
App::uses('OverdueList', 'Model');
App::uses('CompletedList', 'Model');
App::uses('DeletedList', 'Model');
App::uses('ContinuedList', 'Model');
App::uses('TagList', 'Model');
App::uses('TaskEventListener', 'Event');

App::uses('TaskObj', 'Lib');
App::uses('TasksListObj', 'Lib');
App::uses('MessageObj', 'Lib');

/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {
    
    public $helpers = array('Task');
    
    public $components = array(
        'RequestHandler',
    );
    
    
    public $layout = 'tasks';
    
    public function repeated(){
        return;
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'recur'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $recur = $this->request->data['recur'];
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                if(!$originTask['Task']['repeatid']){
                    $this->Task->repeated($recur);    
                }
                
                //if ($task) {
                    $result['success'] = true;
                    //$result['data'] = $task;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __d('tasks', 'Задача  успешно изменена')
                    );
                //} else {
//                    $result['data'] = $originTask;
//                    $result['message'] = array(
//                        'type' => 'error', 
//                        'message' => __d('tasks', 'Ошибка, Задача  не изменена')
//                    );
//                    $result['errors'] = $this->Task->validationErrors;
//                }
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
        }
        $result['action'] = 'repeated';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    
    public function index() {
        
        $this->response->disableCache();
        $result = $this->_prepareResponse();
        
        $beginDate = CakeTime::format('Y-m-d', '-1 days');
        $endDate = CakeTime::format('Y-m-d', '+6 days');
        
        $dayConfig = $this->Task->User->Setting->getValue('days', $this->Auth->user('id'));
        if(!is_array($dayConfig)){
            $dayConfig = array();
        }
        $arrayDates = ManyDateList::arrayDates($beginDate, $endDate, $dayConfig);
        $ManyDateList = new ManyDateList($this->Auth->user('id'), $arrayDates);
        $tasks = $ManyDateList->getItems();
        
        $result['success'] = true;
        $PlannedList = new PlannedList($this->Auth->user('id'));
        $result['data']['arrAllFuture'] = $PlannedList->getItems();
        $result['data']['arrAllFutureCount']['all'] = count($result['data']['arrAllFuture']);
        $result['data']['arrAllFutureCount']['done'] = count(array_filter($result['data']['arrAllFuture'], create_function('$val', 'return $val->done == 1;')));
        
        $result['data']['inConfig'] = false;
        $result['data']['yesterdayDisp'] = false;
            
        if ( in_array($beginDate, $dayConfig) ){
            $result['data']['inConfig'] = true;
        }
        
        $arrTaskOnDays = array();
        foreach($arrayDates as $date){
            $arrTaskOnDays[$date] = array_filter($tasks, function ($task) use ($date) { return ($task->date == $date); } );
            $done = array_filter($arrTaskOnDays[$date], create_function('$val', 'return $val->done == 1;'));
            $data_count[$date]['all'] = count($arrTaskOnDays[$date]);
            $data_count[$date]['done'] = count($done); 
        }
        
        $result['data']['arrTaskOnDays'] = $arrTaskOnDays;
        $result['data']['arrTaskOnDaysCount'] = $data_count;
        
        $result['data']['arrDaysRating'] = $this->Task->Day->getDays($this->Auth->user('id'), $beginDate, $endDate, $dayConfig);
        if($result['data']['arrTaskOnDaysCount'][$beginDate]['all'] && $result['data']['arrTaskOnDaysCount'][$beginDate]['all'] > $result['data']['arrTaskOnDaysCount'][$beginDate]['done'] ){
            $result['data']['yesterdayDisp'] = true;
        } else {
            if ( !$result['data']['inConfig'] ){
                unset($result['data']['arrTaskOnDaysCount'][$beginDate]);
                unset($result['data']['arrTaskOnDays'][$beginDate]);
                
            }
        }
        
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    
    public function getTasksByType() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('type')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $result['success'] = true;
            $resultTasks = array();
            switch ($this->request->data['type']) {
                case 'completed' :
                    {
                        $CompletedList = new CompletedList($this->Auth->user('id'));
                        $result['data'] = new TasksListObj('defined', 'completed', $CompletedList->getItems());
                        break;
                    }
                case 'expired' :
                    {
                        $OverdueList = new OverdueList($this->Auth->user('id'));
                        $result['data'] = new TasksListObj('defined', 'expired', $OverdueList->getItems());
                        break;
                    }
                case 'future' :
                    {
                        $beginDate = CakeTime::format('Y-m-d', time());
                        $endDate = CakeTime::format('Y-m-d', '+7 days');
                        $arrayDates = ManyDateList::arrayDates($beginDate, $endDate);
                        $ManyDateList = new ManyDateList($this->Auth->user('id'), $arrayDates);
                        $result['data'] = new TasksListObj('defined', 'future', $ManyDateList->getItems());
                        break;
                    }
                case 'deleted' :
                    {
                        $DeletedList = new DeletedList($this->Auth->user('id'));
                        $result['data'] = new TasksListObj('defined', 'deleted', $DeletedList->getItems());
                        break;
                    }
                case 'continued' :
                    {
                        $ContinuedList = new ContinuedList($this->Auth->user('id'));
                        $result['data'] = new TasksListObj('defined', 'continued', $ContinuedList->getItems());
                        break;
                    }
                default :
                    {
                        $result['success'] = false;
                        $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, некорректный тип')); 
                        
                    }
            }
            
        }
        
        $result['action'] = 'getTasksByType';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function setTitle() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'title'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                if (!$originTask['Task']['future']) {
                    $task = $this->Task->setTitle($this->request->data['title'])->saveTask();
                }else {
                    $task = $this->Task->setTitle($this->request->data['title'], null, false)->saveTask();
                }
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно изменена'));
                } else {
                    $result['data'] = $originTask;
                    $result['message'] = new MessageObj('error', 
                                                        __d('tasks', 'Ошибка, Задача  не изменена'),
                                                        $this->Task->validationErrors
                                                        );
                }
            }
        }
        $result['action'] = 'setTitle';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function addNewTask() {
        $task = array();
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'title'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            
            
            if (!empty($this->request->data['date']) && Validation::date($this->request->data['date'])) {
                $task = $this->Task->createTask($this->Auth->user('id'), $this->request->data['title'], $this->request->data['date'])->saveTask();
            } else {
                if ($this->Task->saveAll($this->request->data, array('fieldList' => 'title', 'validate' => 'only'))) {
                    $date = empty($this->request->data['date']) ? '' : ' #'.$this->request->data['date'];
                    $task = $this->Task->createTask($this->Auth->user('id'), $this->request->data['title'] . $date, null, null, null, 0, 1)->saveTask();
                }    
            }
            if ($task) {
                $result['success'] = true;
                $result['data'] = $task['Task'];
                if( isset($date) ){
                    $result['data']['list'] = $this->request->data['date'];
                }
                $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно создана'));
             } else {
                $result['message'] = new MessageObj('error', 
                                                    __d('tasks', 'Задача  не создана'),
                                                    $this->Task->validationErrors
                                                    );
             }
        }
        $result['action'] = 'create';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function cloneTask() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'id'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $task = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($task) {
                $cloneTask = $this->Task->createTask($this->Auth->user('id'), $task['Task']['title'], $this->request->data['date'], $task['Task']['time'], null, $task['Task']['priority'], $task['Task']['future'], 1)->saveTask();
                if ($cloneTask) {
                    $result['success'] = true;
                    $result['data'] = $cloneTask;
                    $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно склонирована'));
                } else {
                    $result['message'] = new MessageObj('error', 
                                                        __d('tasks', 'Задача  не склонирована'),
                                                        $this->Task->validationErrors
                                                        );
                }
            } else{
                $result['message'] = new MessageObj('error', __d('tasks', 'Задача не существует'));
            }
        }
        $result['action'] = 'clone';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function changeOrders() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'list',
            'id', 
            'position'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $task = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($task) {
                switch($this->request->data['list']['name']){
                    case 'date':
                        if($task['Task']['future']){
                            $List = new PlannedList($this->Auth->user('id'), 'planned');
                        }else{
                            $List = new DateList($this->Auth->user('id'), $task['Task']['date']);    
                        }
                        break;
                    case 'tag':
                        $options['conditions'] = array('Tag.name' => $this->request->data['list']['tag']);
        	            $options['fields'] = array('id');
        	            $options['contain'] = array();
        	            $tag = $this->Task->Tag->find('first', $options);
                        $List = new TagList($this->Auth->user('id'), $tag['Tag']['id'], 'Task');
                        break;
                    default:
                        $List = null;                            
                }
                
                if($List !== null){
                    if ( $List->reOrder($task['Task']['id'], $this->request->data['position']) ) {
                        $result['success'] = true;
                        $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно перемещена'));
                    } else {
                        $result['message'] = new MessageObj('error', __d('tasks', 'Задача не перемещена'));
                    }
                } else {
                    $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, некорректный список'));
                }
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи'));
            }
        }
        $result['action'] = 'changeOrders';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function setDone() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'done'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setDone($this->request->data['done'])->saveTask();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    if ($task['Task']['done']) {
                        $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно выполнена'));
                    } else {
                        $result['message'] = new MessageObj('success', __d('tasks', 'Задача открыта'));
                    }
                } else {
                    $result['data'] = $originTask;
                    $result['message'] = new MessageObj('error',
                                                        __d('tasks', 'Ошибка, Задача  не изменена'),
                                                        $this->Task->validationErrors
                                                        );
                }
            }
        }
        $result['action'] = 'setDone';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function setDelete() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('id')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                if (!$originTask['Task']['deleted']) {
                    // set field deleted = 1
                    $task = $this->Task->setDelete(1)->saveTask();
                    if ($task) {
                        $result['success'] = true;
                        $result['data'] = $task;
                        $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно перемещена в список удаленных задач'));
                    } else {
                        $result['data'] = $originTask;
                        $result['message'] = new MessageObj('error', 
                                                            __d('tasks', 'Ошибка, Задача  не изменена'),
                                                            $this->Task->validationErrors
                                                            );
                   }
                }else{
                    //delete task forever
                    if ($this->Task->delete()) {
                        $result['success'] = true;
                        $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно удалена'));
                    } else {
                        $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, Задача  не изменена'));
                    }
                }
            }
        }
        $result['action'] = 'delete';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function deleteAll(){
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('confirm')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            if($this->Task->deleteAll(array('Task.user_id' => $this->Auth->user('id'),
                                            'Task.deleted' => 1
                                    ),
                                     false))
            {
                $result['success'] = true;
                $result['message'] = new MessageObj('success', __d('tasks', 'Задачи успешно удалены'));
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Задачи не удалены'));
            }
        }
        $result['action'] = 'deleteAll';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function dragOnDay() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'date', 
            'time'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                if ($this->Task->setDelete(0)->setDate($this->request->data['date'])->save()) {
                    $result['success'] = true;
                    $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно перемещена (moveTo)'));
                } else {
                    $result['message'] = new MessageObj(
                                            'error', 
                                            __d('tasks', 'Задача  не перемещена (moveTo)'),
                                            $this->Task->validationErrors
                    );
                }
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи'));
            }
        }
        $result['action'] = 'dragOnDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function editTask() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'title', 
            'priority', 
            'date', 
            'time', 
            'timeEnd', 
            'done',
            'continued', 
            'comment'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setEdit($this->request->data['title'], 
                                             $this->request->data['priority'], 
                                             $this->request->data['continued'],
                                             $this->request->data['comment'], 
                                             $this->request->data['date'], 
                                             $this->request->data['time'], 
                                             $this->request->data['timeEnd'], 
                                             $this->request->data['done']
                                             )->saveTask();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    $result['message'] = new MessageObj('success', __d('tasks', 'Задача успешно отредактировано'));
                } else {
                    $result['message'] =  new MessageObj(
                                            'error', 
                                            __d('tasks', 'Задача не отредактировано'),
                                            $this->Task->validationErrors
                    );
                }
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка, Вы не можете делать изменения в этой задачи'));
            }
        }
        $result['action'] = 'edit';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function getTasksForDay() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('date')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            if( $this->request->data['date'] == 'planned' ){
                $PlannedList = new PlannedList($this->Auth->user('id'));
                $result['data'] = new TasksListObj('defined', 'planned', $PlannedList->getItems());
            }else{
                $date = CakeTime::format('Y-m-d', $this->request->data['date']);
                $DateList = new DateList($this->Auth->user('id'), $date);
                $result['data'] = new TasksListObj('DateList', $date, $DateList->getItems());
                $result['data']->day = $this->Task->Day->getDay($this->Auth->user('id'), $date);
                
                $this->Task->setDayToConfig($this->Auth->user('id'), $date);
            }
            $result['success'] = true;
        }
        $result['action'] = 'addDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function deleteDay() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('date')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            if ($this->Task->deleteDayFromConfig($this->Auth->user('id'), $this->request->data['date'])) {
                $result['success'] = true;
                $result['message'] = new MessageObj('success', __d('tasks', 'День успешно удален из списка'));
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при удалении')); 
            }
        }
        $result['action'] = 'deleteDay';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function checkStatus() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'hash'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $result['success'] = $this->Auth->loggedIn();
            if ($result['success']) {
                //$result['operation'] = 'none';
                if (Validation::date($this->request->data['date']) and ! CakeTime::isToday($this->request->data['date'])) {
                    $result['operation'] = 'refresh';
                    $result['cause'] = 'changeDay';
                    $result['message'] = new MessageObj('success', __d('tasks', 'Переход на новый день. Перезагрузка страницы произойдет через 5 секунд')); 
                }
            }
        }
        $result['action'] = 'checkStatus';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    //----------------------------------------------------------------------
}
