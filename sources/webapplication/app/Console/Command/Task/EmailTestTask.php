<?php
App::uses('User', 'Model');
App::uses('Task', 'Model');
App::uses('Day', 'Model');
App::uses('Account', 'Model');
/**
 *
 * @property User $User
 * @property Task $Task
 * @property Day $Day
 * @property Account $Account
 *          
 */
class EmailTestTask extends Shell {
    public $uses = array(
            'User',
            'Task',
            'Day',
            'Account'
    );

    public function execute() {
        $mode = $this->args[0];
        switch ($mode){
            case 'activation':
                $this->activation();
                break;
            case 'remember_password':
            	$this->remember_password();
            	break;
        }

    }
    
    public function activation() {
    	$email = $this->args[1];
    	$id = $this->Account->checkEmail($email);
    	if ($id){
    		$r = $this->Account->sendActivationAccount($id);
    		print_r((bool)$r);
    	}
    	else{
    		$this->out('Account not found');
    	}
    	$this->hr(3);
    }
    
    function remember_password(){
    	$email = $this->args[1];
        $count = intval($this->args[2])?intval($this->args[2]):1;
    	$id = $this->Account->checkEmail($email);
    	if ($id){
    	    for($i=0; $i<$count; $i++){
        		$r = $this->Account->password_resend($id);
    		    print_r((bool)$r);
    	    }
    	}
    	else{
    		$this->out('Account not found');
    	}
    	$this->hr(3);
    }
    

}
