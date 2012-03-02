<?php
App::uses('AppController', 'Controller');


class ProfilesController extends AppController {

    public $name = 'Profiles';
    public $helpers = array('Html','Js');
    
    public function beforeFilter(){
        parent::beforeFilter();
        
    }
    public function isAuthorized($user){
      return true;
    }
    
    public function index(){
        $this->layout = 'profile';
        $this->Profile->id = $this->Auth->user('profile_id');
        //$this->Profile->recursive = 0;
        $this->paginate= array('conditions' => array('Profile.id' => $this->Auth->user('profile_id')));
        $users = $this->paginate('Profile');
        //debug( $users[0]);
        $this->set('user', $users[0]);
        
        
    }
    
 
}