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
    public $layout = 'login';

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
            if ($id = $this->Account->User->checkEmail($this->request->data)) {
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
            $this->request->data['User']['password'] = $this->request->data['User']['password_confirm'] = $this->Account->User->generateToken();
            if ($this->Account->User->save($this->request->data)) {
                $userTmp['user_id'] = $this->Account->User->getLastInsertID();
                $userTmp['activate_token'] = $this->Account->User->generateToken();
                if ($this->Account->save($userTmp)) {
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
            if ($this->Account->activate($hash)) {
                $this->Session->setFlash('Your account has been activated, please log in.', 'alert', array(
                    'class' => 'alert-success'
                ));
                $this->redirect('/');
            }
        }
        $this->Session->setFlash(__('Invalid key.'));
        $this->redirect('/');
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
