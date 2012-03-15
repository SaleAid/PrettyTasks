<?php
App::uses('AppController', 'Controller');

class AccountsController extends AppController {

    public $name = 'Accounts';
    public $helpers = array('Html','Js');
    public $components = array('RequestHandler','Recaptcha.Recaptcha' => array('actions' => array('register'),'error' => 'tratra'));
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
       return true;
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
                    $this->Session->setFlash(__('Your account not active.','alert',array('class'=>'alert-info'))); 
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
    
      
    
}
