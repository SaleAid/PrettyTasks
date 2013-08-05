<?php
class MigrationUsersTask extends Shell {
    
    public $uses = array('User', 'Account', 'Setting');
    
    public function execute() {
        $this->moveUsersToAccounts();
    }
    
    protected function moveUsersToAccounts(){
        $this->User->contain();
        $users = $this->User->find('all');
        //pr($users);
        foreach($users as $user){
           $account = array(
                            'master' => 1,
                            'provider' => 'local',
                            'login' => $user['User']['username'],
                            'password' => $user['User']['password'],
                            'email' => $user['User']['email'],
                            'full_name' => $user['User']['first_name'] . ' ' . $user['User']['last_name'],
                            'activate_token' => $user['User']['activate_token'],
                            'active' => $user['User']['active'],
                            'created' => $user['User']['created'],
                            'modified' => $user['User']['modified'],
                            'user_id' => $user['User']['id'],
                            'agreed' => 1
                      );
           $this->Account->create(); 
           $this->Account->save($account, false); 
           unset($account);
           
           if(!empty($user['User']['config'])){
                $config = unserialize($user['User']['config']);
                if($config['day']){
                    $this->Setting->setValue('days', $config['day'], $user['User']['id']);
                }
           }
        }
        $this->out(print_r('ALL done.', true));
    }
}