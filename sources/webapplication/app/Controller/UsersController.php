<?php
App::uses('AppController', 'Controller');


class UsersController extends AppController {

    public $name = 'Users';
    public $helpers = array('Html','Js');
    
    public function beforeFilter(){
        parent::beforeFilter();
        
    }
    public function isAuthorized($user){
      return true;
    }
    
    public function index(){
        //debug($this->Auth->user());
        $this->layout = 'profile';
        $this->User->id = $this->Auth->user('user_id');
        $this->paginate= array('conditions' => array('User.id' => $this->Auth->user('user_id')));
        $users = $this->paginate('User');
        $this->set('user', $users[0]);
    }
    
 
}