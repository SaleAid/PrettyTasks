<?php
App::uses('AppModel', 'Model');
App::import('Vendor', 'loginza' . DS . 'LoginzaAPI');
App::import('Vendor', 'loginza' . DS . 'LoginzaUserProfile');
/**
 * User Model
 *
 */
class Account extends AppModel {
    
    public $name = 'Account';
    
    public $actsAs = array(
        'Activation'
    ); //TODO Maybe rewrite model without using behavior?
    
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
        'user_id' => array(
			'maxLength' => array(
                'rule'    => array('maxLength', 36),
                'message' => 'Wrong ID',
            )
        ),
        'agreed' => array(
            'comparison' => array(
                'rule' => array('comparison', 'equal to', 1),
                'message' => 'Вы должны быть согласны с правилами использования сервиса'
            )
        ), 
    );

    protected function _getDataFromProvider($userProfile){
        $data = array();
        $data['identity'] = $userProfile->identity;
        $data['uid'] = $userProfile->uid;
        $data['identity'] = $userProfile->identity;
        $data['first_name'] = isset($userProfile->name->first_name) ? $userProfile->name->first_name : '';
        $data['last_name'] = isset($userProfile->name->last_name) ? $userProfile->name->last_name : '';
        $data['full_name'] = isset($userProfile->name->full_name) ? $userProfile->name->full_name : '';
        $data['email'] = isset($userProfile->email) ? $userProfile->email : ''; 
        return (array)$data;
    }
    
    protected function _getDataFrom_vkontakte($data){
        $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
        return $data;
    }
    
    protected function _getDataFrom_linkedin($data){
        $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
        return $data;
    }
    
    protected function _getDataFrom_twitter($data){
        $tmp = explode(' ',$data['full_name']);
        $data['last_name'] = isset($tmp[1]) ? $tmp[1] : '';
        $data['first_name'] = $tmp[0];
        return $data;
    }
    
    public function getLoginzaUser($token) {
        $LoginzaAPI = new LoginzaAPI();
        $UserProfile = $LoginzaAPI->getAuthInfo($token, Configure::read('loginza.id'), md5($token . Configure::read('loginza.skey')));
        if (isset($UserProfile->error_type)) {
            $data['status'] = 'error';
            $data['msg'] = $UserProfile->error_message;
            return $data;
        }
        $providers = Configure::read('loginza.provider');
        if( !in_array($UserProfile->provider, $providers) ) {
            $data['status'] = 'error';
            $data['msg'] = 'Bad provider';
            return $data;
        }
        $data = $this->_getDataFromProvider($UserProfile);
        $data['provider'] = array_search($UserProfile->provider, $providers);
        $providerMethod = "_getDataFrom_{$data['provider']}";
        if( method_exists($this, $providerMethod) ){
            $data = $this->$providerMethod($data);
        }
        
        $result = $this->findByUidAndProvider($data['uid'], $data['provider']);
        if (! $result) {
            $data['status'] = 'newUser';//TODO Are u sure this is the good status? Maybe better use numeric values? 
            return $data;
        }
        if ($result['User']['is_blocked']) {
            return array(
                'status' => 'error', 
                'msg' => __d('accounts', 'Ваш основной аккаунт заблокирован')
            );
        } elseif (!$result['User']['active']) {
            return array(
                'status' => 'error', 
                'msg' => __d('accounts', 'Ваш основной аккаунт деактивирован')
            );            
        } elseif ($result['Account']['active']) {
            $result = $result['User'];
            $result['status'] = 'active';
            $result['provider'] = $data['provider'];
            return $result;
        } else {
            $data['status'] = 'notActive';
            return array_merge((array)$result, (array)$data);
        }
        return false;
    }

    public function reactivate($id, $controllerName) {
        $this->id = $id;
        if (! $this->exists()) {
            return false;
        }
        $this->saveField('activate_token', $this->User->generateToken());
        return $this->sendActivationAccount($id, $controllerName); 
    }
}

