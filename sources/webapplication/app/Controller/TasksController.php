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
		$arrTaskOnDays = array();
		$arrTaskOnDays['Today'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', time()));
		$arrTaskOnDays['Tomorrow'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', '+1 days'));
		for($i = 2; $i <= 5; $i ++) {
			$arrTaskOnDays[CakeTime::format('l', '+' . $i . ' days')] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d', '+' . $i . ' days'));
		}
		$arrAllExpired = $this->Task->getAllExpired($this->Auth->user('id'));
		$arrAllFuture = $this->Task->getAllFuture($this->Auth->user('id'));
		$this->set('arrAllFuture', $arrAllFuture); //TODO rewrite for using $result
		$this->set('arrAllExpired', $arrAllExpired); //TODO rewrite for using $result
		$this->set('arrTaskOnDays', $arrTaskOnDays); //TODO rewrite for using $result
		$result['success'] = true;
		$result['data']['arrAllFuture'] = $arrAllFuture;
		$result['data']['arrAllExpired'] = $arrAllExpired;
		$result['data']['arrTaskOnDays'] = $arrTaskOnDays;
		$this->set('result', $result);
	}

	public function setTitle() {
		$result = $this->_prepareResponse();
		if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			$task = $this->Task->setTitle($this->request->data['title'])->save();
			if ($task) {
				$result['success'] = true;
				$result['data'] = $task;
			
			}
		}
		$this->set('result', $result);
	}

	public function addNewTask() {
		$result = $this->_prepareResponse();
		//TODO check data before call function
		$task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], $this->request->data['date'])->save();
		if ($task) {
			$result['success'] = true;
			$result['data'] = $task;
		}
		$this->set('result', $result);
	
	}

	public function addFutureTask() {
		//TODO Maybe it is possible to merge this function with addNewTask? Looks as very similar
		$result = $this->_prepareResponse();
		//TODO check data before call function
		$task = $this->Task->create($this->Auth->user('id'), $this->request->data['title'], null, null, null, 0, 1)->save();
		if ($task) {
			$result['success'] = true;
			$result['data'] = $task;
		}
		$this->set('result', $result);
	}

	public function changeOrders() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
				if ($this->Task->setOrder($this->request->data['new_pos'])->save()) {
					return true;
				}
			}
			return false;
		}
	}

	public function setDone() {
		$result = $this->_prepareResponse();
		if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
			$task = $this->Task->setDone($this->request->data['checked'])->save();
			if ($task) {
				$result['success'] = true;
				$result['data'] = $task;
			}
		}
		$this->set('result', $result);
	}

	public function deleteTask() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
				return $this->Task->delete();
			}
			return false;
		}
	}

	public function moveTo() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
				return $this->Task->moveTo($this->Auth->user('id'), $this->request->data['id'], $this->request->data['date']);
			}
			return false;
		}
	}

	public function dragOnDay() {
		$this->autoRender = false;
		if ($this->request->is('ajax')) {
			if ($this->Task->isOwner($this->request->data['id'], $this->Auth->user('id'))) {
				if ($this->Task->setOrder(1)->setDate($this->request->data['date'])->save()) {
					return true;
				}
			}
			return false;
		}
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
