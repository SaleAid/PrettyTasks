<?php
App::uses('TagList', 'Model');
App::uses('AppController', 'Controller');
App::uses('MessageObj', 'Lib');
/**
 * Notes Controller
 *
 * @property 
 */
class ListsController extends AppController {

    public $uses = array('Tagged', 'Task', 'UserTag');
    
    protected function _isSetRequestData($data, $model = null) {
        if(!$this->isSetCsrfToken()){
            return false;
        }
        return parent::_isSetRequestData($data, $model);
    }
    
    public function index() {}
    
    public function add(){
        $result = $this->_prepareResponse();
        $result['errors'] = array();
        $expectedData = array(
            'tag'
        );
        if (! $this->_isSetRequestData($expectedData) ) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            
        	$options['conditions'] = array('Tag.name' => $this->UserTag->Tag->multibyteKey($this->request->data['tag']));
        	$options['fields'] = array('id', 'name');
        	$options['contain'] = array();
        	$tag = $this->UserTag->Tag->find('first', $options);
            if( !isset($tag['Tag']['id']) ){
        		$this->UserTag->Tag->create();
        		$tag = $this->UserTag->Tag->add($this->request->data['tag']);
            }
            if(!$tag){
                $result['message'] = new MessageObj('error', 
                                                    __d('users_tags', 'Ошибка, Список не создан'),
                                                    $this->UserTag->Tag->validationErrors
                                                    );
            }else{
                $options['conditions'] = array(
                    'UserTag.tag_id' => $tag['Tag']['id'],
                    'UserTag.user_id' => $this->Auth->user('id')
                );
            	$options['fields'] = array('id');
            	$options['contain'] = array();
            	$userTag = $this->UserTag->find('first', $options);
                if(!$userTag){
                    $this->UserTag->Tag->create();
                    $this->UserTag->save(array('tag_id' => $tag['Tag']['id'], 'user_id' => $this->Auth->user('id')));
                    $result['success'] = true;
                    $result['data'] = array('tag' => $tag['Tag']['name']);
                } else {
                    $result['message'] = new MessageObj('error', __d('users_tags', 'Ошибка, Список уже создан'));
                }
            }
        }
        $result['action'] = 'createList';
	    $this->set('result', $result);
	    $this->set('_serialize', 'result');
    }
    
    public function getlists(){
         $data =  $this->UserTag->find('all', array(
                                'contain' => array(
                                        'Tag' => array(
                                                'order' => 'Tag.name ASC',
                                                'fields' => 'name'
                                    )
                                ),
                                'conditions' => array('UserTag.user_id =' => $this->Auth->user('id')),
                            )
                          );
        
        $data = array_map( 
            function($item) { 
                return array(
                            'name' => $item['Tag']['name'],
                            'archive' => (int)$item['UserTag']['archive']
                            //'count' => $item['UserTag']['task_occurrence']
                        ); 
            }, 
            $data 
        );                   
        $result['data'] = $data;
       
        $result['success'] = true;
        $result['action'] = 'getLists';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
        
    }
    
    public function getCommentTag(){
    	$result = $this->_prepareResponse();
        $expectedData = array(
            'tag'
        );
        if (! $this->_isSetRequestData($expectedData) or empty($this->request->data['tag'])) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
        	$options['conditions'] = array('Tag.name' => $this->request->data['tag']);
        	$options['fields'] = array('id');
        	$options['contain'] = array();
        	$tag = $this->UserTag->Tag->find('first',$options);
        	$comment ='';
        	if( isset($tag['Tag']['id']) ){
        		$comment = $this->UserTag->getComment($this->Auth->user('id'), $tag['Tag']['id']);
	    	}
	    	$result['data']['tag'] = $this->request->data['tag'];
        	$result['data']['comment'] = $comment;
	    	$result['success'] = true;
	        $result['action'] = 'getCommentTag';
	        $this->set('result', $result);
	        $this->set('_serialize', 'result');
        }
    }
    
    public function setCommentTag(){
    	$result = $this->_prepareResponse();
        $expectedData = array(
            'tag', 'comment'
        );
        if (! $this->_isSetRequestData($expectedData) or empty($this->request->data['tag'])) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
        	$options['conditions'] = array('Tag.name' => $this->request->data['tag']);
        	$options['fields'] = array('id', 'name');
        	$options['contain'] = array();
        	$tag = $this->UserTag->Tag->find('first', $options);
        	if( !isset($tag['Tag']['id']) ){
        		$this->UserTag->Tag->create();
        		$tag = $this->UserTag->Tag->add($this->request->data['tag']);
        	}
	    	$comment = $this->UserTag->setComment($this->Auth->user('id'), $tag['Tag']['id'], $this->request->data['comment']);
            if($comment){
                $result['data']['tag'] = $tag['Tag']['name'];
                $result['data']['comment'] = $comment;
                $result['success'] = true;
            } else {
                $result['message'] = new MessageObj('error', 
                                                    __d('users_tags', 'Ошибка при сохранении комментария'),
                                                    $this->UserTag->validationErrors
                                                    );
            }
	    	$result['action'] = 'setCommentTag';
	        $this->set('result', $result);
	        $this->set('_serialize', 'result');
        }
    }
    
    public function setArchive(){
    	$result = $this->_prepareResponse();
        $expectedData = array(
            'tag', 'status'
        );
        if (! $this->_isSetRequestData($expectedData) or empty($this->request->data['tag'])) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
        	$options['conditions'] = array('Tag.name' => $this->request->data['tag']);
        	$options['fields'] = array('id', 'name');
        	$options['contain'] = array();
        	$tag = $this->UserTag->Tag->find('first', $options);
        	if( !isset($tag['Tag']['id']) ){
        		$this->UserTag->Tag->create();
        		$tag = $this->UserTag->Tag->add($this->request->data['tag']);
        	}
	    	$data = $this->UserTag->setArchive($this->Auth->user('id'), $tag['Tag']['id'], $this->request->data['status']);
            if($data){
                $result['data']['tag'] = $tag['Tag']['name'];
                $result['success'] = true;
            } else {
                $result['message'] = new MessageObj('error', 
                                                    __d('users_tags', 'Ошибка при сохранении статуса'),
                                                    $this->UserTag->validationErrors
                                                    );
            }
	    	$result['action'] = 'setArchive';
	        $this->set('result', $result);
	        $this->set('_serialize', 'result');
        }
    }
    
    public function getTasksByTag(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'tag'
        );
        $tag = $this->UserTag->Tag->multibyteKey($this->request->data['tag']);
        if (! $this->_isSetRequestData($expectedData) or !strlen($tag)) {
            $result['message'] = new MessageObj('error', __d('tasks', 'Ошибка при передаче данных'));
        } else {
            $data = $this->UserTag->find('first', 
                array(
                    'contain' => array('Tag'),
                    'conditions' => array(
                         'Tag.name' => $tag,
                     ),
                    'fields' => array('Tag.id', 'UserTag.archive')
                )
            );
            $tasks = array();
            if($data){
                $TagList = new TagList($this->Auth->user('id'), $data['Tag']['id'], 'Task');
                $tasks = $TagList->getItems();    
            }
            $result['data']['tasks'] = $tasks;
            $result['success'] = true;
            $result['data']['tag'] = $tag;
            $result['data']['archive'] = isset($data['UserTag']['archive']) ? (int)$data['UserTag']['archive'] : 0;
        }
        $result['action'] = 'getListByTag';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

}
