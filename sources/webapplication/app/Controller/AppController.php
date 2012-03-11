<?php 
class AppController extends Controller{
    public $components = array(
                'Session',
                'Auth' => array(
                    'loginAction' => array('controller' => 'accounts', 'action' => 'login'),
                    'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
                    'logoutRedirect' => array('controller' => 'accounts', 'action' => 'login'),
                    'authError' => 'You cannot access that action!',
                    'authorize' => array('Controller'),
                    'authenticate' => array('Form' => array('userModel' => 'Account')), 
                )
            );
    
    public function isAuthorized($user){
        return true;
    }
    
    public function beforeFilter(){
         $this->loadModel('User');
         $this->currentUser =  $this->User->getUser($this->Auth->user('user_id'));
    }
    
    public function beforeRender() { 
        $this->set('currentUser', $this->currentUser); 
        
    } 

    
}