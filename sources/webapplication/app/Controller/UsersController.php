<?php
App::uses('AppController', 'Controller');
App::uses('Validation', 'Utility');
class UsersController extends AppController {
   public $name = 'Users';
    
   public $uses = array('Task', 'User', 'Account');

   public $components = array(
        'RequestHandler', 
        'Captcha'
    );
    
    public $layout = 'profile';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('checkVK', 'check');
        if ($this->Auth->loggedIn() and in_array($this->params['action'], array(
            'login', 
            'register', 
            'activate', 
            'reactivate'
        ))) {
            $this->redirect(array(
                'controller' => 'tasks',
                'action' => 'index',
                'lang' => $this->params['lang'],
            ));
        }
    }

    public function isAuthorized($user) {
        return true;
    }
    
    public function checkLogin() {
        $this->autoRender = false;
        return $this->Auth->loggedIn();
    }
    
    public function check() {
        $result['status'] = 0;
        if($this->Auth->loggedIn()){
            $result['status'] = 1;
            $result['data']['full_name'] = $this->Auth->user('full_name');
            $result['data']['token'] = $this->generateCsrfToken();
            $result['data']['timezone'] = $this->Auth->user('timezone');
            $result['data']['language_url'] = $this->Auth->user('language');
            if(!empty($this->request->data['date'])){
                $result['data']['count'] = $this->Task->find('count', array(
                    'conditions' => array(
                        'Task.done' => 0,
                        'Task.deleted' => 0,
                        'Task.date' => $this->request->data['date'],
                        'Task.user_id' => $this->Auth->user('id'))
                )); 
            }
        }                
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    public function index() {
        $this->redirect(array(
            'action' => 'profile'
        ));
    }

    public function profile() {
        $this->User->id = $this->Auth->user('id');
        if ($this->request->is('post') || $this->request->is('put')) {
            $expectedData = array(
                'timezone',
                'language'
                 
            );
            if (!$this->_isSetRequestData($expectedData, 'User')) {
                $this->Session->setFlash(__d('users', 'Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {

                $data['User']['timezone'] = $this->request->data['User']['timezone'];
                $data['User']['language'] = $this->request->data['User']['language'];
                if ($this->User->save($data)) {
                   $this->_refreshAuth();
                   $this->Session->setFlash(__d('users', 'Профиль был сохранен'), 'alert', array(
                        'class' => 'alert-success'
                   ));
                   $params = $this->request->params;
                   if(!empty($data['User']['language'])){
                        $params['lang'] = $this->L10n->map($data['User']['language']);
                        $this->redirect($params);
                   }
                   $params['lang'] = false;
                   $this->redirect($params);
                } else {
                    $this->Session->setFlash(__d('users', 'Профиль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
            }
        } else {
            $this->request->data = $this->User->read();
        }
        
        foreach(Configure::read('Config.lang.available') as $lang){
            $listLang[$lang['lang']] = $lang['name'];
        }
        $this->set('listLang', $listLang);
        
        
        App::uses('CakeTime', 'Utility');
        //pr(CakeTime::listTimezones());
        //TODO: Rewrite it
        $list = DateTimeZone::listAbbreviations();
        $idents = DateTimeZone::listIdentifiers();
        $data = $offset = $added = array();
        foreach ( $list as $abbr => $info ) {
            foreach ( $info as $zone ) {
                if (! empty($zone['timezone_id']) and ! in_array($zone['timezone_id'], $added) and in_array($zone['timezone_id'], $idents)) {
                    $z = new DateTimeZone($zone['timezone_id']);
                    $c = new DateTime(null, $z);
                    $zone['time'] = $c->format('H:i ');
                    $data[] = $zone;
                    $offset[] = $z->getOffset($c);
                    $added[] = $zone['timezone_id'];
                }
            }
        }
        //debug($offset);
        //debug($data);
        array_multisort($offset, SORT_ASC, $data);
        $options = array();
        foreach ( $data as $key => $row ) {
            $options[$row['timezone_id']] = $row['time'] . ' - ' . formatOffset($row['offset']) . ' ' . $row['timezone_id'];
        }
        //debug($options);
        $this->set('list', $options);
    }
    
    public function accounts() {
        $this->paginate = array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id'), 
                //'Account.active' => 1
            )
        );
        $accounts = $this->paginate('Account');
        $this->set('accounts', $accounts);
    }
    
    public function changeLanguage(){
        $result = $this->_prepareResponse();
        if ( $this->_isSetRequestData('lang') && $this->User->changeLanguage($this->Auth->user('id'), $this->request->data['lang'])) {
            $this->_refreshAuth();
            $result['success'] = true;
        }
        $this->set('result', $result);
        $this->set('_serialize', array(
            'result'
        )); 
    }
    
    protected function _refreshAuth(){
         $this->User->contain();
         $user = $this->User->read(false, $this->Auth->user('id'));
         $user = $user['User'];
         //pr($this->Auth->user());die;
         $user['account_id'] = $this->Auth->user('account_id');
         $user['provider'] = $this->Auth->user('provider');
         $user['full_name'] = $this->Auth->user('full_name');
         $this->Session->write('Auth.User', $user);
         //$this->Auth->login($user);
    }
}

//TODO Place this function in other file
// now you can use $options;
function formatOffset($offset) {
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int)abs($hours);
    $minutes = (int)abs($remainder / 60);
    if ($hour == 0 and $minutes == 0) {
        $sign = ' ';
    }
    return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0');
}