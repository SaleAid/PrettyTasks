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
		'Html', 'Js', 'Time'
	);

	protected function _prepareResponse() {
		return array(
			'success' => false
		);
	}

	public function index() {
		$this->layout = 'tasks';
		$result = $this->_prepareResponse();
		$result['success'] = true;
		$result['data']['arrAllFuture'] = $this->Task->getAllFuture($this->Auth->user('id'));
		$result['data']['arrAllExpired'] = $this->Task->getAllExpired($this->Auth->user('id'));
		$result['data']['arrTaskOnDays']['Today'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', time()));
		$result['data']['arrTaskOnDays']['Tomorrow'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', '+1 days'));
		for($i = 2; $i <= 5; $i ++) {
			$result['data']['arrTaskOnDays'][CakeTime::format('l', '+' . $i . ' days')] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', '+' . $i . ' days'));
		}
		$this->set('result', $result);
	}

	public function setTitle() {
		$result = $this->_prepareResponse();
		if ($originTask = $this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
		  	$task = $this->Task->setTitle($this->request->data['title'])->save();
			if ($task) {
				$result['success'] = true;
				$result['data'] = $task;
			    $result['message'] = array('type'=>'success', 'message' => __('Задача  успешно изменена.')); 
			}else {
			     $result['data'] = $originTask;
                 $result['message'] = array('type'=>'alert', 'message' => __('Задача  не изменена'));
            }
		}
		$this->set('result', $result);
        $this->set('_serialize', array('result'));
	}

	public function addNewTask() {
	   	$result = $this->_prepareResponse();
		if(isset($this->request->data['date']) and !empty($this->request->data['date']) ){
            $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], $this->request->data['date'])->save();    
        }else{
            $task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], null, null, null, 0, 1)->save();
        }
		if ($task) {
			$result['success'] = true;
			$result['data'] = $task;
            $result['message'] = array('type'=>'success', 'message' => __('Задача успешно создана.'));
		}else {
            $result['message'] = array('type'=>'alert', 'message' => __('Задача  не создана.'));
        }
		$this->set('result', $result);
        $this->set('_serialize', array('result'));
	}

	public function changeOrders() {
	   $result = $this->_prepareResponse();
		if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			if ($this->Task->setOrder($this->request->data['new_pos'])->save()) {
				$result['success'] = true;
                $result['message'] = array('type'=>'success', 'message' => __('Задача успешно перемещена.'));    
			}
		}
        $this->set('result', $result);
        $this->set('_serialize', array('result'));
    }

	public function setDone() {
		$result = $this->_prepareResponse();
		if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			$task = $this->Task->setDone($this->request->data['checked'])->save();
			if ($task) {
				$result['success'] = true;
				$result['data'] = $task;
                if($task['Task']['done']){
                    $result['message'] = array('type'=>'success', 'message' => __('Задача успешно выполнена.'));    
                }else{
                    $result['message'] = array('type'=>'alert', 'message' => __('Задача открыта.'));
                }
            }
		}
		$this->set('result', $result);
        $this->set('_serialize', array('result'));
	}

	public function deleteTask() {
		$result = $this->_prepareResponse();
        if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			if($this->Task->delete()){
			    $result['success'] = true;
                $result['message'] = array('type'=>'success', 'message' => __('Задача успешно удалена.'));    
			}else {
			    $result['message'] = array('type'=>'alert', 'message' => __('Error.'));
			}
		}
		$this->set('result', $result);
        $this->set('_serialize', array('result'));
	}

	public function dragOnDay() {
		$result = $this->_prepareResponse();
		if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			if ($this->Task->setOrder(1)->setDate($this->request->data['date'])->save()) {
				$result['success'] = true;
                $result['message'] = array('type'=>'success', 'message' => __('Задача успешно перемещена (moveTo).'));    
			}
		}
        $this->set('result', $result);
        $this->set('_serialize', array('result'));
	}
    
    public function editTask(){
        $result = $this->_prepareResponse();
        $result['success'] = true;
        $result['data'] = $this->request->data;
        $this->set('result', $result);
        $this->set('_serialize', array('result'));
    }

	//----------------------------------------------------------------------
	/**
	 * index method
	 *
	 * @return void
	 */
	//public function index() {
	//	   
	//       $taskOnDay = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d',time()));
	//       $this->set('result', $taskOnDay);
	//
	//	}
	

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->Task->id = $id;
		if (! $this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->set('task', $this->Task->read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Task->create();
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array(
					'action' => 'index'
				));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
		$users = $this->Task->User->find('list');
		debug($users);
		$this->set(compact('users'));
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this->Task->id = $id;
		if (! $this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array(
					'action' => 'index'
				));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Task->read(null, $id);
		}
		$users = $this->Task->User->find('list');
		$this->set(compact('users'));
	}

	/**
	 * delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		if (! $this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Task->id = $id;
		if (! $this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array(
				'action' => 'index'
			));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array(
			'action' => 'index'
		));
	}
}
