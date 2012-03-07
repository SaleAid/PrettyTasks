<?php
App::uses('AppController', 'Controller');

class AccountsController extends AppController {

    public $name = 'Accounts';
    public $helpers = array('Html','Js');
    public $components = array('RequestHandler');
    public $layout = 'login';
  
  
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index','login','loginzalogin','activate','reactivation','confirm_email','confirm_user_data','register');
        if ($this->Auth->user() && 
            in_array($this->params['action'], array('login',
                                                    'loginzalogin',
                                                    'activate',
                                                    'reactivation',
                                                    'confirm_email',
                                                    'confirm_user_data',
                                                    'register'
                                                )
                    )) {
			$this->redirect('/');
		}
          
    }
    
    public function isAuthorized($user){
        if($user['role'] == 'admin'){
            return true;
        }
        if(in_array($this->action, array('edit','delete','view'))){
            if($user['id'] != $this->request->params['pass'][0]){
                return false;
            }
        }
       return true;
    }
    
    public function login(){
        
        if($this->request->is('post')){
            if($this->Auth->login()){
                if($this->Session->read('Auth.User.active')){
                    $user = $this->Account->User->getUser($this->Auth->user('user_id'));
                    if($user['active']){
                        $this->redirect($this->Auth->redirect());    
                    }
                    $this->Session->setFlash('Your user profile is blocked.','alert',array('class'=>'alert-error'));
                    $this->redirect($this->Auth->logout());    
                }
                $this->Session->setFlash('Your account not active.','alert',array('class'=>'alert-info'));
                $this->redirect($this->Auth->logout());
            }else{
                $this->Session->setFlash('Your username or password was incorrect.','alert',array('class'=>'alert-error'));
            }
        }
    }
    
    public function logout(){
        $this->redirect($this->Auth->logout());
    }

	public function index() {}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
        debug($this->User->read());die;
		$this->set('user', $this->User->read(null, $id));
	}


     public function register() {
        
		if ($this->request->is('post')) {
		      if($this->Account->register($this->request->data)){
                    $resultActivate = $this->Account->activation($this->Account->getLastInsertID());
                    $this->Session->setFlash($resultActivate['msg'],'alert',array('class'=>'alert-success'));
                    $this->redirect(array('action'=>'login'));
		  	   }else{
		  	       $this->Session->setFlash(__('The user could not be saved. Please, try again.'),'alert',array('class'=>'alert-error'));
		  	   }
		}
	}
    
    public function loginzalogin(){
        
        if(!empty($this->request->data['token'])){
            $result = $this->Account->getLoginzaUser($this->request->data['token']);
            switch($result['status']){
                case 'active':{
                    $this->Auth->login($result['Account']);
                    $this->redirect($this->Auth->redirect()); break;
                }
                case 'notActive':{
                    $this->Session->write('tmpUser',$result);
                    $this->Session->setFlash('Your account not active.','alert',array('class'=>'alert-info')); 
                    $this->redirect(array('action'=>'reactivation')); break;   
                }
                case 'newUser':{
                    $this->Session->write('tmpUser',$result);
                    $this->redirect(array('action'=>'confirm_email'));  break;
                }
                case 'error':{
                    $this->Session->setFlash(__($result['msg']),'alert',array('class'=>'alert-error'));
                    $this->redirect(array('action'=>'login'));
                }
                
             }
        }
        $this->Session->setFlash(__('An unknown error'),'alert',array('class'=>'alert-error'));
		$this->redirect(array('action'=>'login'));
    }
    
    public function reactivation(){
        
        if($this->Session->check('tmpUser')){
            $user_profile = $this->Session->read('tmpUser');
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->Session->delete('tmpUser');
                $result = $this->Account->activation($user_profile['Account']['id']);
                $this->Session->setFlash($result['msg']);
                $this->redirect(array('action'=>'login'));
            }else{
                $this->request->data = $user_profile;    
            }
        }else{
            $this->redirect(array('action'=>'login'));
        }
    }
    
    public function confirm_email(){
        
         if(!$this->Session->check('tmpUser')){
                $this->redirect(array('action' => 'login'));
         }
        $user = $this->Session->read('tmpUser');
        if ($this->request->is('post') || $this->request->is('put')) {
            $user['email'] = $this->request->data['User']['email'];
            $result = $this->Account->User->checkEmail($this->request->data);
            switch($result['status']){
                case'error':{
                    $this->Session->setFlash($result['msg'] ,'alert');
                    return false;
                }    
                case 'new':{
                    $this->Session->write('tmpUser',$user);
                    $this->redirect(array('action'=>'confirm_user_data')); break;
                }
                case 'already':{
                    $user['user_id'] = $result['data']['id'];
                    if($this->Account->save($user)){
                        $resultActivate = $this->Account->activation($this->Account->getLastInsertID());
                        $this->Session->setFlash($resultActivate['msg'],'alert',array('class'=>'alert-success'));
                        $this->redirect(array('action'=>'login'));
                    }else{
                        $this->Session->setFlash('Error create account','alert',array('class'=>'alert-error'));
                        $this->redirect(array('action'=>'login'));
                    }
                    $this->Session->delete('tmpUser');
                }
            }
        }else{
           $this->request->data['User']['email'] = $user['email'];
        }
    }
    
    public function confirm_user_data(){
        
         if(!$this->Session->check('tmpUser')){
            $this->redirect(array('action' => 'login'));
         }
         $userSocial = $this->Session->read('tmpUser');
         if ($this->request->is('post') || $this->request->is('put')) {
            if($this->Account->User->save($this->request->data)){
                $saveAccount['provider'] = $userSocial['provider'];
                $saveAccount['uid'] = $userSocial['uid'];
                $saveAccount['user_id'] = $this->Account->User->getLastInsertID();
                if($this->Account->save($saveAccount)){
                    $resultActivate = $this->Account->activation($this->Account->getLastInsertID());
                    $this->Session->setFlash($resultActivate['msg']);
                }else{
                    $this->Session->setFlash('Error create user profile','alert',array('class'=>'alert-error'));
                }
                $this->redirect(array('action'=>'login'));    
                $this->Session->delete('tmpUser');    
            }else {
               $this->Session->setFlash('Error create account','alert',array('class'=>'alert-error'));
               return false;
            }
         }else{
                $this->request->data['User'] = $userSocial;
         }
    }  
  
    public function activate($hash = null) {
    	if ($hash){
            if($this->Account->activate($hash)){
                $this->Session->setFlash('Your account has been activated, please log in.','alert',array('class'=>'alert-success'));
        		return $this->redirect(array('action' => 'login'));    
            }    
       }
       $this->Session->setFlash(__('Invalid key.'));
       $this->redirect(array('action' => 'login'));
    }
    
    private function __createActivationHashAndSendEmail($id){
        
        $this->Account->id = $id;
        if (!$this->Account->exists()) {
	         throw new NotFoundException(__('Invalid user'));
        }
        
        if($this->User->createActivationHash()){
            if($this->User->sendActivationEmail()){
                $this->Session->setFlash(__('Please check email ...'));
            }else{
                $this->Session->setFlash(__('Wow error ...'));
            }
            $this->redirect(array('action' => 'login'));
        }
    }

        
    
}
