<?php
App::uses('AppController', 'Controller');
/**
 * App Controller
 *
 */
class ApiV2AppController extends AppController {
    
    public $components = array('OAuth.OAuth');
    
    public function beforeFilter() {
        $this->Auth->allow($this->OAuth->allowedActions);
    }
    
    
}
