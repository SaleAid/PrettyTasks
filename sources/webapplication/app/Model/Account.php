<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');

App::import('Vendor', 'loginza'.DS.'LoginzaAPI');
App::import('Vendor', 'loginza'.DS.'LoginzaUserProfile');
/**
 * User Model
 *
 */
class Account extends AppModel {
    
    public $name = 'Account';
    public $belongsTo = 'User';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'Not empty' => array(
				'rule' => array('notempty'),
				'message' => 'Your custom message here',
			),
            'isUnique' => array(
                'rule'    => 'isUnique',
                'message' => 'A user with that username already exists.'
            ),
		),
		'password' => array(
			'Not empty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter your password.',
			),
            'Match password' => array(
                'rule' => 'matchPasswords',
                'message' => 'You password do not match.'
            ),
		),
        'password_confirm' => array(
            'Not empty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password.'
            )
        ),
    	'user_id' => array(
		'Not empty' => array(
			'rule' => array('notempty'),
			//'message' => 'Your custom message here',
            )
        ),
	);
    
    public function matchPasswords($data){
        if($data['password'] == $this->data['Account']['password_confirm']){
            return true;
        }
        $this->invalidate('password_confirm','You password do not match.');
        return false;
    }
    public function beforeSave(){
        if(isset($this->data['Account']['password'])){
            $this->data['Account']['password'] = AuthComponent::password($this->data['Account']['password']);
        }
        return true;
    }
    
    public function createActivationHash(){
        if (!isset($this->id)) {
			return false;
		}
        $hash = Security::hash(Configure::read('Security.salt') . mt_rand(). $this->field('created') . mt_rand());
		$this->saveField('hash_key', $hash);
        return true;
	}
    
    public function sendActivationEmail(){
        if (!isset($this->id)) {
			return false;
		}
        $this->read();
        $activate_url = 'http://' . env('SERVER_NAME') . '/accounts/activate/'.$this->data['Account']['hash_key'];
		$username = $this->data['User']['first_name'].' '.$this->data['User']['last_name'];
        $email = new CakeEmail();
        $email->config('gmail');
        $email->template('confirmation_email')
                ->viewVars(array('activate_url' => $activate_url, 'username' => $username))
                ->emailFormat('html')
                ->to($this->data['User']['email'])
                ->from('noreply@' . env('SERVER_NAME'))
                ->subject('Активация аккаунта')
                ;
        return $email->send();
    }
    
    public function activate($hash){
        if($user_profile = $this->findByHash_key($hash)){
    	        $this->id = $user_profile['Account']['id'];
        	    $this->saveField('active', 1);
                $this->saveField('hash_key', null);
                return true;
    	}
        return false;
    }
    
    public function activation($id){
        $this->id = $id;
        if (!$this->exists()) {
	        return array('status' => 'error', 'msg' => 'Invalid user. User not exists');
        }
        if($this->createActivationHash()){
            if($this->sendActivationEmail()){
                return array('status' => 'normal', 'msg' => 'Please check email ...');
            }
            return array('status' => 'error', 'msg' => 'Wow error ...');
        }
        return array('status' => 'error', 'msg' => 'Invalid user ');
    }
    
    
    public function getLoginzaUser($token){
        $LoginzaAPI = new LoginzaAPI();
        $UserProfile = $LoginzaAPI->getAuthInfo($token,Configure::read('loginza.id'),md5($token.Configure::read('loginza.skey')));
        if (isset($UserProfile->error_type)){
            $data['status'] = 'error';
            $data['msg'] = $UserProfile->error_message;
            return $data;
        }
        switch($UserProfile->provider){
            case strpos($UserProfile->provider, 'twitter') == true:{
                    $tmp = explode(' ',$UserProfile->name->full_name);
                    if(isset($tmp[1])){
                        $data['last_name'] = $tmp[1];
                    }else{
                        $data['last_name'] = '';
                    }
                    $data['first_name'] = $tmp[0];
                    $data['provider'] = 'twitter';
                    $data['uid'] = $UserProfile->uid;
                    $data['email'] = ''; break;
            }
            case strpos($UserProfile->provider, 'vkontakte') == true:{
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['email'] = '';
                    $data['provider'] = 'vkontakte'; break;
            }
            case strpos($UserProfile->provider, 'google') == true:{
                    $data['provider'] = 'google';
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['email'] = $UserProfile->email; break;
            }
            case strpos($UserProfile->provider, 'facebook')!== true:{
                    $data['provider'] = 'facebook';
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['email'] = $UserProfile->email; break;
            }
            default:{
                    $data['status'] = 'error';
                    $data['msg'] = 'Bad provider';
                    return $data;
            }
        }
        $result = $this->findByUidAndProvider($data['uid'],$data['provider']);
        if(!$result){
            $data['status'] = 'newUser';
            return $data;
        }
        if(!$result['User']['active']){
            return array('status' => 'error', 'msg' => 'Your user profile is blocked.');
        }elseif($result['Account']['active']){
            $data['status'] = 'active';    
            return array_merge((array)$result,(array)$data);    
        }else{
            $data['status'] = 'notActive';
            return array_merge((array)$result,(array)$data);   
        } 
        
        return false;
    }
    
 
   public function register($data){
    
        if ($this->saveAll($data, array('validate' => 'only'))) {
            $user = $this->User->findByEmail($data['User']['email']);
            if(empty($user)){
                if(!$this->User->save($data['User'])){
                    return false;    
                }   
                $data['Account']['user_id'] =  $this->User->getLastInsertID();
            }else{
                $data['Account']['user_id'] = $user['User']['id'];    
            }
            $data['Account']['provider'] = 'local';
            debug($data);
            if($this->save($data['Account'])){
                $this->activation($this->getLastInsertID());
                return true;    
            }
        }
        return false; 
   }
   
  
    
    
}




