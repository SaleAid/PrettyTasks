<?php
App::uses('AppController', 'Controller');
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
        if ($this->Auth->user() && in_array($this->params['action'], array(
            'login', 
            'register', 
            'activate', 
            'reactivate'
        ))) {
            $this->redirect('/');
        }
    }

    public function isAuthorized($user) {
        return true;
    }

    public function login() {
        $this->layout = 'default';
        //if (!empty($this->request->data)) {
        if ($this->User->validates()) {
            //if($this->request->is('post')){
            if ($this->Auth->login()) {
                if ($this->Auth->user('active')) {
                    if (! $this->Auth->user('is_blocked')) {
                        $this->redirect($this->Auth->redirect());
                    }
                    $this->Session->setFlash(__('Ваш аккаунт заблокирован.'), 'alert', array(
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
                    $this->Session->setFlash(__('Your username or password was incorrect.'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
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
        if ($this->request->is('post')) {
            if ($this->User->register($this->request->data)) {
                if ($this->User->sendActivationAccount($this->User->getLastInsertID(), $this->name)) {
                    $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту.'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                    $this->redirect(array(
                        'action' => 'login'
                    ));
                }
                $this->Session->setFlash(__('Вы успешно прошли регистрацию. Возникли проблемы при отправке кода активации аккаунта.'), 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect(array(
                    'action' => 'login'
                ));
            } else {
                unset($this->request->data[$this->modelClass]['password']);
                unset($this->request->data[$this->modelClass]['password_confirm']);
                return $this->Session->setFlash(__('Пользователь не может быть сохранен. Пожалуйста, попробуйте еще раз.'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }

    public function activate($token = null) {
        if ($token) {
            if ($this->User->activate($token)) {
                $this->Session->setFlash('Your account has been activated, please log in.', 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect(array(
                    'action' => 'login'
                ));
            }
        }
        $this->Session->setFlash(__('Invalid key.'));
        $this->redirect(array(
            'action' => 'login'
        ));
    }

    public function reactivate() {
        if (isset($this->request->data['email'])) {
            if ($this->User->reactivate($this->request->data, $this->name)) {
                $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту.'), 'alert', array(
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
            $this->request->data[$this->modelClass]['id'] = $this->Auth->user('id');
            if ($this->User->password_change($this->request->data)) {
                return $this->Session->setFlash(__('Ваш пароль успешно изменен.'), 'alert', array(
                    'class' => 'alert-success'
                ));
            }
            unset($this->request->data[$this->modelClass]['password']);
            unset($this->request->data[$this->modelClass]['password_confirm']);
            unset($this->request->data[$this->modelClass]['old_password']);
            return $this->Session->setFlash(__('Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз.'), 'alert', array(
                'class' => 'alert-error'
            ));
        }
    }

    public function password_reset($password_token = null) {
        $this->layout = 'default';
        if ($password_token) {
            if ($id = $this->User->checkPasswordToken($password_token)) {
                if ($this->request->is('post') || $this->request->is('put')) {
                    $this->request->data[$this->modelClass]['id'] = $id;
                    if ($this->User->password_change($this->request->data)) {
                        $this->Session->setFlash(__('Ваш пароль успешно изменен.'), 'alert', array(
                            'class' => 'alert-success'
                        ));
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    }
                    unset($this->request->data[$this->modelClass]['password']);
                    unset($this->request->data[$this->modelClass]['password_confirm']);
                    return $this->Session->setFlash(__('Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз.'), 'alert', array(
                        'class' => 'alert-error'
                    ));
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
                $this->Session->setFlash(__('На Вашу почту была отправлена инструкция по сбросу пароля.'), 'alert', array(
                    'class' => 'info-success'
                ));
                $this->redirect($this->referer());
            }
        }
        $this->layout = 'default';
        if ($this->request->is('post') || $this->request->is('put')) {
            if (! $this->User->validateEmail($this->request->data)) {
                return $this->Session->setFlash(__('Возникла ошибка при заполнении. Пожалуйста, попробуйте еще раз.'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
            if ($id = $this->User->checkEmail($this->request->data)) {
                if ($this->User->password_resend($id)) {
                    $this->Session->setFlash(__('На Вашу почту была отправлена инструкция по сбросу пароля.'), 'alert', array(
                        'class' => 'info-success'
                    ));
                    $this->redirect(array(
                        'action' => 'login'
                    ));
                }
            }
            return $this->Session->setFlash(__('В нашей базе нет пользователя с такой почтой.'), 'alert', array(
                'class' => 'alert-error'
            ));
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
            if ($this->User->save($this->request->data)) {//TODO: May save only needed fields?
                $this->Session->write('Auth.User', array_merge($this->Auth->user(), $this->request->data['User']));//TODO: NONONO. This is WRONG!!! If you get from request user['admin']=true?
                //This is case, when REALY necessary to read data from DB!
                //And Is this correct to write directly to session? Please check these issues. 
                $this->Session->setFlash(__('The user profile has been saved'), 'alert', array(
                    'class' => 'alert-success'
                ));
            } else {
                $this->Session->setFlash(__('The user profile could not be saved. Please, try again.'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        } else {
            //debug(DateTimeZone::listAbbreviations());
            $this->set('list', DateTimeZone::listAbbreviations());
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
        //debug($this->Auth->User());
        $this->paginate = array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id'), 
                'Account.active' => 1
            )
        );
        $accounts = $this->paginate('Account');
        $this->set('accounts', $accounts);
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