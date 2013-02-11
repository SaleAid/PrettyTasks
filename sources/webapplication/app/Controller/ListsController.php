<?php
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property 
 */
class ListsController extends AppController {

    //public $layout = 'defaults';
    
    public $uses = array('Tagged', 'Task');
    public function index() {
       
    
    }
    
    public function getTasksByTag(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'tag'
        );
        if (! $this->_isSetRequestData($expectedData) or empty($this->request->data['tag'])) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $tasks = $this->Tagged->find('tagged', array(
     		     'by' => $this->request->data['tag'],
                 'user_id' => $this->Auth->user('id'),
     		     'model' => 'Task')
            );
            //$result['data'] = $tasks;
            foreach( $tasks as $key => $task){
                $task = $this->Task->read(null, $task['Task']['id']);
                $result['data'][$key]['Task'] = $task['Task'];
            }
            $result['success'] = true;
        }
        $result['action'] = 'getListByTag';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

}
