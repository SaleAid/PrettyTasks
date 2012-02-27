<?php
App::uses('AppModel', 'Model');
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
        //debug($this->data);
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
    
}
