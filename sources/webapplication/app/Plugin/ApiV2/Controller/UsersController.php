<?php

App::uses('ApiV1AppController', 'ApiV1.Controller');
/**
 * Users Controller
 *
 * @property 
 */
class UsersController extends ApiV1AppController {

    public function get_info() {
		if ( !$this->request->is('get') ) {
            $result['errors'][] = array(
                'message' => __d('notes', 'Ошибка при передаче данных')
            );
        }else {
            $user = $this->OAuth->user();
            $result['username'] = $user['username'];
            $result['first_name'] = $user['first_name'];
            $result['last_name'] = $user['last_name'];
            $result['email'] = $user['email'];
            $result['language'] = $user['language'];
            $result['timezone'] = $user['timezone'];
            $result['created'] = $user['created'];
    		$result['modified'] = $user['modified'];
       }
       $this->set('result', $result);
       $this->set('_serialize', 'result');
    }
    
    public function config() {
		if ( $this->request->is('get') ) {
            $result = unserialize($this->OAuth->user('config'));
        }else {
            
       }
       $this->set('result', $result);
       $this->set('_serialize', 'result');
    }
}
