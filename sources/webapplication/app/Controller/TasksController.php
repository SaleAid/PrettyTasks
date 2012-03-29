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
    
    public function editTitle(){

        $this->autoRender = false;
        if ($this->request->is('ajax')) {
           echo "goof"; 
        }
        return false;
    }
    
    public function addNewTask(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if($this->Task->create($this->Auth->user('id'),$this->request->data['title'],CakeTime::format('Y-m-d',time()))){
                $this->set('title', $this->request->data['title']);
                $this->autoRender = true;
            }
        }
        return false;
    }
    public function getAllForDate(){
       
       if (empty($this->request->data['Date'])){
            $this->request->data['Date'] = CakeTime::format('Y-m-d',time());
       }
       if ($this->request->is('ajax')) {
             //debug(CakeTime::format('Y-m-d','+'.CakeTime::fromString($this->request->data['strDate'])));
             $taskOnDay = $this->Task->getAllForDate($this->Auth->user('id'), CakeTime::format('Y-m-d',$this->request->data['Date']));
             $this->set('result', $taskOnDay);
       } 
    }
    


//----------------------------------------------------------------------
/**
 * index method
 *
 * @return void
 */
	public function index() {
	   //debug($this->Task->getAllForDate($this->Auth->user('id'),CakeTime::format('Y-m-d',time())));
       $taskToDay = $this->Task->getAllForDate($this->Auth->user('id'),CakeTime::format('Y-m-d',time()));
	   	//$this->Task->recursive = 0;
//		$this->set('tasks', $this->paginate());
	}

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
