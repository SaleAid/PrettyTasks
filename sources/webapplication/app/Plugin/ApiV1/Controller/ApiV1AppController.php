<?php
App::uses('AppController', 'Controller');
/**
 * App Controller
 *
 */
class ApiV1AppController extends AppController {
    
    public $components = array('OAuth.OAuth');
    
    public function beforeFilter() {
		$this->Auth->allow($this->OAuth->allowedActions);
    }
}
