<?php
App::uses('NoteObj', 'Lib');
App::uses('AppController', 'Controller');
App::uses('MessageObj', 'Lib');
App::uses('NotesListObj', 'Lib');
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
        $this->response->disableCache();
        $result = $notes = array();
    	$user_id = $this->Auth->user('id');
    	$notes = $this->Note->getNotes($user_id, Configure::read('Notes.Lists.limit'), 1);
    	foreach ($notes as $note) {
    	    $result[] = new NoteObj($note);
        }    
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    
    }
    
    public function getNotes() {
        $result = $this->_prepareResponse();
        if ( ! $this->_isSetRequestData('page') ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $notesObj = $notes = array();
       	    $count = !isset($this->request->data['count']) ? Configure::read('Notes.Lists.limit') : (int)$this->request->data['count'];
        	if ( $count > Configure::read('Notes.Lists.limit') ) 
                $count = Configure::read('Notes.Lists.limit');
            
            $page = !empty($this->request->data['page']) ? (int)$this->request->data['page'] : 0;
        	if($page > -1){
        	    $notes = $this->Note->getNotes($this->Auth->user('id'), $count, $page);
            	foreach ($notes as $note) {
            	    $notesObj[] = new NoteObj($note);
                }
                $result['success'] = true;
                $result['data'] = new NotesListObj('NotesList', 'notes', $notesObj, $count);   
        	}else{
        	   $result['message'] = new MessageObj('error', __d('notes', 'Ошибка при передаче номера страницы'));
        	}
        }   
        $result['action'] = 'getNotes'; 
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    
    }
    
    public function create(){
        $result = $this->_prepareResponse();
        if ( ! $this->_isSetRequestData('title') ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $note = $this->Note->createNote($this->Auth->user('id'), $this->request->data['title'])->save();
            if ( $note ) {
                $note['Note']['title'] = mb_substr($note['Note']['title'], 0, 140);
            	$result['data'] = new NoteObj($note);
                $result['success'] = true;
                $result['message'] = new MessageObj('info', __d('tasks', 'Заметка успешно создана'));
            } else {
                $result['message'] = new MessageObj('error', __d('tasks', 'Заметка не создана'), $this->Note->validationErrors);
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
    
    public function getNote(){
        $result = $this->_prepareResponse();
        if (!$this->_isSetRequestData('id')) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $note = $this->Note->getNote($this->request->data['id'], $this->Auth->user('id')); 
            if($note){
                $result['data'] = new NoteObj($note);
                $result['success'] = true;
                $result['message'] = new MessageObj('success', __d('notes', 'Готово'));
            }
        }
        $result['action'] = 'getNote';
        if(isset($this->request->data['view']) && $this->request->data['view']){
            $result['action'] = 'getNoteView';
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }


}
