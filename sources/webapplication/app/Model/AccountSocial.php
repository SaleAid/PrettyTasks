<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('Account', 'Model');

/**
 * AccountSocial Model
 */
class AccountSocial extends Account {
    
    /**
     *
     * @var unknown_type
     */
    public $name = 'AccountSocial';
    
    /**
     * Table that is used
     *
     * @var string
     */
    public $useTable = 'accounts';
    
    // public $belongsTo = 'User';
    
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
                    'numeric'
            ),
            'provider' => array(
                    'notEmpty' => array(
                            'rule' => array(
                                    'notEmpty'
                            ),
                            'message' => 'Поле должно быть заполнено'
                    )
            ),
            'user_id' => array(
                    'maxLength' => array(
                            'rule' => array(
                                    'maxLength',
                                    36
                            ),
                            'message' => 'Wrong ID'
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
            )
    );

    /**
     *
     * @param unknown_type $auth            
     * @return string
     */
    public function check($auth) {
        $data = array();
        $provider = strtolower($auth['provider']);
        $uid = $auth['uid'];
        $info = $auth['info'];
        switch ($provider) {
            case 'google' :
                {
                    $result = $this->_findAccount(array(
                            'provider' => $provider,
                            'or' => array( 
                                'email' => $info['email'],
                                'uid' => $uid
                            )
                    ));
                    break;
                }
            default :
                {
                    $result = $this->_findAccount(array(
                            'provider' => $provider,
                            'uid' => $uid
                    ));
                }
        }
        if ($result) {
            if ($this->_isActive($result)) {
                $data['status'] = 1; // active
                $data['data'] = $result['User'];
                $data['data']['account_id'] = $result[$this->alias]['id'];
            } else {
                $data['status'] = 0; // notActive
                $data['data'] = $result[$this->alias];
            }
            $data['data']['full_name'] = ! empty($info['name']) ? $info['name'] : $result[$this->alias]['full_name'];
        } else {
            $result = $this->_createAccount($provider, $uid, $info);
            if ($result) {
                $data['status'] = 0; // newAccount
                $data['data'] = $result[$this->alias];
            } else {
                $data['status'] = 2; // error
                $data['errors'] = $this->validationErrors;
            }
        }
        $data['data']['provider'] = $provider;
        return $data;
    }

    public function checkGoogle($uid, $email, $displayName = '', $source = 0){
        $result = $this->_findAccount(array(
                'provider' => 'google',
                'or' => array( 
                    'email' => $email,
                    'uid' => $uid
                )
        ));
        if ($result) {
            if (!$this->_isActive($result)) {
                //
                //$this->User->save
            } 
            return $result['User']['id'];
        }
        
        $this->User->create();
        $user = $this->User->save(array('active' => 1, 'agreed' => 1));
        $account = $this->save(array(
                    'user_id' => $user['User']['id'],
                    'active' => 1,
                    'agreed' => 1,
                    'master' => 1,
                    'provider' => 'google',
                    'uid' => $uid,
                    'full_name' => $displayName,
                    'email' => isset($email) ? $email : null,
                    'source' => $source,
                )
        );
        if($account[$this->alias]['user_id']){
            return $account[$this->alias]['user_id'];    
        }
        return false;
    }

    /**
     *
     * @param unknown_type $data            
     * @return Ambigous <multitype:, NULL, mixed>
     */
    private function _findAccount($data) {
        return $this->find('first', array(
                'conditions' => array(
                        $data
                ),
                'contain' => 'User'
        ));
    }

    /**
     *
     * @param unknown_type $data            
     */
    private function _isActive($data) {
        return $data[$this->alias]['active'];
    }

    /**
     *
     * @param unknown_type $provider            
     * @param unknown_type $uid            
     * @param unknown_type $email            
     * @return Ambigous <mixed, boolean, multitype:>
     */
    private function _createAccount($provider, $uid, $info) {
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

