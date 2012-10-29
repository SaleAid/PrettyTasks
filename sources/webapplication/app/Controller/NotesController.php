<?php
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property 
 */
class NotesController extends AppController {

    public $layout = 'notes';
    
    public function index() {
          $notes = $this->Note->getNotes($this->Auth->user('id'));
          $result['success'] = true;
          $result['data'] = $notes;
          $this->set('object', $result);
          $this->set('_serialize', 'object');
    
    }
    public function add(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'note'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $data = $this->Note->createNote($this->Auth->user('id'), $this->request->data['note'])->saveNote();
            $result['data'] = $data['Note'];
            $result['success'] = true;      
        }
        $result['action'] = 'create'; 
        $this->set('object', $result);
        $this->set('_serialize', 'object');
    }
    
    public function edit($id = null) {
        $result = $this->_prepareResponse();
        $expectedData = array(
            'id',
            'note',
            'order',
            'action'
        );
        if (! $this->_isSetRequestData($expectedData)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $originNote = $this->Note->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originNote) {
                $saveData = array(
                    'id' => $this->request->data['id'],
                    'note' => $this->request->data['note'],
                    'order' => $this->request->data['order']
                );
                $action = $this->request->data['action'];
                $data = $this->Note->editNote($saveData, $action)->saveNote();
                if( $data ){
                    $result['data'] = $data['Note'];
                    $result['success'] = true;    
                }else{
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __d('tasks', 'Заметка  не ....')
                    );
                    $result['errors'] = $this->Note->validationErrors;    
                }
            }      
        }
        $result['action'] = $this->params['data']['action']; 
        $this->set('object', $result);
        $this->set('_serialize', 'object');
        
        
	}
    
    public function delete($id = null) {
        if (!$this->request->is('post') && !$this->request->is('delete')) {
			throw new MethodNotAllowedException();
		}
        $result = $this->_prepareResponse();
		$originNote = $this->Note->isOwner($id, $this->Auth->user('id'));
        if ($originNote) {
            
        }
		if ($this->Note->delete()) {
			//$result['success'] = true;  
		}
        //$result['action'] = $this->params['data']['action']; 
        $this->set('object', $result);
        $this->set('_serialize', 'object');
	}

   // 
//    public function beforeRender111() {
//		if (!$this->RequestHandler->isAjax()) {
//			return;
//		}
//		$controllerName = $this->request->params['controller'];
//		$action = $this->request->params['action'];
//		$singular = Inflector::singularize($controllerName);
//		$modelName = Inflector::camelize($singular);
//		switch ($action) {
//			case 'index': 
//				$param = $controllerName;				
//				break;
//			case 'add':
//				$param = $singular;
//				break;
//			case 'edit':
//				$param = $singular;
//				break;
//			case 'delete':
//				return;
//				break;
//			case 'view':
//				$object = $singular;
//				break;
//		}
//		if (!isset($object) && isset($param)) {
//			if (isset($this->viewVars[$param][0][$modelName])) {
//				return array_map(function($row) use ($modelName) {
//					return $row[$modelName];
//				}, $this->viewVars[$param]);
//			}
//			elseif (isset($this->viewVars[$param][$modelName])) {
//				return $this->viewVars[$param][$modelName];
//			} else {
//				return $this->viewVars[$param];
//			}
//		} elseif(isset($object)) {
//			return $object;
//		}
//	}
//
}
