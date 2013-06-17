<?php
App::uses('AppController', 'Controller');
App::uses('Validation', 'Utility');
class AccountsController extends AppController {
    
    public $name = 'Accounts';
    
    public $uses = array('Account', 'AccountSocial');
    
    public $components = array(
        'RequestHandler', 
        'Captcha',
        'Cookie'
    );
    
     public $helpers = array(
        'Loginza'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'selectMode', 'activate', 'reactivate', 'register', 'register_success', 'opauth_complete', 'cancel', 'captcha', 'password_resend', 'password_reset');
        if ($this->Auth->user() && in_array($this->params['action'], 
                                            array(
                                                'login',
                                                'activate', 
                                                'reactivate', 
                                                'register',
                                                'selectMode'
                                            ))) {
            $this->redirect('/');
        }
    }

    public function isAuthorized($user) {
        return true;
    }
    
    public function login() {
        
        $this->layout = 'login';
        $this->Seo->title = $this->Seo->title.' :: '.Configure::read('SEO.Login.title.'.Configure::read('Config.langURL'));
        $this->Seo->description = Configure::read('SEO.Login.description.'.Configure::read('Config.langURL'));
        $this->Seo->keywords = Configure::read('SEO.Login.keywords.'.Configure::read('Config.langURL'));
        
        $message = __d('accounts', 'Ваш емейл или пароль не совпадают');
        
        if( isset($this->data['Account']['email']) && !Validation::email($this->data['Account']['email']) ){
              $this->request->data['Account']['login'] = $this->data['Account']['email'];
              $this->Auth->authenticate['Form'] = array('fields' => array('username' => 'login', 'password' => 'password'), 'userModel' => 'Account');
              $message = __d('accounts', 'Ваш логин или пароль не совпадают');
        }
        if ($this->Auth->login()) {
            if ($this->Auth->user('active')) {
                $user = $this->Auth->user('User');
                $user['account_id'] = $this->Auth->user('id');
                $user['provider'] = $this->Auth->user('provider');
                $user['full_name'] = $this->Auth->user('full_name');
                $this->Auth->login($user);
                if (! $this->Auth->user('is_blocked')) {
                    //if($this->Session->check('auth-new-accounts')){
                    //    $this->redirect(array('action' => 'confirmSocialLinks'));
                    //}
                    $this->_redirectAfterLogin();
                }
                $this->Session->setFlash(__d('users', 'Ваш аккаунт заблокирован'), 'alert', array(
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
        
        
    }
    
    private function _redirectAfterLogin(){
        if($this->Auth->user('language')){
            $this->Auth->loginRedirect['lang'] = $this->L10n->map($this->Auth->user('language'));
        }
        return $this->redirect($this->Auth->loginRedirect);
    }
    
    private function _confirmSocialLink(){
        if(!$this->Session->check('auth-new-accounts') ||
           !($this->request->is('post') || $this->request->is('put')) ||
           !isset($this->request->data['id']) ||
           !isset($this->request->data['action'])
           ){
            $result = array('status' => 0, 'message' => __d('accounts', 'Ошибка при передаче данных'));
        }else{
            $newAccounts = $this->Session->read('auth-new-accounts');
            $id = $this->request->data['id'];
            $action = $this->request->data['action'];
            if (array_key_exists($this->request->data['id'], $newAccounts)) {
                if($action){
                    $this->AccountSocial->save(array(
                                'id' => $newAccounts[$id]['id'],
                                'user_id' => $this->Auth->user('id'),
                                'active' => 1,
                                'agreed' => 1
                            )
                    );    
                }
                unset($newAccounts[$id]);
                $this->Session->delete('auth-new-accounts');
                if($action){
                    $result = array('status' => 1, 'action' => $action, 'message' => __d('accounts', 'Добавлен'));
                } else {
                    $result = array('status' => 1, 'action' => $action, 'message' => __d('accounts', 'Отклонен'));
                }
                if(count($newAccounts)){
                    $this->Session->write('auth-new-accounts', $newAccounts);
                }else{
                    //$result = array('status' => 2, 'action' => $action, 'message' => __d('accounts', 'Добавлен'));
                    $result['status'] = 2;
                }
            }else{
                $result = array('status' => 0, 'message' => __d('accounts', 'Ошибка отсутствует такой аккаунт'));
            }
        }
        $newAccounts = $this->Session->read('auth-new-accounts');
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }
    
    public function confirmSocialLinks(){
        $this->layout = 'login';
        if ($this->request->is('ajax')) {
            $this->_confirmSocialLink();
        }else {
            if(!$this->Session->check('auth-new-accounts')){
                $this->redirect('/');
            }
            $newAccounts = $this->Session->read('auth-new-accounts');
            if ($this->request->is('POST')) {
                if(isset($this->request->data['allowAll'])){
                    foreach($newAccounts as $account){
                        $this->AccountSocial->save(array(
                                'id' => $account['id'],
                                'user_id' => $this->Auth->user('id'),
                                'active' => 1,
                                'agreed' => 1
                            )
                        );   
                    }
                    $this->Session->delete('auth-new-accounts');
                } elseif(isset($this->request->data['denyAll'])){
                    $this->Session->delete('auth-new-accounts');
                }
                $this->_redirectAfterLogin();
            }
            $this->set('newAccounts', $newAccounts);    
        }
    }
    
    public function selectMode(){
        $this->layout = 'login';
        if(!$this->Session->check('auth-new-accounts')){
            $this->redirect(array('action' => 'login'));
        }
        $newAccounts = $this->Session->read('auth-new-accounts');
        if ($this->request->is('post')) {
            if (isset($this->request->data['Account']['agreed']) && $this->Account->saveAll($this->request->data, array('validate' => 'only'))) {
                if (isset($this->request->data['Account']['newAccount']) && $this->request->data['Account']['newAccount']){ //new user
                    
                    if (isset($_COOKIE["timezoneOffset"])){
                        $timezoneOffset = $_COOKIE['timezoneOffset'];
                        unset($_COOKIE['timezoneOffset']);    
                    }
                    $data = array(
                        'active' => 1,
                        'agreed' => 1,
                        'language' => Configure::read('Config.language'),
                        'timezone_offset' => isset($timezoneOffset) ? $timezoneOffset : null
                    );
                    $this->Account->User->create();
                    $user = $this->Account->User->save($data);
                    $newAccount = end($newAccounts);
                    array_pop($newAccounts);
                    if($user){
                        $account = $this->AccountSocial->save(array(
                                    'id' => $newAccount['id'],
                                    'user_id' => $user['User']['id'],
                                    'active' => 1,
                                    'agreed' => 1,
                                    'master' => 1
                                )
                        );
                        $this->Session->delete('auth-new-accounts');
                        $user['User']['provider'] = $newAccount['provider'];
                        $user['User']['full_name'] = $newAccount['full_name'];
                        $user['User']['account_id'] = $newAccount['id'];
                        $this->Auth->login($user['User']);
                        
                        if(count($newAccounts)){
                            $this->Session->write('auth-new-accounts', $newAccounts);
                            $this->redirect(array('action' => 'confirmSocialLinks'));
                        }
                        $this->_redirectAfterLogin();
                    }
                }else{ //linked user
                    $this->redirect(array('action' => 'login'));
                }
            }
        }
        
    }
    
    
    public function cancel(){
        if($this->Session->check('tmp-auth-new-account')){
            $this->Session->delete('tmp-auth-new-account');
        }
        $this->redirect(array(
            'action' => 'login'
        ));
    }
    
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public function link($provider = null){
        if(empty($provider)){
            $this->redirect(array(
                'controller' => 'users', 
                'action' => 'accounts'
            ));
        }
        $this->Session->write('link-new-accounts', true);
        $this->redirect(array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', $provider));
        
    }
    
    private function _linked($accData){
        $this->Session->delete('link-new-accounts');
        switch ($accData['status']) {
                case 1 :
                    {
                        if($accData['data']['id'] == $this->Auth->user('id')){
                            $this->Session->setFlash(__d('accounts', 'Этот аккаунт уже связан'), 'alert', array(
                                'class' => 'alert-info'
                            )); 
                        } else {
                            $this->Session->setFlash(__d('accounts', 'Этот аккаунт уже связан с другим пользователем'), 'alert', array(
                                'class' => 'alert-error'
                            ));
                        }
                        break;
                    }
                case 0 :
                    {
                        $this->AccountSocial->save(array(
                                'id' => $accData['data']['id'],
                                'user_id' => $this->Auth->user('id'),
                                'active' => 1,
                                'agreed' => 1
                            )
                        );   
                        $this->Session->setFlash(__d('accounts', 'Этот аккаунт успешно прикреплен'), 'alert', array(
                            'class' => 'alert-info'
                        )); 
                        break;
                    }
                case 2 :
                    {
                        $this->Session->setFlash($accData['errors'], 'alert', array(
                            'class' => 'alert-error'
                        ));
                        break;
                    }
            }
        $this->redirect(array(
            'controller' => 'users', 
            'action' => 'accounts'
        ));
        
    }
    
    public function opauth_complete() {
        
        if(isset($this->data['validated']) && $this->data['validated']){
            $auth = $this->data['auth'];
            
            $result = $this->AccountSocial->check($auth);
            
            if ($this->Auth->loggedIn() && $this->Session->check('link-new-accounts')) {
                return $this->_linked($result);
            }
            switch ($result['status']) {
                case 1 :
                    {
                        $this->Auth->login($result['data']);
                        if($this->Session->check('auth-new-accounts')){
                            $newAccounts = $this->Session->read('auth-new-accounts');
                            if(count($newAccounts)){
                                $this->Session->write('auth-new-accounts', $newAccounts);
                                $this->redirect(array('action' => 'confirmSocialLinks'));
                            }
                        }
                        $this->_redirectAfterLogin();
                        break;
                    }
                case 0 :
                    {
                        $newAccounts = array();
                        if($this->Session->check('auth-new-accounts')){
                            $newAccounts = $this->Session->read('auth-new-accounts');
                        }
                        
                        foreach($newAccounts as $key => $account){
                            if($account['id'] == $result['data']['id']){
                                unset($newAccounts[$key]);
                            }
                        }
                        $newAccounts[] = $result['data'];
                        $this->Session->write('auth-new-accounts', $newAccounts);
                        $this->redirect(array(
                            'action' => 'selectMode'
                        ));
                        break;
                    }
                case 2 :
                    {
                        $this->Session->setFlash($result['errors'], 'alert', array(
                            'class' => 'alert-error'
                        ));
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    }
            }
        }
        pr($this->data)	;die;
        $this->Session->setFlash(__d('accounts', 'An unknown error'), 'alert', array(
            'class' => 'alert-error'
        ));
        $this->redirect(array(
            'action' => 'login'
        ));
	}
    
    public function activate($token = null) {
        if ($token) {
            if ($result = $this->Account->activate($token)) {
                $newAccounts = array();
                if($this->Session->check('auth-new-accounts')){
                    $newAccounts = $this->Session->read('auth-new-accounts');
                }
                $newAccount['id'] = $result['Account']['id'];
                $newAccount['provider'] = $result['Account']['provider'];
                $newAccount['full_name'] = $result['Account']['full_name'];    
                $newAccounts[] = $newAccount;
                $this->Session->write('auth-new-accounts', $newAccounts);
                $this->redirect(array(
                    'action' => 'selectMode'
                ));
            }
        }
        $this->Session->setFlash(__d('accounts', 'Invalid key'), 'alert', array(
                    'class' => 'alert-error'
                ));
        $this->redirect(array(
            'action' => 'login'
        ));
    }
    
    public function reactivate() {
        if (!$this->_isSetRequestData('email')) {
            $this->Session->setFlash(__d('accounts', 'Ошибка при передаче данных'), 'alert', array(
                    'class' => 'alert-error'
                ));
        } else {
            if (Validation::email($this->request->data['email']) && $this->Account->reactivate($this->request->data['email'])) {
                $this->Session->setFlash(__d('accounts', 'Код активации аккаунта был выслан Вам на почту'), 'alert', array(
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
         $this->layout = 'profile';
        if ($this->request->is('post') || $this->request->is('put')) {
            $expectedData = array(
                'password', 
                'password_confirm',
                'old_password'
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__d('accounts', 'Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                if ($this->Account->password_change($this->Auth->user('account_id'), $this->request->data[$this->modelClass]['password'],
                                                                          $this->request->data[$this->modelClass]['password_confirm'], 
                                                                          $this->request->data[$this->modelClass]['old_password'])) {
                    return $this->Session->setFlash(__d('accounts', 'Ваш пароль успешно изменен'), 'alert', array(
                        'class' => 'alert-success'
                    ));
                }
                unset($this->request->data[$this->modelClass]['password']);
                unset($this->request->data[$this->modelClass]['password_confirm']);
                unset($this->request->data[$this->modelClass]['old_password']);
                return $this->Session->setFlash(__d('accounts', 'Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }
    
    public function password_resend() {
        if ($this->Auth->loggedIn()) {
            if($this->Auth->user('provider') == 'local'){
                if ($this->Account->password_resend($this->Auth->user('account_id'))) {
                    $this->Session->setFlash(__d('accounts', 'На Вашу почту была отправлена инструкция по сбросу пароля'), 'alert', array(
                        'class' => 'info-success'
                    ));
                }    
            }
            $this->redirect(array('action' => 'password_change'));
        }
        
        $this->layout = 'login';
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!$this->_isSetRequestData('email', $this->modelClass)) {
                $this->Session->setFlash(__d('accounts', 'Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                if (!$this->Captcha->validateCaptcha() || !Validation::email($this->data[$this->modelClass]['email'])) {
                    return $this->Session->setFlash(__d('accounts', 'Возникла ошибка при заполнении. Пожалуйста, попробуйте еще раз'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
                if ($id = $this->Account->checkEmail($this->request->data[$this->modelClass]['email'])) {
                    if ($this->Account->password_resend($id)) {
                        $this->Session->setFlash(__d('accounts', 'На Вашу почту была отправлена инструкция по сбросу пароля'), 'alert', array(
                            'class' => 'info-success'
                        ));
                        $this->redirect(array(
                            'action' => 'login'
                        ));
                    }
                }
                $this->Session->setFlash(__d('accounts', 'В нашей базе нет пользователя с такой почтой'), 'alert', array(
                    'class' => 'alert-error'
                ));
            }
        }
    }
    
    public function password_reset($password_token = null) {
        $this->layout = 'login';
        if ($password_token) {
            if ($id = $this->Account->checkPasswordToken($password_token)) {
                if ($this->request->is('post') || $this->request->is('put')) {
                    $expectedData = array(
                        'password', 
                        'password_confirm'
                    );
                    if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                        $this->Session->setFlash(__d('accounts', 'Ошибка при передаче данных'), 'alert', array(
                                'class' => 'alert-error'
                            ));
                    } else {
                        if ($this->Account->password_change($id, $this->request->data[$this->modelClass]['password'], $this->request->data[$this->modelClass]['password_confirm'],null, true)) {
                            $this->Session->setFlash(__d('accounts', 'Ваш пароль успешно изменен'), 'alert', array(
                                'class' => 'alert-success'
                            ));
                            $this->redirect(array(
                                'action' => 'login'
                            ));
                        }
                        unset($this->request->data[$this->modelClass]['password']);
                        unset($this->request->data[$this->modelClass]['password_confirm']);
                        return $this->Session->setFlash(__d('accounts', 'Ваш пароль не может быть сохранен. Пожалуйста, попробуйте еще раз'), 'alert', array(
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
    
    public function register_success(){
        $this->layout = 'login';
        if(!$this->Session->check('new-register-account')){
            $this->redirect('/');
        }
        
        $isSent = false;
        if ($this->Account->sendActivationAccount($this->Session->read('new-register-account'))) {
            $isSent = true;
        }
        $this->Session->delete('new-register-account');
        $this->set('isSent', $isSent);
        
    }
    
    public function register() {
        $this->layout = 'login';
        $this->Seo->title = $this->Seo->title.' :: '.Configure::read('SEO.Registration.title.'.Configure::read('Config.langURL'));
        $this->Seo->description = Configure::read('SEO.Registration.description.'.Configure::read('Config.langURL'));
        $this->Seo->keywords = Configure::read('SEO.Registration.keywords.'.Configure::read('Config.langURL'));
        if ($this->request->is('post')) {
            $expectedData = array(
                'full_name',
                'email',
                //'login',
                'password', 
                'password_confirm',
                //'agreed'
            );
            if (!$this->_isSetRequestData($expectedData, $this->modelClass)) {
                $this->Session->setFlash(__d('accounts', 'Ошибка при передаче данных'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            } else {
                $saveData = array(
                    'full_name'        => $this->request->data[$this->modelClass]['full_name'],
                    'email'             => $this->request->data[$this->modelClass]['email'],
                    //'login'          => $this->request->data[$this->modelClass]['login'],
                    'password'          => $this->request->data[$this->modelClass]['password'], 
                    'password_confirm'  => $this->request->data[$this->modelClass]['password_confirm'],
                );
                if ($this->Captcha->validateCaptcha() and $this->Account->register($saveData)) {
                    $this->Session->write('new-register-account', $this->Account->getLastInsertID());
                    $this->redirect(array(
                        'action' => 'register_success',
                        
                    ));
                } else {
                    unset($this->request->data[$this->modelClass]['password']);
                    unset($this->request->data[$this->modelClass]['password_confirm']);
                    $this->Session->setFlash(__d('accounts', 'Регистрация не удалась. Заполните поля полностью'), 'alert', array(
                        'class' => 'alert-error'
                    ));
                }
            }
        }
    }
    
    /**
     * delete account
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (! $this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Account->contain();
        $account = $this->Account->findByIdAndUserId($id, $this->Auth->user('id'));
        if (! $account) {
            throw new NotFoundException(__d('accounts', 'Invalid Account'));
        }
        if ($account['Account']['master']) {
            $this->Session->setFlash(__d('accounts', 'Нельзя удалить основной аккаунт'), 'alert', array(
                'class' => 'alert-error'
            ));
            $this->redirect($this->referer());
        }
        $this->Account->id = $id;
        if ($this->Account->delete()) {
        //if ($this->Account->save(array('user_id' => null, 'active' => 0, 'agreed' => 0))) {
            $this->Session->setFlash(__d('accounts', 'Account deleted'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            if($id == $this->Auth->user('account_id')){
                $this->logout();
            }
            $this->redirect(array(
                'controller' => 'users', 
                'action' => 'accounts'
            ));
        }
        $this->Session->setFlash(__d('accounts', 'Account was not deleted'), 'alert', array(
                        'class' => 'alert-error'
                    ));
        $this->redirect(array(
            'controller' => 'users', 
            'action' => 'accounts'
        ));
    }
}
