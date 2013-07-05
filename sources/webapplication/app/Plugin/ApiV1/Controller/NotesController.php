<?php
App::uses('CakeTime', 'Utility');
App::uses('ApiV1AppController', 'ApiV1.Controller');
App::uses('NoteObj', 'Lib');
/**
 * Notes Controller
 *
 * @property 
 */
class NotesController extends ApiV1AppController {

    public function lists(){
        if ( !$this->request->is('get') ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        }else {
            $result = $notes = array();
        	$count = isset($this->request->query['count']) ? $this->request->query['count'] : null;
        	if ( $count > 100 ) $count = 100;
        	$page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        	$user_id = $this->OAuth->user('id');
        	$notes = $this->Note->getNotes($user_id, $count, $page);
        	foreach ($notes as $note) {
        	    $result[] = new NoteObj($note);
            }    
        }
    	$this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function read(){
	if ( !$this->request->isGet() or !isset($this->request->query['id']) ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $note = $this->Note->isOwner($this->request->query['id'], $this->OAuth->user('id'));
            if ($note) {
		$result =  new NoteObj($note);                   
            } else {
                $result['errors'][] = array(
                    'message' => __d('notes', 'Ошибка, Вы не можете читать эту заметку')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
	
    }
    
    public function update(){
        if ( !$this->request->isPost() or !isset($this->request->data['id']) or !isset($this->request->data['title']) ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $originNote = $this->Note->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originNote) {
		      $note = $this->Note->update($this->request->data['title'])->save();
              //debug($note);die;            
	          if ( $note ) {
	              $result = new NoteObj($note);
	          } else {
		         $result['errors'] = $this->Note->validationerrorss;
	          }
            } else {
                $result['errors'][] = array(
                    'message' => __d('notes', 'Ошибка, Вы не можете делать изменения в этой заметки')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
     public function delete() {
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $note = $this->Note->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($note) {
                    if ($this->Note->delete()) {
                        $result = true;
                    } else {
                        $result['errors'][] = array(
                            'message' => __d('notes', 'Ошибка, note  не изменена')
                        );
                    }             
            } else {
                $result['errors'][] = array(
                    'message' => __d('notes', 'Ошибка, Вы не можете делать изменения в этой note`s')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
    }
    
    public function search(){
        if ( !$this->request->is('get') or !isset($this->request->query['query']) ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        }else {
            $result = $notes = array();
        	$count = isset($this->request->query['count']) ? $this->request->query['count'] : null;
        	if ( $count > 100 ) $count = 100;
        	$page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        	$user_id = $this->OAuth->user('id');
            $query = $this->request->query['query'];
        	$notes = $this->Note->search($user_id, $query, $count, $page);
        	foreach ($notes as $note) {
        	    $result[] = new NoteObj($note);
            }    
        }
    	$this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
  public function create(){
        if ( !$this->request->isPost() or !isset($this->request->data['title']) ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        } else {
            $title = $this->request->data['title'];
            $tag = isset($this->request->data['tag']) ? $this->request->data['tag'] : null;
            if( empty($tag) ) {
                $result['errors'][] = array(
	                'message' => __d('notes', 'errors, the wrong tag')
	            );
            }
            if ( !isset($result) ) {
                $note = $this->Note->create($this->OAuth->user('id'), $title)->save();
                if ( $note ) {
                	$result = new NoteObj($note);
                    $result->tag = $tag;
                } else {
                    $result['tag'] = $tag;
            		$result['errors'] = $this->Note->validationerrorss;
            	}
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
}
