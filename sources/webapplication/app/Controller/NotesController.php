<?php
App::uses('NoteObj', 'Lib');
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property 
 */
class NotesController extends AppController {

    public $helpers = array('Tag');
    
    public $layout = 'notes';
    
    public function index() {
        $result = $notes = array();
    	$count = isset($this->request->query['count']) ? $this->request->query['count'] : null;
    	if ( $count > 50 ) $count = 50;
    	$page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
    	$user_id = $this->Auth->user('id');
    	$notes = $this->Note->getNotes($user_id, $count, $page);
    	foreach ($notes as $note) {
    	    $result[] = new NoteObj($note);
        }    
        
    	
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    
    }
    
    public function create(){
        $result = $this->_prepareResponse();
        if ( !$this->request->isPost() or !isset($this->request->data['title']) ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $note = $this->Note->create($this->Auth->user('id'), $this->request->data['title'])->save();
            if ( $note ) {
            	$result['data'] = new NoteObj($note);
                $result['success'] = true;
                $result['message'] = array(
                    'type' => 'info', 
                    'message' => __d('tasks', 'Заметка  успешно создана')
                ); 
        	} else {
        	   $result['message'] = array(
                    'type' => 'error', 
                    'message' => __d('tasks', 'Заметка  не создана')
                );
        		$result['errors'] = $this->Note->validationErrors;
        	}
        }
        $result['action'] = 'create'; 
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function update(){
        $result = $this->_prepareResponse();
        if ( !$this->request->isPost() or !isset($this->request->data['id']) or !isset($this->request->data['title']) ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $originNote = $this->Note->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originNote) {
		      $note = $this->Note->update($this->request->data['title'])->save();
              if ( $note ) {
	              $result['data'] = new NoteObj($note);
                  $result['success'] = true; 
	          } else {
		         $result['message'] = array(
                    'type' => 'error', 
                    'message' => __d('tasks', 'Заметка  не обновлена')
                );
                 $result['errors'] = $this->Note->validationErrors;
	          }
            } else {
                $result['errors'] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой заметки')
                );
            }
        }
        $result['action'] = 'update'; 
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function delete() {
        $result = $this->_prepareResponse();
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['error'] = array(
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $note = $this->Note->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($note) {
                    if ($this->Note->delete()) {
                        $result['success'] = true; 
                    } else {
                        $result['error'] = array(
                            'message' => __d('tasks', 'Ошибка, note  не изменена')
                        );
                    }             
            } else {
                $result['error'] = array(
                    'message' => __d('tasks', 'Ошибка, Вы не можете делать изменения в этой note`s')
                );
            }
        }
        $result['action'] = 'delete';
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }


}
