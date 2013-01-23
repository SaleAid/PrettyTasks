<?php
App::uses('CakeTime', 'Utility');
App::uses('ApiV1AppController', 'ApiV1.Controller');
App::uses('DayObj', 'Lib');
/**
 * Days Controller
 *
 * @property 
 */
class DaysController extends ApiV1AppController {

    public function lists(){
        if ( !$this->request->is('get') ) {
            $result['errors'][] = array(
                'message' => __d('days', 'Ошибка при передаче данных')
            );
        }else {
            $result = $days = array();
        	$count = isset($this->request->query['count']) ? $this->request->query['count'] : null;
        	if ( $count > 100 ) $count = 100;
        	$page = isset($this->request->query['page']) ? $this->request->query['page'] : null;
        	$user_id = $this->OAuth->user('id');
        	$dayss = $this->Day->getByUser_id($user_id, $count, $page);
        	foreach ($days as $day) {
        	    $result[] = new DayObj($day);
            }    
        }
    	$this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function read(){
	if ( !$this->request->isGet() or !isset($this->request->query['id']) ) {
            $result['errors'][] = array(
                'message' => __d('days', 'Ошибка при передаче данных')
            );
        } else {
            $day = $this->Day->isOwner($this->request->query['id'], $this->OAuth->user('id'));
            if ($day) {
		$result =  new DayObj($day);                   
            } else {
                $result['errors'][] = array(
                    'message' => __d('days', 'Ошибка, Вы не можете читать эту заметку')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');    
	
    }
    
    public function update(){
        if ( !$this->request->isPost() or !isset($this->request->data['id']) ) {
            $result['errors'][] = array(
                'message' => __d('days', 'Ошибка при передаче данных')
            );
        } else {
            $originDay = $this->Day->isOwner($this->request->data['id'], $this->OAuth->user('id'));
            if ($originDay) {
                $data = array();
                if(isset( $this->request->data['rating']))
                    $data['rating'] = $this->request->data['rating'];  
                if(isset( $this->request->data['comment']))
                    $data['comment'] = $this->request->data['comment'];                    
		        $day = $this->Day->update($data)->save();
                if ( $day ) {
	               $result = new DayObj($day);
	            } else {
		          $result['errors'] = $this->Day->validationerrorss;
	            }
            } else {
                $result['errors'][] = array(
                    'message' => __d('days', 'Ошибка, Вы не можете делать изменения в этой заметки')
                );
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
  public function create(){
        if ( !$this->request->isPost() or !isset($this->request->data['date']) ) {
            $result['errors'][] = array(
                'message' => __d('days', 'Ошибка при передаче данных')
            );
        } else {
            $data = array();
            if(isset( $this->request->data['rating']))
                $data['rating'] = $this->request->data['rating'];  
            if(isset( $this->request->data['comment']))
                $data['comment'] = $this->request->data['comment'];    
            $tag = isset($this->request->data['tag']) ? $this->request->data['tag'] : null;
            if( empty($tag) ) {
                $result['errors'][] = array(
	                'message' => __d('days', 'errors, the wrong tag')
	            );
            }
            if ( !isset($result) ) {
                $day = $this->Day->create($this->OAuth->user('id'), $data)->save();
                if ( $day ) {
                	$result = new DayObj($day);
                    $result->tag = $tag;
                } else {
                    $result['tag'] = $tag;
            		$result['errors'] = $this->Day->validationerrorss;
            	}
            }
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
}
