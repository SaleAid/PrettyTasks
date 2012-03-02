<?php
App::uses('AppModel', 'Model');
App::import('Vendor', 'loginza'.DS.'LoginzaAPI');
App::import('Vendor', 'loginza'.DS.'LoginzaUserProfile');
/**
 * User Model
 *
 */
class User extends AppModel {
    
    public $name = 'User';
    public $belongsTo = 'Profile';
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
	);
    
    public function matchPasswords($data){
        if($data['password'] == $this->data['User']['password_confirm']){
            return true;
        }
        $this->invalidate('password_confirm','You password do not match.');
        return false;
    }
    public function beforeSave(){
        if(isset($this->data['User']['password'])){
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
    
    public function createActivationHash(){
        if (!isset($this->id)) {
			return false;
		}
        $hash = Security::hash(Configure::read('Security.salt') . $this->field('created') . mt_rand());
		$this->saveField('hash_key', $hash);
        return true;
	}
    
    public function sendActivationEmail(){
        if (!isset($this->id)) {
			return false;
		}
        $this->read();
        $activate_url = 'http://' . env('SERVER_NAME') . '/users/activate/'.$this->data['User']['hash_key'];
		$username = $this->data['Profile']['first_name'].' '.$this->data['Profile']['last_name'];
        
        $email = new CakeEmail();
        $email->config('gmail');
        $email->template('user_confirm')
                ->viewVars(array('activate_url' => $activate_url, 'username' => $username))
                ->emailFormat('text')
                ->to($this->data['Profile']['email'])
                ->from('noreply@' . env('SERVER_NAME'))
                ->sendAs = 'text'
                 ;
        return $email->send();
    }
    
    public function activate($hash){
        if($user_profile = $this->findByHash_key($hash)){
    	        $this->id = $user_profile['User']['id'];
        	    $this->saveField('active', 1);
                $this->saveField('hash_key', null);
                return true;
    	}
        return false;
    }
    
    public function getLoginzaUserInfo($token){
        $skey = '21013aca17787a9d1b8cf4be7c7f5aeb';
        $id = '14377';
        $LoginzaAPI = new LoginzaAPI();
        $UserProfile = $LoginzaAPI->getAuthInfo($token,$id,md5($token.$skey));
        if (isset($UserProfile->error_type)){
            $data['error'] = $UserProfile;
            return $data;
        }
        if(strpos($UserProfile->provider, 'twitter')!== false){
            $tmp = explode(' ',$UserProfile->name->full_name);
            if(isset($tmp[1])){
                $data['last_name'] = $tmp[1];
            }else{
                $data['last_name'] = '';
            }
            $data['first_name'] = $tmp[0];
            $data['provider'] = 'twitter';
            $data['uid'] = $UserProfile->uid;
            $data['email'] = '';
        }elseif(strpos($UserProfile->provider, 'vkontakte')!== false) {
            $data['uid'] = $UserProfile->uid;
            $data['first_name'] = $UserProfile->name->first_name;
            $data['last_name'] = $UserProfile->name->last_name;
            $data['email'] = '';
            $data['provider'] = 'vkontakte';
        }else{
            $data['uid'] = $UserProfile->uid;
            $data['first_name'] = $UserProfile->name->first_name;
            $data['last_name'] = $UserProfile->name->last_name;
            $data['email'] = $UserProfile->email;
            if(strpos($UserProfile->provider, 'google')!== false){
                $data['provider'] = 'google';
             }elseif(strpos($UserProfile->provider, 'facebook')!== false){
                $data['provider'] = 'facebook';
             }
        }
        return $data;
    }
    
}
