<?php
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property 
 */
class ListsController extends AppController {

    //public $layout = 'defaults';
    
    public $uses = array('Tagged', 'Task', 'UserTag');
    public function index() {}
    
    public function getlists(){
        $result['data'] =  Set::extract($this->UserTag->find('all', array(
                                'contain' => array(
                                        'Tag' => array(
                                                'order' => 'Tag.name ASC',
                                                'fields' => 'name'
                                    )
                                ),
                                'conditions' => array('UserTag.user_id =' => $this->Auth->user('id')),
                                )
                          ), '{n}.Tag.name');
       
        //$db = $this->UserTag->getDataSource();
//        $res = $db->fetchAll(
//            '
//            select tagged.*, tags.* from tagged 
//                    join users_tags on tagged.tag_id = users_tags.tag_id 
//                    join tags on tagged.tag_id = tags.id
//                    join users_tags on tagged.tag_id = tags.id 
//                    where users_tags.user_id = ?
//            ',
//            array($this->Auth->user('id'))
//        );
//        $tags = Set::extract($res, '{n}.tags');
//         pr($res1);
//        foreach( $tags as $key => $value){
//            //create_function('$v,$w','return max($v,is_array($w)? count($w): 1);')
//            $value['tagged'] = count(array_filter($res, create_function('$val', 'return $val[\'tagged\'][\'tag_id\'] ==  "'. $value['tags']['id'].'";')));
//            $res1[] = $value;
//        }
//        pr($res1);die;
        
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
        if (! $this->_isSetRequestData($expectedData) or empty($tag)) {
            $result['message'] = array(
                'type' => 'error', 
                'message' => __d('tasks', 'Ошибка при передаче данных')
            );
        } else {
            
            $tasks = $this->Tagged->find('tagged', array(
     		     'by' => $tag,
                 'user_id' => $this->Auth->user('id'),
                 'model' => 'Task')
            );
            $resultTasks = $tasksId = array();
            foreach( $tasks as $key => $task){
                if( !$task['Task']['deleted'] ){
                    $tasksId[] = $task['Task']['id'];     
                }
            }
            if($tasksId){
                $resultTasks = $this->Task->getTasksById($tasksId);
            }
            $result['data']['tasks'] = Set::extract($resultTasks, '{n}.Task');
            $result['success'] = true;
            $result['data']['tag'] = $tag;
        }
        $result['action'] = 'getListByTag';
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

}
