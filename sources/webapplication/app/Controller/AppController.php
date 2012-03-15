<?php 
class AppController extends Controller{
    public $components = array(
                'Session',
                'Auth' => array(
                    'loginAction' => array('controller' => 'users', 'action' => 'login'),
                    'loginRedirect' => array('controller' => 'tasks', 'action' => 'index'),
                    'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                    'authError' => 'You cannot access that action!',
                    'authorize' => array('Controller'),
                    'authenticate' => array('Form' => array('userModel' => 'User')), 
                )
            );
    
    public function isAuthorized($user){
        return true;
    }
    
    public function beforeFilter(){
         $this->loadModel('User');
         $this->currentUser =  $this->User->getUser($this->Auth->user('id'));
    }
    
    public function beforeRender() { 
        $this->set('currentUser', $this->currentUser); 
        
    } 

    
}