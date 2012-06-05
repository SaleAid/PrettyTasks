<?php
App::uses('AppController', 'Controller');
class AccountsController extends AppController {
    public $name = 'Accounts';
    public $components = array(
        'RequestHandler', 
        'Recaptcha.Recaptcha' => array(
            'actions' => array(
                'register'
            )
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('loginzalogin', 'activate', 'reactivate', 'confirm_email', 'confirm_user_data');
        if ($this->Auth->user() && in_array($this->params['action'], 
                                            array(
                                                'loginzalogin', 
                                                'activate', 
                                                'reactivate', 
                                                'confirm_email', 
                                                'confirm_user_data'
                                            ))) {
            $this->redirect('/');
        }
    }

    public function isAuthorized($user) {
        return true;
    }

    public function loginzalogin() {
        if (! empty($this->request->data['token'])) {
            $result = $this->Account->getLoginzaUser($this->request->data['token']);
            switch ($result['status']) {
                case 'active' :
                    {
                        $this->Auth->login($result);
                        $this->redirect($this->Auth->redirect());
                        break;
                    }
                case 'notActive' :
                    {
                        $this->Session->write('tmpUser', $result);
                        $this->Session->setFlash(__('Your account not active.'), 'alert', array(
                            'class' => 'alert-info'
                        ));
                        $this->redirect(array(
                            'action' => 'reactivate'
                        ));
                        break;
                    }
                case 'newUser' :
                    {
                        $this->Session->write('tmpUser', $result);
                        $this->redirect(array(
                            'action' => 'confirm_email'
                        ));
                        break;
                    }
                case 'error' :
                    {
                        $this->Session->setFlash(__($result['msg']), 'alert', array(
                            'class' => 'alert-error'
                        ));
                        $this->redirect('/');
                    }
            }
        }
        $this->Session->setFlash(__('An unknown error'), 'alert', array(
            'class' => 'alert-error'
        ));
        $this->redirect(array(
            'action' => 'login'
        ));
    }

    public function reactivate() {
        if ($this->Session->check('tmpUser')) {
            $user_profile = $this->Session->read('tmpUser');
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->Session->delete('tmpUser');
                if ($this->Account->reactivate($user_profile[$this->modelClass]['id'], $this->name)) {
                    $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту.'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                    $this->redirect('/');
                }
                $this->Session->setFlash(__('Возникли проблемы при отправке КодА активации аккаунта.'), 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect('/');
            } else {
                $this->request->data = $user_profile;
            }
        } else {
            $this->redirect('/');
        }
    }

    public function confirm_email() {
        if (! $this->Session->check('tmpUser')) {
            $this->redirect('/');
        }
        $user = $this->Session->read('tmpUser');
        if ($this->request->is('post') || $this->request->is('put')) {
            $user['email'] = $this->request->data['User']['email'];
            if (! $this->Account->User->validateEmail($this->request->data)) {
                return $this->Session->setFlash(__('Возникла ошибка при заполнении. Пожалуйста, попробуйте еще раз.'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
            if ($id = $this->Account->User->checkEmail($this->request->data['User']['email'])) {
                $this->Session->delete('tmpUser');
                $user['user_id'] = $id;
                $user['activate_token'] = $this->Account->User->generateToken();
                if ($this->Account->save($user)) {
                    if ($this->Account->sendActivationAccount($this->Account->getLastInsertID(), $this->name)) {
                        $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту.'), 'alert', array(
                            'class' => 'alert-success'
                        ));
                        $this->redirect('/');
                    }
                    $this->Session->setFlash(__('Вы успешно прошли регистрацию. Возникли проблемы при отправке КодА активации аккаунта.'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                    $this->redirect('/');
                } else {
                    $this->Session->setFlash('Error create account', 'alert', array(
                        'class' => 'alert-error'
                    ));
                    $this->redirect('/');
                }
            }
            $this->Session->write('tmpUser', $user);
            $this->redirect(array(
                'action' => 'confirm_user_data'
            ));
        } else {
            $this->request->data['User']['email'] = $user['email'];
        }
    }

    public function confirm_user_data() {
        if (! $this->Session->check('tmpUser')) {
            $this->redirect('/');
        }
        $userTmp = $this->Session->read('tmpUser');
        if ($this->request->is('post') || $this->request->is('put')) {
            $password = $this->Account->User->generateToken();
            $saveData = array(
                'first_name'        => $this->request->data['User']['first_name'],
                'last_name'         => $this->request->data['User']['last_name'],
                'email'             => $this->request->data['User']['email'],
                'username'          => $this->request->data['User']['username'],
                'password'          => $password, 
                'password_confirm'  => $password                          
            );
            if ($this->Account->User->register($saveData)) {    
                $userTmp['user_id'] = $this->Account->User->getLastInsertID();
                $userTmp['activate_token'] = $this->Account->User->generateToken();
                if ($this->Account->save($userTmp)) {
                    if ($this->Account->sendActivationAccount($this->Account->getLastInsertID(), $this->name)) {
                        $this->Session->setFlash(__('Код активации аккаунта был выслан Вам на почту.'), 'alert', array(
                            'class' => 'alert-success'
                        ));
                        $this->Session->delete('tmpUser');
                        $this->redirect('/');
                    }
                    $this->Session->setFlash(__('Вы успешно прошли регистрацию. Возникли проблемы при отправке КодА активации аккаунта.'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                    $this->Session->delete('tmpUser');
                    $this->redirect('/');
                } else {
                    $this->Session->setFlash('Error create user profile', 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
                $this->Session->delete('tmpUser');
                $this->redirect('/');
            } else {
                return $this->Session->setFlash('Error create account', 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        } else {
            $this->request->data['User'] = $userTmp;
        }
    }

    public function activate($hash = null) {
        if ($hash) {
            if ($result = $this->Account->activate($hash)) {
                $password = substr( str_shuffle( 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$' ) , 0 , 8 );
                if(!$result['User']['active']){
                    $saveData = array(
                        'id'                => $result['User']['id'],
                        'password'          => AuthComponent::password($password),
                        'password_confirm'  => AuthComponent::password($password),
                        'active'            => 1,
                        'activate_token'    => null                      
                    );
                    if($this->Account->User->save($saveData, true, array('active', 'activate_token', 'password'))){
                        App::uses('CakeEmail', 'Network/Email');
                        $email = new CakeEmail();
                        $email->template('send_password_after_activate_account', 'default');
                        $email->emailFormat(Configure::read('Email.global.format'));
                        $email->from(Configure::read('Email.global.from'));
                        $email->to($result['User']['email']);
                        $email->subject(Configure::read('Email.user.activateAccount.subject'));
                        $email->viewVars(array( 'username' => $result['User']['username'],
                                                'password' => $password,
                                                'full_name' => $result['User']['full_name'] 
                                                ));
                        $email->send();
                    }
                }
                $user = $result['User'];
                $user['provider'] = $result[$this->modelClass]['provider'];
                $this->Auth->login($user);
                $this->Session->setFlash('Your account has been activated.', 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect($this->Auth->redirect());
            }
        }
        $this->Session->setFlash(__('Invalid key.'));
        $this->redirect(array(
            'controller' => 'Users', 
            'action' => 'login'
        ));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (! $this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if (! $this->Account->findByIdAndUserId($id, $this->Auth->user('id'))) {
            throw new NotFoundException(__('Invalid Account'));
        }
        $this->Account->id = $id;
        if ($this->Account->delete()) {
            $this->Session->setFlash(__('Account deleted'));
            $this->redirect(array(
                'controller' => 'Users', 
                'action' => 'accounts'
            ));
        }
        $this->Session->setFlash(__('Account was not deleted'));
        $this->redirect(array(
            'controller' => 'Users', 
            'action' => 'accounts'
        ));
    }
}
