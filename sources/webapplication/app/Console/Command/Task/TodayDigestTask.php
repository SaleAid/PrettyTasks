<?php
App::uses('User', 'Model');
App::uses('Task', 'Model');
App::uses('Day', 'Model');

/**
 *
 * @property User $User
 * @property Task $Task
 * @property Day $Day
 *          
 */
class TodayDigestTask extends Shell {
    public $uses = array(
            'User',
            'Task',
            'Day'
    );

    public function execute() {
        $this->_getUsersWithTasksOnDate();
    }

    /**
     *
     * @param            
     *
     *
     */
    protected function _getUsersWithTasksOnDate() {
        App::uses('CakeTime', 'Utility');
        
        $today = CakeTime::format('Y-m-d', time());
        $yesterday = CakeTime::format('Y-m-d', '-1 days', true);
        $limit = 2;
        $page = 1;
        $countUser = 1;
        $this->User->getCountActiveUsers(1);
        $pages = ceil($countUser / $limit);
        $this->out(print_r('Datetime: ' . CakeTime::format('Y-m-d  H:i:s', time()), true));
        $this->out(print_r('ALL user: ' . $countUser, true));
        $this->out(print_r('ALL pages: ' . $pages, true));
        
        for($page = 1; $page <= $pages; $page ++) {
            // $users = $this->User->getActiveUsers($limit, $page, 1);
            $users = $this->User->find('all', array(
                    'conditions' => array(
                            'User.id' => '502cdfea-6920-45d1-be92-4ed8c3bf180d'
                    )
            ));
            debug($users);
            foreach ( $users as $user ) {
                $tasks = $this->_getDays($user['User']['id'], $yesterday, $today);
                //debug($tasks);
                if (! empty($tasks[$today])) {
                    $data['tasks']['today']['list'] = $tasks[$today];
                    $data['tasks']['today']['count'] = count($tasks[$today]);
                    $data['tasks']['today']['count_priority'] = count(array_filter($tasks[$today], create_function('$task', 'return $task->priority == 1;')));
                    if (! empty($tasks[$yesterday])) {
                        $data['tasks']['yesterday']['list'] = $tasks[$yesterday];
                        $data['tasks']['yesterday']['count'] = count($tasks[$yesterday]);
                        $data['tasks']['yesterday']['not_done_list'] = array_filter($tasks[$yesterday], create_function('$task', 'return $task->done == 0;'));
                        $data['tasks']['yesterday']['count_not_done'] = count($data['tasks']['yesterday']['not_done_list']);
                        $data['tasks']['yesterday']['count_done'] = $data['tasks']['yesterday']['count'] - $data['tasks']['yesterday']['count_not_done'];
                    }
                    
                    //debug($data);
                    
                    $this->_todayDigest($user, $data);

                }
            }
        }
        $this->out(print_r('ALL', true));
    }

    /**
     *
     *
     *
     * Send email. $\
     *
     * @param array $data            
     */
    protected function _todayDigest($user, $data) {
        if (! empty($user['User']['language'])) {
            Configure::write('Config.language', $user['User']['language']);
        }
        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail('account');
        $email->template(Configure::read('Config.language') . DS . 'today_digest', 'default');
        $email->emailFormat(Configure::read('Email.global.format'));
        
        $email->subject(__d('mail', Configure::read('Email.user.todayDigest.subject')));
        $email->viewVars(array(
                'user' => $user,
                'data' => $data
        ));
        for($i=0;$i<1;$i++){
            $email->to("krugvs+{$i}@gmail.com");
            $email->send();
        }
    }

    public function _getDays($user_id, $from, $to, $arrDays = null) {
        $days = array();
        do {
            $days[] = $from;
            $from = date("Y-m-d", strtotime($from . "+1 day"));
        } while ( $from <= $to );
        
        if (is_array($arrDays)) {
            sort($arrDays);
            $days = array_merge($days, $arrDays);
            $days = array_unique($days);
        }
        
        foreach ( $days as $v ) {
            $data[$v] = array();
            $DateList = new DateList($user_id, $v);
            $items = $DateList->getItems();
            foreach ( $items as $item ) {
                $data[$item->date][] = $item;
            }
        }
        
        return $data;
    }
}
