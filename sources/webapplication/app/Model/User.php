<?php
App::uses('AppModel', 'Model');
/**
 * Profile Model
 *
 * @property User $User
 */
class User extends AppModel {
    
    public $name = 'User';
    public $hasMany ='Account'; 
    public $actsAs = array('Activation');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
        
       
                    'first_name' => array(
            			'notempty' => array(
            				'rule' => array('notempty'),
            				//'message' => 'Your custom message here',
            			),
            		),
            		'last_name' => array(
            			'notempty' => array(
            				'rule' => array('notempty'),
            				//'message' => 'Your custom message here',
            			),
                    ),
                    'created' => array(
            			'datetime' => array(
            				'rule' => array('datetime'),
            			),
            			'notempty' => array(
            				'rule' => array('notempty'),
            			),
            		),
            		'modified' => array(
            			'datetime' => array(
            				'rule' => array('datetime'),
            			),
            		),
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
                    'old_password' => array(
            			'Not empty' => array(
            				'rule' => array('notEmpty'),
            				'message' => 'Please enter your password.',
            			),
                        'Match old password' => array(
                            'rule' => 'matchOldPasswords',
                            'message' => 'You password do not match.'
                        ),
            		),

                'email' => array(
            			'Email' => array(
            				'rule' => array('email'),
            				'message' => 'Please, enter valid email.',
            			),
                        'Not empty' => array(
            				'rule' => array('notEmpty'),
            				'message' => 'Please enter your password.',
            			),
               ),
    );
    
    public $virtualFields = array(
        'full_name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );

 

    
    public function matchPasswords($data){
        if($data['password'] == $this->data[$this->alias]['password_confirm']){
            return true;
        }
        $this->invalidate('password_confirm','You password do not match.');
        return false;
    }
    
    public function matchOldPasswords($data) {
	   	$password = $this->field('password', array($this->alias . '.id' => $this->data[$this->alias]['id']));
		if ($password === Security::hash($data['old_password'], null, true)) {
			return true;
		}
        return false;
	}
    
    public function password_change($data) {
        $this->set($data);
        if ($this->validates()) {
            $data[$this->alias]['password'] = AuthComponent::password($data[$this->alias]['password']);
            $this->saveField('password', $data[$this->alias]['password']);
            $this->saveField('password_token', null);
            return true;
        }
        return false;
    }
    
    public function checkPasswordToken($token){
       
       $user = $this->find('first',array(
                                        'conditions' => array($this->alias . '.password_token' => $token),
                                        'fields' => array($this->alias .'.id'))
                            );
       return  $user[$this->alias]['id'];
    }
    
    public function password_resend($id){
        
        $this->id = $id;
        if (!$this->exists()) {
	        return false;
        }
        $this->saveField('password_token',$this->generateToken());
        if($this->sendPasswordResend($id)){
            return true;
        }
        return false;
    }
    
    public function validateEmail($data){
        $this->set($data);
        if ($this->validates(array('fieldList' => array('email')))) {
            return true;
        }
        return false;
    }
    
    public function checkEmail($data){
        $this->set($data);
        if ($this->validates(array('fieldList' => array('email')))) {
            $user = $this->findByEmail($data[$this->alias]['email']);
            if($user){
                return $user[$this->alias]['id'];
            }
            return false;
        }
        return false;
    }
    
   public function register($data){
    
        $this->validate['email']['isUnique'] = array(
                            'rule'    => 'isUnique',
                            'message' => 'This email address is already in use. Please supply a different email address.'
                        );
        $this->set($data);
        if($this->validates()) {
            $data[$this->alias]['password'] = AuthComponent::password($data[$this->alias]['password']);
            $data[$this->alias]['activate_token'] = $this->generateToken();
            if($this->save($data[$this->alias],false)){
                return true;    
           }
        }
        return false;
   }
   
   public function reactivate($data,$controllerName){
        $data[$this->alias]['email'] =  $data['email'];
        $this->set($data);
        if ($this->validates(array('fieldList' => array('email')))) {
            $user = $this->findByEmailAndActive($data['email'],0);
            if($user){
                $this->set($user);
                $this->saveField('activate_token',$this->generateToken());
                return $this->sendActivationAccount( $user[$this->alias]['id'], $controllerName);
            }
            return false;
        }
   }
   
    public function sendPasswordResend($id){
        
        $this->id = $id;
        $this->read();
        $email = new CakeEmail('default');
        $email->viewVars(array( 
                                'password_token' => $this->data[$this->alias]['password_token'], 
                                'fullname' => $this->data[$this->alias]['first_name'].' '.$this->data[$this->alias]['last_name'],
                                'username' => $this->data[$this->alias]['username']))
              ->to($this->data[$this->alias]['email'])
                ;
        return $email->subject('PasswordResend')->send();
    }
    
//    public function sendActivationAccount($id){
//        $this->id = $id;
//        if (!$this->exists()) {
//	        return false;
//        }
//        $this->read();
//        $email = new CakeEmail('activate_account');
//        $email->viewVars(array( 
//                                'activate_token' => $this->data[$this->alias]['activate_token'], 
//                                'fullname' => $this->data[$this->alias]['first_name'].' '.$this->data[$this->alias]['last_name']))
//              ->to($this->data[$this->alias]['email'])
//                ;
//        return $email->send();
//    }
//    
//    public function activate($token){
//        if($user = $this->findByActivate_token($token)){
//    	        $this->id = $user[$this->alias]['id'];
//        	    $this->saveField('active', 1);
//                $this->saveField('activate_token', null);
//                return true;
//    	}
//        return false;
//    }
//
   
   public function generateToken(){
        return Security::hash(mt_rand().Configure::read('Security.salt') .  time() . mt_rand());
   }
//----------------

  


   public function getUser($id){
        $this->unbindModel(array('hasMany' => array('Account')));
        return $this->findByIdAndIs_blocked($id,0);
   }
   
   public function getConfig($id){
       $this->contain();
       $config = $this->find('first', array('conditions' => array('User.id' => $id),'fields' => array('User.config'),));
       $config = unserialize($config['User']['config']);
       return $config; 
   }
    
   public function setConfig($id, $config){
       $this->id = $id;
       $this->saveField('config', serialize($config));
       return true;
   }

}
