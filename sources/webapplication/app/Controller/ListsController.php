<?php
App::uses('TagList', 'Model');
App::uses('AppController', 'Controller');

/**
 * Notes Controller
 *
 * @property 
 */
class ListsController extends AppController {

    public $uses = array('Tagged', 'Task', 'UserTag');
    
    public function index() {}
    
    public function add(){
        $result = $this->_prepareResponse();
        $expectedData = array(
            'tag'
        );
        if (! $this->_isSetRequestData($expectedData) ) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
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
                $result['message'] = array(
                        'type' => 'error', 
                        'message' => __d('tags', 'Ошибка, Список  не создан')
                );
                $result['errors'] = $this->UserTag->Tag->validationErrors;
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
                    $result['message'] = array(
                        'type' => 'error', 
                        'message' => __d('users_tags', 'Ошибка, Список  уже создан')
                    );
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
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
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
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
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
                $result['message'] = array(
                        'type' => 'error', 
                        'message' => __d('users_tags', 'Ошибка, Задача  не изменена')
                );
                $result['errors'] = $this->UserTag->validationErrors;
            }
	    	$result['action'] = 'setCommentTag';
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
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            $result = $this->UserTag->Tag->find('first', 
                        array(
                            'contain' => array(),
                            'conditions' => array(
                                 'Tag.name' => $tag,
                             ),
                            'fields' => array('id')
                        )
                    );
            $tasks = array();
            if($result){
                $TagList = new TagList($this->Auth->user('id'), $result['Tag']['id'], 'Task');
                $tasks = $TagList->getItems();    
            }
            $result['data']['tasks'] = $tasks;
            $result['success'] = true;
            $result['data']['tag'] = $tag;
        }
        $result['action'] = 'getListByTag';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

}
