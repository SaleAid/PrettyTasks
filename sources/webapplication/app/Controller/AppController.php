<?php 
class AppController extends Controller{
    public $components = array(
                'Session',
                'Auth' => array(
                    'loginAction' => array('controller' => 'users', 'action' => 'login'),
                    'loginRedirect' => array('controller' => 'profiles', 'action' => 'index'),
                    'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                    'authError' => 'You cannot access that action!',
                    'authorize' => array('Controller'),
                    //'scope' => array('User.active' => 1)
                )
            );
    
    public function isAuthorized($user){
        return true;
    }
    
    public function beforeFilter(){
        ///$this->Auth->allow('*');
        //$this->User->id = $this->Auth->user('id');
         App::import('Model', 'User'); 
         $User = new User(); 
         $User->id = $this->Auth->user('id');
         $this->currentUser = $User->read(); 
    }
    
    public function beforeRender() { 
        $this->set('currentUser', $this->currentUser); 
        
    } 

    
}