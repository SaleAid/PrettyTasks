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
                ),
                'RequestHandler',
            );
    
    public function isAuthorized($user){
        return true;
    }
	/**
	 * 
	 * Check for showing mobile version
	 * To add logic for switching to mobile and normal version
	 */    
    protected function _checkMobile(){
		//debug($this->params);
		if ((isset($this->params['device'])and ($this->params['device']=='m'))||$this->RequestHandler->isMobile ()) {
			$mobileViewFile = 'View' . DS . $this->name . '/mobile/' . $this->params ['action'] . '.ctp';
			if (file_exists ( APP . DS . $mobileViewFile )) {
				$this->layout = 'mobile';
				$mobileView = $this->name . '/mobile';
				$this->viewPath = $mobileView;
			}
		}
    }
    
    public function beforeFilter(){
    	 $this->_checkMobile();
         $this->loadModel('User');
         $this->currentUser =  $this->User->getUser($this->Auth->user('id'));
    }
    
    public function beforeRender() { 
        $this->set('currentUser', $this->currentUser); 
        $this->set('provider', $this->Auth->user('provider'));
        
    } 

    
}