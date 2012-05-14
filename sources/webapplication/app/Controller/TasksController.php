<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {
    public $components = array(
        'RequestHandler'
    );
    public $helpers = array(
        'Html', 
        'Js', 
        'Time'
    );

    protected function _prepareResponse() {
        return array(
            'success' => false
        );
    }

    protected function _isSetRequestData($data) {
        //TODO: 1. Check for post
        if (is_array($data)) {
            foreach ( $data as $value ) {
                if (! isset($this->request->data[$value])) {
                    return false;
                }
            }
        } else {
            return isset($this->request->data[$data]);
        }
        return true;
    }

    public function index() {
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $result['data']['arrAllFuture'] = $this->Task->getAllFuture($this->Auth->user('id'));
        $result['data']['arrAllExpired'] = $this->Task->getAllExpired($this->Auth->user('id'));
        //		for($i = 0; $i <= 5; $i ++) {
        //			$result['data']['arrTaskOnDays'][CakeTime::format('Y-m-d', '+' . $i . ' days')] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', '+' . $i . ' days'));
        //		}
        $result['data']['arrTaskOnDays'] = $this->Task->getDays($this->Auth->user('id'));
        //pr($result);die;
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function setTitle() {
        $result = $this->_prepareResponse();
        $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
        if ($originTask) {
            $task = $this->Task->setTitle($this->request->data['title'])->save();
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
                    'type' => 'alert', 
                    'message' => __('Ошибка, Задача  не изменена')
                );
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
        if (isset($this->request->data['date']) and ! empty($this->request->data['date'])) {
            $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], $this->request->data['date'])->save();
        } else {
            $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], null, null, null, 0, 1)->save();
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
                'type' => 'alert', 
                'message' => __('Задача  не создана')
            );
        }
        $result['action'] = 'create';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function changeOrders() {
        $result = $this->_prepareResponse();
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
                'type' => 'success', 
                'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
            );
        }
        $result['action'] = 'changeOrders';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function setDone() {
        $result = $this->_prepareResponse();
        $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
        if ($originTask) {
            $task = $this->Task->setDone($this->request->data['done'])->save();
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
                        'type' => 'alert', 
                        'message' => __('Задача открыта')
                    );
                }
            } else {
                $result['data'] = $originTask;
                $result['message'] = array(
                    'type' => 'alert', 
                    'message' => __('Ошибка, Задача  не изменена')
                );
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
        if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
            if ($this->Task->delete()) {
                $result['success'] = true;
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('Задача успешно удалена')
                );
            } else {
                $result['message'] = array(
                    'type' => 'alert', 
                    'message' => __('Error')
                );
            }
        } else {
            $result['message'] = array(
                'type' => 'alert', 
                'message' => __('Ошибка, Задача  не изменена')
            );
        }
        $result['action'] = 'delete';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function dragOnDay() {
        $result = $this->_prepareResponse();
        $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
        if ($originTask) {
            $expectedData = array(
                'id', 
                'date', 
                'time'
            );
            if ($this->_isSetRequestData($expectedData)) {
                if ($this->Task->setOrder(1)->setDate($this->request->data['date'])->save()) {
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
                    'type' => 'success', 
                    'message' => __('Ошибка при передачи данных')
                );
            }
        } else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
            );
        }
        $result['action'] = 'dragOnDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function editTask() {
        $result = $this->_prepareResponse();
<<<<<<< HEAD
        if($this->_isSetRequestData(array('id','title','date','time','timeEnd','done','comment'))){
            if ($originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
                 if($task = $this->Task->setEdit($this->request->data['title'],$this->request->data['date'], $this->request->data['time'], $this->request->data['timeEnd'], $this->request->data['done'])->save()){
                     $result['success'] = true;
                     $result['data'] = $task;
                     $result['message'] = array('type'=>'success', 'message' => __('Задача успешно отредактировано'));  
                 }else{
                    $result['message'] = array('type'=>'success', 'message' => __('Задача не отредактировано'));  
                 }
            }else{
                $result['message'] = array('type'=>'success', 'message' => __('Ошибка, Вы не можете делать изменения в этой задачи'));
=======
        $expectedData = array(
            'id', 
            'title', 
            'date', 
            'time', 
            'done', 
            'comment'
        );
        if ($this->_isSetRequestData($expectedData)) {
            $originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originTask) {
                $task = $this->Task->setEdit($this->request->data['title'], $this->request->data['date'], $this->request->data['time'], $this->request->data['done'])->save();
                if ($task) {
                    $result['success'] = true;
                    $result['data'] = $task;
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача успешно отредактировано')
                    );
                } else {
                    $result['message'] = array(
                        'type' => 'success', 
                        'message' => __('Задача не отредактировано')
                    );
                }
            } else {
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('Ошибка, Вы не можете делать изменения в этой задачи')
                );
>>>>>>> 31c74aa69e9834790d659617ba54bdf40584e2f4
            }
        } else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
            );
        }
        $result['action'] = 'edit';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }

    public function getTasksForDay() {
        $result = $this->_prepareResponse();
        if ($this->_isSetRequestData('date')) {
            $task = $this->Task->getTasksForDay($this->Auth->user('id'), $this->request->data['date']);
            $result['success'] = true;
            $result['data']['list'] = $task;
            $result['data']['date'] = $this->request->data['date'];
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Задача успешно ...')
            );
        } else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
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
        if ($this->_isSetRequestData('date')) {
            if ($this->Task->deleteDayFromConfig($this->Auth->user('id'), $this->request->data['date'])) {
                $result['success'] = true;
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('День успешно удален из списка')
                );
            } else {
                $result['message'] = array(
                    'type' => 'success', 
                    'message' => __('Ошибка при  ...')
                );
            }
        } else {
            $result['message'] = array(
                'type' => 'success', 
                'message' => __('Ошибка при передачи данных')
            );
        }
        $result['action'] = 'deleteDay';
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        ));
    }
    //----------------------------------------------------------------------
}
