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
        $email = new CakeEmail('activate_account');
        $email->viewVars(array( 'controllerName' => $controllerName,
                                'activate_token' => $Model->data[$Model->alias]['activate_token'], 
                                'full_name' => $Model->data[$Model->alias]['full_name']))
              ->to($Model->data['User']['email'])
                ;
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
