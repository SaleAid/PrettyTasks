<?php
App::uses('Account', 'Model');
/**
 * User Model
 *
 */
class AccountSocial extends Account {
    
    public $name = 'AccountSocial';
    
    /**
     * Table that is used
     *
     * @var string
     */
	public $useTable = 'accounts';
    
    //public $belongsTo = 'User';

    /**
     * Validation domain
     *
     * @var string
     */
    public $validationDomain = 'accounts';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            ),
        	'uuid'
        ), 
        'provider' => array(
             'notEmpty' => array(
                'rule' => array(
                    'notEmpty'
                ), 
                'message' => 'Поле должно быть заполнено'
             ),
        ),
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ),
        'created' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            ), 
            'notempty' => array(
                'rule' => array(
                    'notempty'
                )
            )
        ), 
        'modified' => array(
            'datetime' => array(
                'rule' => array(
                    'datetime'
                )
            ), 
            'notempty' => array(
                'rule' => array(
                    'notempty'
                )
            )
        ),  
        
    );
    
    public function check($auth){
        $data = array();
        $provider = strtolower($auth['provider']);
        $uid = $auth['uid'];
        $info = $auth['info'];
        switch ($provider) {
            case 'google' : {
                $result = $this->_findAccount(array('provider' => $provider, 'email' => $info['email']));
                break;
            }
            default: {
                $result = $this->_findAccount(array('provider' => $provider, 'uid' => $uid));
            }
        }
        if($result){
            if($this->_isActive($result)){
                $data['status'] = 1; //active
                $data['data'] = $result['User'];
                $data['data']['account_id'] = $result[$this->alias]['id'];
            } else {
                $data['status'] = 0; //notActive
                $data['data'] = $result[$this->alias];
            }
            $data['data']['full_name'] = !empty($info['name']) ? $info['name'] : $result[$this->alias]['full_name'];
        } else {
            $result = $this->_createAccount($provider, $uid, $info);
            if($result){
                $data['status'] = 0; // newAccount
                $data['data'] = $result[$this->alias];    
            }else {
                $data['status'] = 2; // error
                $data['errors'] = $this->validationErrors;
            }
        }
        $data['data']['provider'] = $provider;
        return $data;
    }
    
    private function _findAccount($data){
           return $this->find('first', array('conditions' => array($data)));
    }
    
    private function _isActive($data){
           return $data[$this->alias]['active'];
    }
    
    private function _createAccount($provider, $uid, $info){
        $data = array(
            'provider' => $provider,
            'uid' => $uid,
            'full_name' => $info['name'],
            'email' => isset($info['email']) ? $info['email'] : null
        ); 
        $this->create();
        return $this->save($data);
    }

}
