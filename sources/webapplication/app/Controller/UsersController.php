<?php
App::uses('AppController', 'Controller');
App::uses('Validation', 'Utility');
class UsersController extends AppController {
    public $name = 'Users';

    public $components = array(
        'Recaptcha.Recaptcha' => array(
            'actions' => array(
                'register', 
                'password_resend' 
            )
        )
    );
    public $layout = 'profile';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'register', 'activate', 'password_resend', 'password_reset', 'reactivate');
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

    public function login() {
        $this->layout = 'default';
        $this->Seo->title = $this->Seo->title.' :: '.Configure::read('SEO.Login.title.ru');
        $this->Seo->description = Configure::read('SEO.Login.description.ru');
        $this->Seo->keywords = Configure::read('SEO.Login.keywords.ru');
        //if ($this->User->validates()) {
            $message = __('Ваш емейл или пароль не совпадают');
            if( isset($this->data['User']['email']) && !Validation::email($this->data['User']['email']) ){
                  $this->request->data['User']['username'] = $this->data['User']['email'];
                  $this->Auth->authenticate['Form'] = array('fields' => array('username' => 'username'));
                  //$this->AutoLogin->username = 'username';  
                  $message = __('Ваш логин или пароль не совпадают');
            }
            if ($this->Auth->login()) {
                if ($this->Auth->user('active')) {
                    if (! $this->Auth->user('is_blocked')) {
                        $this->redirect($this->Auth->redirect());
                    }
                    $this->Session->setFlash(__('Ваш аккаунт заблокирован'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                    $this->redirect($this->Auth->logout());
                }
                $this->Session->setFlash(null, 'not_active', array(
                    'class' => 'alert-info', 
                    'email' => $this->Auth->user('email')
                ));
                $this->redirect($this->Auth->logout());
            } else {
                if ($this->request->is('post')) {
                    $this->Session->setFlash($message, 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
            }
        //}
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function checkLogin() {
        $this->autoRender = false;
        return $this->Auth->loggedIn();
    }

    public function register() {
        $this->layout = 'default';
        $this->Seo->title = $this->Seo->title.' :: '.Configure::read('SEO.Registration.title.ru');
        $this->Seo->description = Configure::read('SEO.Registration.description.ru');
        $this->Seo->keywords = Configure::read('SEO.Registration.keywords.ru');
        if ($this->request->is('post')) {
            $expectedData = array(
                'first_name',
                //'last_name',
                'email',
                'username',
                'password', 
                'password_confirm',
                'agreed'
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                    $saveData = array(
                        'first_name'        => $this->request->data[$this->modelClass]['first_name'],
                        //'last_name'         => $this->request->data[$this->modelClass]['last_name'],
                        'email'             => $this->request->data[$this->modelClass]['email'],
                        'username'          => $this->request->data[$this->modelClass]['username'],
                        'password'          => $this->request->data[$this->modelClass]['password'], 
                        'password_confirm'  => $this->request->data[$this->modelClass]['password_confirm'],
                        'agreed'  => $this->request->data[$this->modelClass]['agreed']
                    );
                if ($this->User->register($saveData)) {
                    //TODO Application is crashed if email is not sent. 
                    //TODO Need to use try catch to catch the exception?
                    //TODO Please check it also at another places
                    if ($this->User->sendActivationAccount($this->User->getLastInsertID(), $this->name)) {
                        $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту'), 'alert', array(
                            'class' => 'alert-success'
                        ));
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    }
                    $this->Session->setFlash(__('Вы успешно прошли регистрацию. Возникли проблемы при отправке кода активации аккаунта'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                    $this->redirect(array(
                        'action' => 'login'
                    ));
                } else {
                    unset($this->request->data[$this->modelClass]['password']);
                    unset($this->request->data[$this->modelClass]['password_confirm']);
                    return $this->Session->setFlash(__('Регистрация не удалась. Заполните поля полностью'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
            }
        }
    }

    public function activate($token = null) {
        if ($token) {
            if ($result = $this->User->activate($token)) {
                $this->Session->setFlash('Ваш аккаунт был активирован', 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->Auth->login($result[$this->modelClass]);
                $this->redirect($this->Auth->redirect());
            }
        }
        $this->Session->setFlash(__('Invalid key.'));
        $this->redirect(array(
            'action' => 'login'
        ));
    }

    public function reactivate() {
        if (!$this->_isSetRequestData('email')) {
            $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                    'class' => 'alert-error'
                ));
        } else {
            if ($this->User->reactivate($this->request->data['email'], $this->name)) {
                $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту'), 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect(array(
                    'action' => 'login'
                ));
            }
        }
        $this->redirect(array(
            'action' => 'login'
        ));
    }

    public function password_change() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $expectedData = array(
                'password', 
                'password_confirm',
                'old_password'
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                if ($this->User->password_change($this->Auth->user('id'), $this->request->data[$this->modelClass]['password'],
                                                                          $this->request->data[$this->modelClass]['password_confirm'], 
                                                                          $this->request->data[$this->modelClass]['old_password'])) {
                    return $this->Session->setFlash(__('Ваш пароль успешно изменен'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                }
                unset($this->request->data[$this->modelClass]['password']);
                unset($this->request->data[$this->modelClass]['password_confirm']);
                unset($this->request->data[$this->modelClass]['old_password']);
                return $this->Session->setFlash(__('Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function password_reset($password_token = null) {
        $this->layout = 'default';
        if ($password_token) {
            if ($id = $this->User->checkPasswordToken($password_token)) {
                if ($this->request->is('post') || $this->request->is('put')) {
                    $expectedData = array(
                        'password', 
                        'password_confirm'
                    );
                    if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                        $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                                'class' => 'alert-error'
                            ));
                    } else {
                        if ($this->User->password_change($id, $this->request->data[$this->modelClass]['password'], $this->request->data[$this->modelClass]['password_confirm'],null, true)) {
                            $this->Session->setFlash(__('Ваш пароль успешно изменен'), 'alert', array(
                                'class' => 'alert-success'
                            ));
                            $this->redirect(array(
                                'action' => 'login'
                            ));
                        }
                        unset($this->request->data[$this->modelClass]['password']);
                        unset($this->request->data[$this->modelClass]['password_confirm']);
                        return $this->Session->setFlash(__('Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
                            'class' => 'alert-error'
                        ));
                    }
                }
                return false;
            }
        }
        $this->redirect(array(
            'action' => 'login'
        ));
    }

    public function password_resend() {
        if ($this->Auth->loggedIn()) {
            if ($this->User->password_resend($this->Auth->user('id'))) {
                $this->Session->setFlash(__('На Вашу почту была отправлена инструкция по сбросу пароля'), 'alert', array(
                    'class' => 'info-success'
                ));
                $this->redirect(array('action' => 'password_change'));
            }
        }
        $this->layout = 'default';
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!$this->_isSetRequestData('email', $this->modelClass)) {
                $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                if (! $this->User->validateEmail($this->request->data[$this->modelClass]['email'])) {
                    return $this->Session->setFlash(__('Возникла ошибка при заполнении. Пожалуйста, попробуйте еще раз'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
                if ($id = $this->User->checkEmail($this->request->data[$this->modelClass]['email'])) {
                    if ($this->User->password_resend($id)) {
                        $this->Session->setFlash(__('На Вашу почту была отправлена инструкция по сбросу пароля'), 'alert', array(
                            'class' => 'info-success'
                        ));
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    }
                }
                return $this->Session->setFlash(__('В нашей базе нет пользователя с такой почтой'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
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
                'first_name', 
                'last_name',
                'timezone' 
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__('Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                $data[$this->modelClass]['first_name'] = $this->request->data[$this->modelClass]['first_name'];
                $data[$this->modelClass]['last_name'] = $this->request->data[$this->modelClass]['last_name'];
                $data[$this->modelClass]['timezone'] = $this->request->data[$this->modelClass]['timezone'];
                if ($this->User->save($data)) {
                   $this->_refreshAuth();
                   $this->Session->setFlash(__('Профиль был сохранен'), 'alert', array(
                        'class' => 'alert-success'
                   ));
                   $this->redirect(array('action'=>'profile'));
                } else {
                    $this->Session->setFlash(__('Профиль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
            }
        } else {
            $this->request->data = $this->User->read();
        }
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
                'Account.active' => 1
            )
        );
        $accounts = $this->paginate('Account');
        $this->set('accounts', $accounts);
    }
    
    protected function _refreshAuth(){
         $this->User->contain();
         $user = $this->User->read(false, $this->Auth->user('id'));
         $result = $user[$this->modelClass];
         if($this->Auth->user('provider')){
            $provider = $this->Auth->user('provider');   
            $result['provider'] = $provider;
         }
         $this->Auth->login($result);
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