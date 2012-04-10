<?php
App::uses('AppController', 'Controller');
/**
 * Days Controller
 *
 * @property Day $Day
 */
class DaysController extends AppController {

    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');

    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->Day->recursive = 0;
		$this->set('days', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		$this->set('day', $this->Day->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Day->create();
			if ($this->Day->save($this->request->data)) {
				$this->Session->setFlash(__('The day has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The day could not be saved. Please, try again.'));
			}
		}
		$users = $this->Day->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Day->save($this->request->data)) {
				$this->Session->setFlash(__('The day has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The day could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Day->read(null, $id);
		}
		$users = $this->Day->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		if ($this->Day->delete()) {
			$this->Session->setFlash(__('Day deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Day was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Day->recursive = 0;
		$this->set('days', $this->paginate());
	}

/**
 * admin_view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		$this->set('day', $this->Day->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Day->create();
			if ($this->Day->save($this->request->data)) {
				$this->Session->setFlash(__('The day has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The day could not be saved. Please, try again.'));
			}
		}
		$users = $this->Day->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Day->save($this->request->data)) {
				$this->Session->setFlash(__('The day has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The day could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Day->read(null, $id);
		}
		$users = $this->Day->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Day->id = $id;
		if (!$this->Day->exists()) {
			throw new NotFoundException(__('Invalid day'));
		}
		if ($this->Day->delete()) {
			$this->Session->setFlash(__('Day deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Day was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
