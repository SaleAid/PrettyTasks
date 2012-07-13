<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
App::uses('Validation', 'Utility');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {
    public $components = array(
        'RequestHandler'
    );

    public function index() {
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $result['data']['arrAllFuture'] = $this->Task->getAllFuture($this->Auth->user('id'));
        $result['data']['arrAllFutureCount']['all'] = count($result['data']['arrAllFuture']);
        $result['data']['arrAllFutureCount']['done'] = count(array_filter($result['data']['arrAllFuture'], create_function('$val', 'return $val[\'Task\'][\'done\'] == 1;')));
        $result['data']['arrAllExpired'] = $this->Task->getAllExpired($this->Auth->user('id'));
        $from = CakeTime::format('Y-m-d', time());
        $to = CakeTime::format('Y-m-d', '+7 days');
        $dayConfig = $this->Task->User->getConfig($this->Auth->user('id'), 'day');
        $result['data']['arrTaskOnDays'] = $this->Task->getDays($this->Auth->user('id'), $from, $to, $dayConfig);
        foreach ( $result['data']['arrTaskOnDays'] as $key => $value ) {
            $done = array_filter($value, create_function('$val', 'return $val[\'Task\'][\'done\'] == 1;'));
            $data_count[$key]['all'] = count($value);
            $data_count[$key]['done'] = count($done);
        }
        $result['data']['arrTaskOnDaysCount'] = $data_count;
        $result['data']['arrDaysRating'] = $this->Task->Day->getDaysRating($this->Auth->user('id'), $from, $to, $dayConfig);
        $result['data']['arrAllOverdue'] = $this->Task->getAllOverdue($this->Auth->user('id'));
        $result['data']['arrAllCompleted'] = $this->Task->getAllCompleted($this->Auth->user('id'));
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function getOverdue() {
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $result['data']['arrAllOverdue'] = $this->Task->getAllOverdue($this->Auth->user('id'));
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function getCompleted() {
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $result['data']['arrAllCompleted'] = $this->Task->getAllCompleted($this->Auth->user('id'));
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function getTasksByType() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('type')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $result['success'] = true;
            $result['type'] = $this->request->data['type'];
            switch ($this->request->data['type']) {
                case 'completed' :
                    {
                        $result['data'] = $this->Task->getAllCompleted($this->Auth->user('id'));
                        break;
                    }
                case 'expired' :
                    {
                        $result['data'] = $this->Task->getAllOverdue($this->Auth->user('id'));
                        break;
                    }
                case 'future' :
                    {
                        $from = CakeTime::format('Y-m-d', time());
                        $to = CakeTime::format('Y-m-d', '+7 days');
                        $result['data'] = $this->Task->getDays($this->Auth->user('id'), $from, $to);
                        break;
                    }
                default :
                    {
                        $result['success'] = false;
                        $result['message'] = array(
                            'type' => 'error', 
                            'message' => __('Ошибка, некорректный тип')
                        );
                    }
            }
            $data = array();
            if (isset($result['data'])) {
                foreach ( $result['data'] as $key => $value ) {
                    if ($key) {
                        $data[$key]['weekDay'] = $this->Task->getWeekDay(CakeTime::format('l', $key));
                        if (CakeTime::isToday($key)) {
                            $data[$key]['weelDayStyle'] = '';
                        } else {
                            $data[$key]['weelDayStyle'] = ($key > CakeTime::format('Y-m-d', time())) ? 'future' : 'past';
                        }
                        $data[$key]['list'] = $value;
                    }
                }
            }
        }
        unset($result['data']);
        $result['data'] = $data;
        $result['action'] = 'getTasksByType';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function agenda() {
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $from = CakeTime::format('Y-m-d', time());
        $to = CakeTime::format('Y-m-d', '+7 days');
        $dayConfig = $this->Task->User->getConfig($this->Auth->user('id'), 'day');
        $result['data']['arrTaskOnDays'] = $this->Task->getDays($this->Auth->user('id'), $from, $to);
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function setTitle() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'title'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setTitle($this->request->data['title'])->saveTask();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача  успешно изменена')
                    );
                } else {
                    $result['data'] = $originTask;
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __('Ошибка, Задача  не изменена'), 
                    );
                }
            }
        }
        $result['action'] = 'setTitle';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function addNewTask() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'date', 
            'title'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            if (! empty($this->request->data['date'])) {
                $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], $this->request->data['date'])->saveTask();
            } else {
                $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], null, null, null, 0, 1)->saveTask();
            }
            if ($task) {
                $result['success'] = true;
                $result['data'] = $task;
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('Задача успешно создана')
                );
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Задача  не создана')
                );
                $result['errors'] = $this->Task->validationErrors;
            }
        }
        $result['action'] = 'create';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function changeOrders() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'position'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
                if ($this->Task->setOrder($this->request->data['position'])->save()) {
                    $result['success'] = true;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача успешно перемещена')
                    );
                } else {
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача не перемещена')
                    );
                }
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
        }
        $result['action'] = 'changeOrders';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function setDone() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'done'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setDone($this->request->data['done'])->saveTask();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    if ($task['Task']['done']) {
                        $result['message'] = array(
                            'type' => 'success', 
                            'message' => __('Задача успешно выполнена')
                        );
                    } else {
                        $result['message'] = array(
                            'type' => 'success', 
                            'message' => __('Задача открыта')
                        );
                    }
                } else {
                    $result['data'] = $originTask;
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __('Ошибка, Задача  не изменена')
                    );
                }
            }
        }
        $result['action'] = 'setDone';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function deleteTask() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('id')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $task = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($task) {
                if ($this->Task->delete()) {
                    $result['success'] = true;
                    //$result['data'] = $task;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача успешно удалена')
                    );
                } else {
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __('Error')
                    );
                }
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Ошибка, Задача  не изменена')
                );
            }
        }
        $result['action'] = 'delete';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function dragOnDay() {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id', 
            'date', 
            'time'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                if ($this->Task->setOrder(1)->setDate($this->request->data['date'])->setTime($this->request->data['time'])->save()) {
                    //if ($this->Task->dragOnDay($this->request->data['date'], $this->request->data['time'])->save()) {
                    $result['success'] = true;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача успешно перемещена (moveTo)')
                    );
                } else {
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача  не перемещена (moveTo)')
                    );
                }
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
        }
        $result['action'] = 'dragOnDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
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
            'comment'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setEdit($this->request->data['title'], $this->request->data['priority'], $this->request->data['comment'], $this->request->data['date'], $this->request->data['time'], $this->request->data['timeEnd'], $this->request->data['done'])->saveTask();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача успешно отредактировано')
                    );
                } else {
                    $result['errors'] = $this->Task->validationErrors;
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __('Задача не отредактировано')
                    );
                }
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
                );
            }
        }
        $result['action'] = 'edit';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function getTasksForDay() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('date')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $task = $this->Task->getTasksForDay($this->Auth->user('id'), CakeTime::format('Y-m-d', $this->request->data['date']));
            $done = array_filter($task, create_function('$val', 'return $val[\'Task\'][\'done\'] == 1;'));
            $result['data']['listCount']['all'] = count($task);
            $result['data']['listCount']['done'] = count($done);
            $result['success'] = true;
            $result['data']['list'] = $task;
            $result['data']['date'] = $this->request->data['date'];
            $result['data']['weekDay'] = $this->Task->getWeekDay(CakeTime::format('l', $this->request->data['date']));
            $result['data']['day'] = $this->Task->Day->getDaysRating($this->Auth->user('id'), $this->request->data['date']);
            $result['data']['weelDayStyle'] = ($result['data']['date'] > CakeTime::format('Y-m-d', time())) ? 'future' : 'past';
            //TODO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $this->layout = false;
            $view = new View($this, false);
            $view->set('type', $result['data']['weelDayStyle']);
            $view->set('hide', $result['data']['listCount']['all']);
            $view->viewPath = 'Elements';
            $result['data']['emptyList'] = $view->render('empty_lists');
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Задача успешно ...')
            );
        }
        $result['action'] = 'addDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function deleteDay() {
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('date')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            if ($this->Task->deleteDayFromConfig($this->Auth->user('id'), $this->request->data['date'])) {
                $result['success'] = true;
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('День успешно удален из списка')
                );
            } else {
                $result['message'] = array(
                    'type' => 'error', 
                    'message' => __('Ошибка при  ...')
                );
            }
        }
        $result['action'] = 'deleteDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
    
    public function checkStatus(){
        $result = $this->_prepareResponse();
        if (! $this->_isSetRequestData('date')) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __('Ошибка при передачи данных')
            );
        } else {
            $result['operation'] =  Validation::date($this->request->data['date']);
        }
        $result['action'] = 'checkStatus';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
    //----------------------------------------------------------------------
}
