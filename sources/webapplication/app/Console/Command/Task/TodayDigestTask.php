<?php
class TodayDigestTask extends Shell {
    
    public $uses = array('User', 'Task', 'Day');
    
    public function execute() {
        $this->_getUsersWithTasksOnDate();
    }
    /**
     * 
     * 
     * @param 
     */
    protected function _getUsersWithTasksOnDate(){
        App::uses('CakeTime', 'Utility');
        
        $today = CakeTime::format('Y-m-d',time());
        $yesterday = CakeTime::format('Y-m-d', '-1 days', true);
        $limit = 2;
        $page = 1;
        $countUser = $this->User->getCountActiveUsers(1);
        $pages = ceil($countUser / $limit);
        $this->out(print_r('Datetime: '. CakeTime::format('Y-m-d  H:i:s', time()), true));
        $this->out(print_r('ALL user: ' . $countUser, true));
        $this->out(print_r('ALL pages: ' . $pages, true));
        
        
        for( $page = 1; $page <= $pages; $page++){
            $users = $this->User->getActiveUsers($limit, $page, 1);
            foreach($users as $user){
                $tasks = $this->Task->getDays($user['User']['id'], $yesterday, $today);
                if( !empty($tasks[$today]) ){
                    $data['tasks']['today']['list'] = $tasks[$today];
                    $data['tasks']['today']['count'] = count($tasks[$today]);
                    $data['tasks']['today']['count_priority'] = count(array_filter($tasks[$today], create_function('$task', 'return $task[\'Task\'][\'priority\'] == 1;')));
                    if(!empty($tasks[$yesterday])){
                        $data['tasks']['yesterday']['list'] = $tasks[$yesterday];  
                        $data['tasks']['yesterday']['count'] = count($tasks[$yesterday]);
                        $data['tasks']['yesterday']['not_done_list'] = array_filter($tasks[$yesterday], create_function('$task', 'return $task[\'Task\'][\'done\'] == 0;'));
                        $data['tasks']['yesterday']['count_not_done'] = count($data['tasks']['yesterday']['not_done_list']);
                        $data['tasks']['yesterday']['count_done'] = $data['tasks']['yesterday']['count'] - $data['tasks']['yesterday']['count_not_done'];  
                     }   
                    
                    $days = $this->Day->getDaysRating($user['User']['id'], $yesterday);
                    if( isset($days[$yesterday]) && !empty($days[$yesterday]) ){
                        $data['days']['yesterday'] = $days[$yesterday];
                    }    
                    $this->_todayDigest($user, $data);
                }
            }
        }
        $this->out(print_r('ALL', true));
        
    }
    
    /**
     * 
     * Send email. $\
     * @param array $data
     */
    protected function _todayDigest($user, $data){
        if( !empty($user['User']['language']) ){
            Configure::write('Config.language', $user['User']['language']);
        } 
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $email->template(Configure::read('Config.language') . DS . 'today_digest', 'default');
        $email->emailFormat(Configure::read('Email.global.format'));
        $email->from(Configure::read('Email.global.from'));
        $email->to($user['User']['email']);
        $email->subject(__d('mail', Configure::read('Email.user.todayDigest.subject')));
        $email->viewVars(array(
            'user' => $user,
            'data' => $data
        ));
        $email->send();
         $this->out(print_r($user, true));
        
    }
    
}
