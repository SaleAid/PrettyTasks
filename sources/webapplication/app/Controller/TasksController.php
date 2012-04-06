<?php
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {
    
    public $components = array('RequestHandler');
    public $helpers = array('Html','Js','Time');
    public $layout ='tasks';
    
    public function index() {
	   
       $arrTaskOnDays = array();
       $arrTaskOnDays['Today'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d',time()));
       $arrTaskOnDays['Tomorrow'] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d','+1 days'));
       for($i = 2; $i <= 5; $i++){
            $arrTaskOnDays[CakeTime::format('l', '+'.$i.' days')] = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d','+'.$i.' days'));       
       }
       $arrAllExpired = $this->Task->getAllExpired($this->Auth->user('id'));
       $arrAllFuture = $this->Task->getAllFuture($this->Auth->user('id'));
       $this->set('arrAllFuture', $arrAllFuture);
       $this->set('arrAllExpired', $arrAllExpired);
       $this->set('arrTaskOnDays', $arrTaskOnDays);
    }
    
    public function changeTitle(){

        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->isOwn($this->request->data['id'], $this->Auth->user('id'))){
                return $this->Task->changeTitle($this->request->data['id'],$this->request->data['title']);
            }
        }
        return false;
    }
    
    public function addNewTask(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->create($this->Auth->user('id'),$this->request->data['title'],$this->request->data['date'])){
                $this->set('task_id', $this->Task->getLastInsertID());
                $this->set('title', $this->request->data['title']);
                $this->autoRender = true;
            }
        }
        return false;
    }
    
    public function addFutureTask(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->create($this->Auth->user('id'),$this->request->data['title'],null,null,null,0,1)){
                $this->set('task_id', $this->Task->getLastInsertID());
                $this->set('title', $this->request->data['title']);
                $this->autoRender = true;
            }
        }
        return false;
    }
    
    
    public function changeOrders(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->changeOrders($this->request->data['id'], $this->request->data['old_pos'], $this->request->data['new_pos'],$this->request->data['new_order'])){
                return true;
            }
            return false; 
       } 
    }

    public function setDone(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->isOwn($this->request->data['id'], $this->Auth->user('id'))){
                return $this->Task->setDone($this->request->data['id'], $this->request->data['checked']);
            }
            return false; 
       }    
    }
    
    public function deleteTask(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->isOwn($this->request->data['id'], $this->Auth->user('id'))){
                //debug($this->request->data);die;
                return $this->Task->deleteTask($this->request->data['id'],$this->request->data['order']);
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
		if (!$this->Task->exists()) {
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
				$this->redirect(array('action' => 'index'));
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
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
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
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
