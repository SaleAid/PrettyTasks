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
    );

    public function getLoginzaUser($token) {
        $LoginzaAPI = new LoginzaAPI();
        $UserProfile = $LoginzaAPI->getAuthInfo($token, Configure::read('loginza.id'), md5($token . Configure::read('loginza.skey')));
        if (isset($UserProfile->error_type)) {
            $data['status'] = 'error';
            $data['msg'] = $UserProfile->error_message;
            return $data;
        }
        $data['identity'] = $UserProfile->identity;
        switch ($UserProfile->provider) {
            case strpos($UserProfile->provider, 'twitter') == true :
                {
                    $tmp = explode(' ', $UserProfile->name->full_name);
                    if (isset($tmp[1])) {
                        $data['last_name'] = $tmp[1];
                    } else {
                        $data['last_name'] = '';
                    }
                    $data['first_name'] = $tmp[0];
                    $data['full_name'] = $UserProfile->name->full_name;
                    $data['provider'] = 'twitter';
                    $data['uid'] = $UserProfile->uid;
                    $data['identity'] = $UserProfile->identity;
                    $data['email'] = '';
                    break;
                }
            case strpos($UserProfile->provider, 'vkontakte') == true :
                {
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'];
                    $data['identity'] = $UserProfile->identity;
                    $data['email'] = '';
                    $data['provider'] = 'vkontakte';
                    break;
                }
            case strpos($UserProfile->provider, 'google') == true :
                {
                    $data['provider'] = 'google';
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['full_name'] = $UserProfile->name->full_name;
                    $data['identity'] = $UserProfile->identity;
                    $data['email'] = $UserProfile->email;
                    break;
                }
            case strpos($UserProfile->provider, 'facebook') !== true :
                {
                    $data['provider'] = 'facebook';
                    $data['uid'] = $UserProfile->uid;
                    $data['first_name'] = $UserProfile->name->first_name;
                    $data['last_name'] = $UserProfile->name->last_name;
                    $data['full_name'] = $UserProfile->name->full_name;
                    $data['identity'] = $UserProfile->identity;
                    $data['email'] = $UserProfile->email;
                    break;
                }
            default :
                {
                    $data['status'] = 'error';
                    $data['msg'] = 'Bad provider';
                    return $data;
                }
        }
        $result = $this->findByUidAndProvider($data['uid'], $data['provider']);
        if (! $result) {
            $data['status'] = 'newUser';//TODO Are u sure this is the good status? Maybe better use numeric values? 
            return $data;
        }
        if ($result['User']['is_blocked']) {
            return array(
                'status' => 'error', 
                'msg' => 'Your user profile is blocked.'//TODO use __(
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

