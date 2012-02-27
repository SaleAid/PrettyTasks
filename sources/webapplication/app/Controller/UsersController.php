<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'loginza'.DS.'LoginzaAPI');
App::import('Vendor', 'loginza'.DS.'LoginzaUserProfile');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

    public $name = 'Users';
    public $helpers = array('Html','Js');
    
    private $param_loginza = array(
                'token_url'=>'https://loginza.ru/api/widget?token_url=',
                'widget_url'=>'http://loginza.ru/js/widget.js',
                'return_url'=>'http://learning-2012.org.ua/users/loginzalogin',
                   
            );
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('login','loginzalogin','activate','reactivation','confirm_email','registration');
          
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
        if($this->Auth->user()){
            $this->redirect($this->Auth->redirect());    
        }
        if($this->request->is('POST')){
            if($this->Auth->login()){
                if($this->Session->read('Auth.User.active')){
                    $this->redirect($this->Auth->redirect());    
                }
                $this->Session->setFlash('Your account not active.');
                $this->redirect($this->Auth->logout());
            }else{
                $this->Session->setFlash('Your username or password was incorrect.');
            }
        }
       $this->set('param', $this->param_loginza);  
    }
    
    public function logout(){
        $this->redirect($this->Auth->logout());
    }
/**
 * index method
 *
 * @return void
 */ 
	public function index() {
		$this->User->recursive = 0;
        $this->set('users', $this->paginate());
	}

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
		$this->set('user', $this->User->read(null, $id));
	}


