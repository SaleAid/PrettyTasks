<?php
App::uses('CakeEmail', 'Network/Email');

class ActivationBehavior extends ModelBehavior {


/**
 * Initiate Activation behavior
 *
 * @param Model $Model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup($Model, $config = array()) {
	   $this->settings = $config;
	}


    
    public function sendActivationAccount($Model, $id, $controllerName){
        $Model->id = $id;
        if (!$Model->exists()) {
	        return false;
        }
        $Model->read();
        $email = new CakeEmail();
        $email->template('activate_account', 'default');
        $email->emailFormat(Configure::read('Email.global.format'));
        $email->from(Configure::read('Email.global.from'));
        $email->to($Model->data['User']['email']);
        $email->subject(Configure::read('Email.user.activateAccount.subject'));
        $email->viewVars(array( 'controllerName' => $controllerName,
                                'activate_token' => $Model->data[$Model->alias]['activate_token'], 
                                'full_name' => $Model->data[$Model->alias]['full_name'])
                        );
        return $email->send();
    }
    
    public function activate($Model, $token){
        if($user = $Model->findByActivate_token($token)){
    	        $Model->id = $user[$Model->alias]['id'];
        	    $Model->saveField('active', 1);
                $Model->saveField('activate_token', null);
                return true;
    	}
        return false;
    }
    



}
