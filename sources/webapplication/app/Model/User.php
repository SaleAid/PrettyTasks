<?php
App::uses('AppModel', 'Model');
/**
 * Profile Model
 *
 * @property User $User
 */
class User extends AppModel {
    
    public $hasMany ='Account'; 
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'first_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'Email' => array(
				'rule' => array('email'),
				'message' => 'Please, enter valid email.',
			),
          //'isUnique' => array(
//                'rule'    => 'isUnique',
//                'message' => 'This email address is already in use. Please supply a different email address.'
//            ),
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
	);

    
    public function checkEmail($data){
        $this->set($data);
        if ($this->validates(array('fieldList' => array('email')))) {
            $profile = $this->findByEmail($data['User']['email']);
            if($profile){
                return array('status' => 'already', 
                                         'data' =>$profile['User'] );
            }
            return array('status' => 'new');
        }
        return array('status' => 'error', 'msg' => 'The email incorrect. Please, try again.');
    }
    
   public function getUser($id){
        $this->unbindModel(array('hasMany' => array('Account')));
        return $this->findByIdAndActive($id,'1');
   }
 

}