/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void 
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
    

     public function registration() {
        
		if ($this->request->is('post')) {
		  	   if ($this->User->saveAll($this->request->data, array('validate' => 'only'))) {
                    $profile = $this->User->Profile->findByEmail($this->request->data['Profile']['email']);
                    if (empty($profile)){
                        if(!$this->User->Profile->save($saveUser['Profile'])){
                                throw new NotFoundException(__('An unknown error'));
                        }
                        $profile_id = $this->User->Profile->getLastInsertID();
                    }else {
                        $profile_id = $profile['Profile']['id'];
                        $result = $this->User->findByProviderAndActiveAndProfile_id('local',1,$profile_id);
                        if(!empty($result)){
                            $this->Session->setFlash(__('The user could not be saved, because... email already exists.'));
                            return false;
                        }
                    }
                 $this->request->data['User']['profile_id'] = $profile_id;
                 $this->request->data['User']['provider'] = 'local';
                 if(!$this->User->save($this->request->data['User'])){
                    throw new NotFoundException(__('An unknown error'));
                 }
                 $this->__createActivationHashAndSendEmail($this->User->getLastInsertID());
            	 $this->Session->setFlash(__('The user has been saved and ...'));
                 $this->redirect(array('action' => 'login'));
                 
	       }else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}
    
    public function loginzalogin(){
        
        if(!empty($this->request->data['token'])){
            $LoginzaAPI = new LoginzaAPI();
            $UserProfile = $LoginzaAPI->getAuthInfo($this->request->data['token'],'14377',md5($this->request->data['token'].'21013aca17787a9d1b8cf4be7c7f5aeb'));
            if (isset($UserProfile->error_type)){
                $this->Session->setFlash(__($UserProfile->error_type.': '.$UserProfile->error_message));
                $this->redirect(array('controller'=>'users','action'=>'login'));
            }
            $userSocial = array();
            if(strpos($UserProfile->provider, 'twitter')!== false){
                list($userSocial['first_name'],$userSocial['last_name']) = explode(' ',$UserProfile->name->full_name);
                $userSocial['provider'] = 'twitter';
                $userSocial['uid'] = $UserProfile->uid;
                $userSocial['email'] = '';
            }elseif(strpos($UserProfile->provider, 'vkontakte')!== false) {
                $userSocial['uid'] = $UserProfile->uid;
                $userSocial['first_name'] = $UserProfile->name->first_name;
                $userSocial['last_name'] = $UserProfile->name->last_name;
                $userSocial['email'] = '';
                $userSocial['provider'] = 'vkontakte';
            }else{
                $userSocial['uid'] = $UserProfile->uid;
                $userSocial['first_name'] = $UserProfile->name->first_name;
                $userSocial['last_name'] = $UserProfile->name->last_name;
                $userSocial['email'] = $UserProfile->email;
                if(strpos($UserProfile->provider, 'google')!== false){
                    $userSocial['provider'] = 'google';
                 }elseif(strpos($UserProfile->provider, 'facebook')!== false){
                    $userSocial['provider'] = 'facebook';
                 }
             }
             $result = $this->User->findByUidAndProvider($userSocial['uid'],$userSocial['provider']);
             if(!$result){
                $this->Session->write('userSocial',$userSocial);
                $this->redirect(array('controller'=>'users','action'=>'confirm_email'));
            } 
             if($result['User']['active']){
                    $this->Auth->login($result['User']);
                    $this->redirect($this->Auth->redirect());    
             }
             $this->Session->write('confirm_ative',$result);
             $this->Session->setFlash('Your account not active.'); 
             $this->redirect(array('controller'=>'users','action'=>'reactivation'));        
        }else {
            $this->Session->setFlash(__('An unknown error'));
			$this->redirect(array('controller'=>'users','action'=>'login'));
        }
    }
    
    public function reactivation(){
        
        if($this->Auth->user()){
            $this->Session->setFlash(__('You already active  ...'));
            $this->redirect(array('action' => 'index'));
         }
        if($this->Session->check('confirm_ative')){
            $user_profile = $this->Session->read('confirm_ative');
            $this->request->data = $user_profile;
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->__createActivationHashAndSendEmail($user_profile['User']['id']);
                $this->Session->delete('confirm_ative');
            }
        }else{
            $this->redirect($this->Auth->redirect());
        }
    }
    
    public function confirm_email(){
        
         if($this->Auth->user()){
            $this->Session->setFlash(__('You already active  ...'));
            $this->redirect(array('action' => 'index'));
         }
        
        if($this->Session->check('userSocial')){
            $newUser['Profile'] = $this->Session->read('userSocial');
            $profile = $this->User->Profile->findByEmail($newUser['Profile']['email']);
            if($profile){
                $newUser['User']['profile_id'] = $profile['Profile']['id'];
            }
            $this->Session->write('new_user', $newUser);
            $this->request->data = $newUser;
            $this->set('user',$newUser);
            $this->Session->delete('userSocial');
         }elseif($this->Session->check('new_user')){
            if ($this->request->is('post')) {
                if ($this->User->Profile->saveAll($this->request->data, array('validate' => 'only'))) {
                    $newUser = $this->Session->read('new_user');
                    $saveUser['User']['provider'] = $newUser['Profile']['provider'];
                    $saveUser['User']['uid'] = $newUser['Profile']['uid'];
                    if(!empty($newUser['User']['profile_id'])){
                        $saveUser['User']['profile_id'] = $newUser['User']['profile_id'];
                    }else{
                        $profile = $this->User->Profile->findByEmail($this->request->data['Profile']['email']);
                        if($profile){
                            $saveUser['User']['profile_id'] = $profile['Profile']['id'];
                        }else{
                            $saveUser['Profile']['first_name'] = $newUser['Profile']['first_name'];
                            $saveUser['Profile']['last_name'] = $newUser['Profile']['last_name'];
                            $saveUser['Profile']['email'] = $this->request->data['Profile']['email'];
                            if(!$this->User->Profile->save($saveUser['Profile'])){
                                throw new NotFoundException(__('An unknown error'));
                            }
                            $saveUser['User']['profile_id'] = $this->User->Profile->getLastInsertID();
                        }
                        
                    }
                     if($this->User->save($saveUser['User'])){
                            $this->Session->setFlash(__('The user has been saved.'));
                            $this->__createActivationHashAndSendEmail($this->User->getLastInsertID());
            				$this->redirect(array('action' => 'login'));
                            $this->Session->delete('new_user');
                    }
                }else {
                    $this->set('user',$this->Session->read('new_user'));
                    $this->Session->setFlash(__('The email could not be saved. Please, try again.'));
                }        
        }else{
            $this->Session->setFlash(__(' Please, try again.'));
            $this->redirect(array('controller' => 'users', 'action' => 'login'));    
        }
      }  
    }
  
    
    public function activate($hash = null) {
    	
    	if ($hash){
    	    if($user_profile = $this->User->findByHash_key($hash)){
    	        $this->User->id = $user_profile['User']['id'];
        	    $this->User->saveField('active', 1);
                $this->User->saveField('hash_key', null);
                $this->Session->setFlash('Your account has been activated, please log in.');
        		$this->redirect(array('action' => 'login'));
    	    }
    	}
       $this->Session->setFlash(__('Invalid key.'));
       $this->redirect(array('action' => 'login'));
    }
    
    private function __createActivationHashAndSendEmail($id){
        $this->User->id = $id;
        if (!$this->User->exists()) {
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
