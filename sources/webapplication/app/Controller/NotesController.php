<?php
App::uses('NoteObj', 'Lib');
App::uses('AppController', 'Controller');
App::uses('MessageObj', 'Lib');
/**
 * Notes Controller
 *
 * @property 
 */
class NotesController extends AppController {

    public $helpers = array('Tag');
    
    public $layout = 'notes';
    
    protected function _isSetRequestData($data, $model = null) {
        if(!$this->isSetCsrfToken()){
            return false;
        }
        return parent::_isSetRequestData($data, $model);
    }
    
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
        if ( ! $this->_isSetRequestData('title') ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $note = $this->Note->create($this->Auth->user('id'), $this->request->data['title'])->save();
            if ( $note ) {
            	$result['data'] = new NoteObj($note);
                $result['success'] = true;
                $result['message'] = new MessageObj('info', __d('tasks', 'Заметка успешно создана'));
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Заметка успешно создана'), $this->Note->validationErrors);
            }
        }
        $result['action'] = 'create'; 
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function update(){
        $result = $this->_prepareResponse();
        if ( ! $this->_isSetRequestData(array('id', 'title')) ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $originNote = $this->Note->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($originNote) {
		      $note = $this->Note->update($this->request->data['title'])->save();
              if ( $note ) {
	              $result['data'] = new NoteObj($note);
                  $result['success'] = true; 
	          } else {
	             $result['message'] = new MessageObj('error', __d('notes', 'Заметка не обновлена'), $this->Note->validationErrors);
		      }
            } else {
                $result['message'] = new MessageObj('error', __d('notes', 'Ошибка, Вы не можете делать изменения в этой заметке'));
            }
        }
        $result['action'] = 'update'; 
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function delete() {
        $result = $this->_prepareResponse();
        if ( ! $this->_isSetRequestData('id') ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $note = $this->Note->isOwner($this->request->data['id'], $this->Auth->user('id'));
            if ($note) {
                    if ($this->Note->delete()) {
                        $result['success'] = true; 
                    } else {
                        $result['message'] = new MessageObj('error', __d('notes', 'Ошибка, заметка не удалена'));
                    }             
            } else {
                $result['message'] = new MessageObj('error', __d('notes', 'Ошибка, Вы не можете делать изменения в этой заметке'));
            }
        }
        $result['action'] = 'delete';
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }


}
