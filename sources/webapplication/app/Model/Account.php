<?php
/**
 * Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2013, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('AppModel', 'Model');

/**
 * Account Model.
 * Stores account of customers to login into system in various ways.
 *
 * @package app.Model
 */
class Account extends AppModel {
    public $name = 'Account';
    public $belongsTo = 'User';
    
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
            'full_name' => array(
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
        /*'login' => array(
            'notEmpty' => array(
                'rule' => array(
                    'notEmpty'
                ), 
                'message' => 'Поле должно быть заполнено'
             ),
            'alphaNumeric' => array(
    			'rule'		=> 'alphaNumeric',
    			'on'		=> 'create',
    			'message'	=> 'Введите в поле только буквы и цифры'
    		),
    		'between' => array(
    			'rule' 		=> array('between', 2, 30),
    			'on'		=> 'create',
    			'message'	=> 'Длина логина от %d до %d символов',
    		),
            'isUnique' => array(
                'rule' => 'isUnique', 
                'message' => 'Пользователь с таким логином уже существует'
            )
        ), */
        'password' => array(
                    'notEmpty' => array(
                            'rule' => array(
                                    'notEmpty'
                            ),
                            'message' => 'Поле должно быть заполнено'
                    ),
                    'minLength' => array(
                            'rule' => array(
                                    'minLength',
                                    6
                            ),
                            'message' => 'Минимальная длина пароля - %d символа'
                    ),
                    'matchPasswords' => array(
                            'rule' => 'matchPasswords',
                            'message' => 'Пароли не совпадает'
                    )
            ),
            'password_confirm' => array(
                    'notEmpty' => array(
                            'rule' => array(
                                    'notEmpty'
                            ),
                            'message' => 'Поле должно быть заполнено'
                    )
            ),
            'old_password' => array(
                    'notEmpty' => array(
                            'rule' => array(
                                    'notEmpty'
                            ),
                            'message' => 'Поле должно быть заполнено'
                    ),
                    'matchOldPasswords' => array(
                            'rule' => 'matchOldPasswords',
                            'message' => 'Неверный текущий пароль'
                    )
            ),
            'email' => array(
                    'Email' => array(
                            'rule' => array(
                                    'email'
                            ),
                            'message' => 'Пожалуйста, введите Ваш адрес электронной почты'
                    ),
                    'isUniqueLocal' => array(
                            'rule' => array(
                                    'emailLocal'
                            ),
                            'message' => 'Этот адрес уже используется. Пожалуйста, введите другой адрес электронной почты'
                    )
            ),
            'agreed' => array(
                    'comparison' => array(
                            'on' => 'create',
                            'rule' => array(
                                    'comparison',
                                    'equal to',
                                    1
                            ),
                            'message' => 'Вы должны быть согласны с правилами использования сервиса'
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
     * @param unknown_type $check            
     * @return boolean
     */
    public function emailLocal($check) {
        $conditions['Account.email'] = $check['email'];
        $conditions['Account.provider'] = 'local';
        
        $existingEmail = $this->find('first', array(
                'conditions' => $conditions,
                'fields' => array(
                        'id'
                ),
                'recursive' => - 1
        ));
        return empty($existingEmail) ? true : false;
    }

    /**
     *
     * @param unknown_type $data            
     * @return boolean
     */
    public function matchPasswords($data) {
        if ($data['password'] == $this->data[$this->alias]['password_confirm']) {
            return true;
        }
        $this->invalidate('password_confirm', __d('users', 'Пароли не совпадает'));
        return false;
    }

    /**
     *
     * @param unknown_type $data            
     * @return boolean
     */
    public function matchOldPasswords($data) {
        $password = $this->field('password', array(
                $this->alias . '.id' => $this->data[$this->alias]['id'],
                
        ));
        if ($password === Security::hash($data['old_password'], null, true)) {
            return true;
        }
        return false;
    }

    /**
     *
     * @return string
     */
    public function generateToken() {
        return Security::hash(mt_rand() . Configure::read('Security.salt') . time() . mt_rand());
    }

    /**
     *
     * @param unknown_type $data            
     * @return boolean
     */
    public function register($data) {
        $this->set($data);
        if ($this->validates()) {
            $data['password'] = AuthComponent::password($data['password']);
            $data['activate_token'] = $this->generateToken();
            $data['invite_token'] = $this->generateToken();
            $data['provider'] = 'local';
            if ($this->save($data, false)) {
                return true;
            }
        }
        return false;
    }

    /**
     *
     * @param unknown_type $id            
     * @return boolean multitype:
     */
    public function sendActivationAccount($id) {
        $this->id = $id;
        if (! $this->exists()) {
            return false;
        }
        $this->read();
        $email = new CakeEmail('account');
        $email->template(Configure::read('Config.language') . DS . 'activate_account', 'default');
        $email->emailFormat(Configure::read('Email.global.format'));
        $email->from(Configure::read('Email.global.from'));
        $email->to($this->data[$this->alias]['email']);
        $email->subject(__d('mail', Configure::read('Email.user.activateAccount.subject'), Configure::read('Site.name')));
        $email->viewVars(array(
                'activate_token' => $this->data[$this->alias]['activate_token'],
                'full_name' => $this->data[$this->alias]['full_name']
        ));
        return $email->send();
    }

    /**
     *
     * @param unknown_type $id            
     * @return multitype:
     */
    public function sendPasswordResend($id) {
        $this->id = $id;
        $this->read();
        $email = new CakeEmail('account');
        $email->template(Configure::read('Config.language') . DS . 'password_resend', 'default');
        $email->emailFormat(Configure::read('Email.global.format'));
        $email->from(Configure::read('Email.global.from'));
        $email->to($this->data[$this->alias]['email']);
        $email->subject(__d('mail', Configure::read('Email.user.passwordResend.subject'), Configure::read('Site.name')));
        $email->viewVars(array(
                'password_token' => $this->data[$this->alias]['password_token'],
                'fullname' => $this->data[$this->alias]['full_name']
        )); // 'login' => $this->data[$this->alias]['login']
        return $email->send();
    }

    /**
     *
     * @param unknown_type $token            
     * @return Ambigous <mixed, boolean, multitype:>|boolean
     */
    public function activate($token) {
        $this->contain();
        $user = $this->findByActivate_token($token);
        if ($user) {
            $user[$this->alias]['activate_token'] = null;
            return $this->save($user, true, array(
                    'activate_token'
            ));
        }
        return false;
    }

    /**
     *
     * @param unknown_type $email            
     * @return Ambigous <boolean, multitype:, multitype:>|boolean
     */
    public function reactivate($email) {
        $account = $this->findByEmailAndActiveAndProvider($email, 0, 'local');
        if ($account) {
            $this->set($account);
            $this->saveField('activate_token', $this->generateToken());
            return $this->sendActivationAccount($account[$this->alias]['id']);
        }
        return false;
    }

    /**
     *
     * @param unknown_type $email            
     * @return boolean
     */
    public function checkEmail($email) {
        $this->contain();
        $account = $this->findByEmailAndProvider($email, 'local', array(
                'id'
        ));
        if ($account) {
            return $account[$this->alias]['id'];
        }
        return false;
    }

    /**
     *
     * @param unknown_type $id            
     * @return boolean
     */
    public function password_resend($id) {
        $this->id = $id;
        if (! $this->exists()) {
            return false;
        }
        $this->saveField('password_token', $this->generateToken());
        if ($this->sendPasswordResend($id)) {
            return true;
        }
        return false;
    }

    /**
     *
     * @param unknown_type $token            
     * @return boolean
     */
    public function checkPasswordToken($token) {
        $result = $this->find('first', array(
                'conditions' => array(
                        $this->alias . '.password_token' => $token
                ),
                'fields' => array(
                        $this->alias . '.id'
                )
        ));
        if ($result) {
            return $result[$this->alias]['id'];
        }
        return false;
    }

    /**
     *
     * @param unknown_type $id            
     * @param unknown_type $password            
     * @param unknown_type $password_confirm            
     * @param unknown_type $old_password            
     * @param unknown_type $reset            
     * @return boolean
     */
    public function password_change($id, $password, $password_confirm, $old_password = null, $reset = null) {
        $this->set(array(
                'id' => $id,
                'password' => $password,
                'password_confirm' => $password_confirm
        ));
        $fieds = array(
                'id',
                'password',
                'password_confirm'
        );
        if (! $reset) {
            $this->set('old_password', $old_password);
            array_push($fieds, 'old_password');
        }
        if ($this->validates(array(
                'fieldList' => $fieds
        ))) {
            $this->saveField('password', AuthComponent::password($password));
            $this->saveField('password_token', null);
            return true;
        }
        return false;
    }
}


