<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

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
        $this->Auth->allow('login','loginzalogin','activate','reactivation','confirm_email','confirm_user_data','registration');
          
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
        $this->layout = 'login';
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
	   $this->User->id = $this->Auth->user('id');
           $this->redirect(array('controller'=>'profiles','action'=>'index'));
        //debug($this->User->read());die;
           
        
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
        debug($this->User->read());die;
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
            $loginzaUserInfo = $this->User->getLoginzaUserInfo($this->request->data['token']);
            if($loginzaUserInfo['error']){
                $this->Session->setFlash(__($loginzaUserInfo['error']->error_type.': '.$loginzaUserInfo['error']->error_message));
                $this->redirect(array('controller'=>'users','action'=>'login'));
            }
            $result = $this->User->findByUidAndProvider($loginzaUserInfo['uid'],$loginzaUserInfo['provider']);
            if(!$result){
                $this->Session->write('userSocial',$loginzaUserInfo);
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
            if ($this->request->is('post')) {
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
         if(!$this->Session->check('userSocial')){
                $this->redirect(array('action' => 'login'));
         }
        $userSocial = $this->Session->read('userSocial');
        if ($this->request->is('post')) {
                if ($this->User->Profile->saveAll($this->request->data, array('validate' => 'only'))) {
                    $userSocial['email'] = $this->request->data['Profile']['email'];
                    $this->Session->write('userSocial',$userSocial);
                    $this->redirect(array('action'=>'confirm_user_data'));
                } else {
                    $this->Session->setFlash(__('The email incorrect. Please, try again.'));
                    return false;
                }
        }else{
           $this->request->data['Profile']['email'] = $userSocial['email'];
        }
    }
    
    public function confirm_user_data(){
        if($this->Auth->user()){
            $this->Session->setFlash(__('You already active  ...'));
            $this->redirect(array('action' => 'index'));
         }
         if(!$this->Session->check('userSocial')){
            $this->redirect(array('action' => 'login'));
         }
         $userSocial = $this->Session->read('userSocial');
         if ($this->request->is('post')) {
            if ($this->User->Profile->saveAll($this->request->data, array('validate' => 'only'))) {
                $profile = $this->User->Profile->findByEmail($userSocial['email']);
                $saveUser['User']['provider'] = $userSocial['provider'];
                $saveUser['User']['uid'] = $userSocial['uid'];
                if($profile){
                    $saveUser['User']['profile_id'] = $profile['Profile']['id'];
                }else{
                    if(!$this->User->Profile->save($this->request->data)){
                        throw new NotFoundException(__('An unknown error'));
                    }
                    $saveUser['User']['profile_id'] = $this->User->Profile->getLastInsertID();
                }
                if($this->User->save($saveUser['User'])){
                    $this->Session->setFlash(__('The user has been saved.'));
                    $this->__createActivationHashAndSendEmail($this->User->getLastInsertID());
    				$this->redirect(array('action' => 'login'));
                    $this->Session->delete('userSocial');
                }
            }else {
                 $this->Session->setFlash(__('The user incorrect. Please, try again.'));
                 return false;
            }
         }else{
            $profile = $this->User->Profile->findByEmail($userSocial['email']);
            if($profile){
                $this->set('profile_id',true);
                $this->request->data['Profile'] = $profile['Profile'];
            }else{
                $this->request->data['Profile'] = $userSocial;
                $this->request->data['Profile']['email'] = $userSocial['email'];
            }
         }
    }  
  
    public function activate($hash = null) {
    	if ($hash){
            if($this->User->activate($hash)){
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
