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
		
    	'user_id' => array(
		'Not empty' => array(
			'rule' => array('notempty'),
			//'message' => 'Your custom message here',
            )
        ),
	);
    

    
    public function createActivationHash(){
        if (!isset($this->id)) {
			return false;
		}
        $hash = Security::hash(mt_rand().Configure::read('Security.salt') .  $this->field('created') . mt_rand());
		$this->saveField('activate_token', $hash);
        return true;
	}
    
    public function sendActivationEmail(){
        if (!isset($this->id)) {
			return false;
		}
        $this->read();
        $email = new CakeEmail('activate_account');
        $email->viewVars(array('activate_token' => $this->data['Account']['activate_token'], 
                                'fullname' => $this->data['User']['first_name'].' '.$this->data['User']['last_name']))
              ->to($this->data['User']['email'])
                ;
        return $email->send();
    }
    
    public function activate($hash){
        if($user_profile = $this->findByEmail_token($hash)){
    	        $this->id = $user_profile['Account']['id'];
        	    $this->saveField('active', 1);
                $this->saveField('email_token', null);
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
        $data['identity'] = $UserProfile->identity;
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
    
 

   
  
    
    
}




