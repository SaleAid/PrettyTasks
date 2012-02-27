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
        //debug($this->Profile->read());
        
    }
    
 
}