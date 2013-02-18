<?php
App::uses('AppController', 'Controller');
/**
 * Goals Controller
 *
 * @property Goal $Goal
 */
class GoalsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Goal->recursive = 0;
		$this->set('goals', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Goal->exists($id)) {
			throw new NotFoundException(__('Invalid goal'));
		}
		$options = array('conditions' => array('Goal.' . $this->Goal->primaryKey => $id));
		$this->set('goal', $this->Goal->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Goal->create();
			if ($this->Goal->save($this->request->data)) {
				$this->Session->setFlash(__('The goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The goal could not be saved. Please, try again.'));
			}
		}
		$users = $this->Goal->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Goal->exists($id)) {
			throw new NotFoundException(__('Invalid goal'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Goal->save($this->request->data)) {
				$this->Session->setFlash(__('The goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The goal could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Goal.' . $this->Goal->primaryKey => $id));
			$this->request->data = $this->Goal->find('first', $options);
		}
		$users = $this->Goal->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Goal->id = $id;
		if (!$this->Goal->exists()) {
			throw new NotFoundException(__('Invalid goal'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Goal->delete()) {
			$this->Session->setFlash(__('Goal deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Goal was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
