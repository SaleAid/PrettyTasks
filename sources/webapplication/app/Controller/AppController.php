<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
    public $helpers = array(
        'Combinator.Combinator',//TODO I think it will be to heavy to use directly in project, need to use it only when publishing
        'Form', 
        'Html', 
        'Js',
        'Time',
        'Session',
        'Loginza'//TODO Maybe move to needed controllers only?
    );
    public $components = array(
        'AutoLogin', 
        'Session', 
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users', 
                'action' => 'login'
            ), 
            'loginRedirect' => array(
                'controller' => 'tasks', 
                'action' => 'index'
            ), 
            'logoutRedirect' => array(
                'controller' => 'users', 
                'action' => 'login'
            ), 
            'authError' => 'You cannot access that action! ', 
            'authorize' => array(
                'Controller'
            ), 
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User'
                )
            )
        ), 
        'RequestHandler'
    );

    /**
     * 
     * Cake autorization function
     * @param unknown_type $user
     */
    public function isAuthorized($user) {
        return true;
    }

    /**
     * 
     * Checking user have pro account
     * @access public
     * @return boolean
     */
    public function isProUser() {
        return $this->Auth->user('pro');
    }

    /**
     * 
     * Checking user have access to beta functions
     * @access public
     * @return boolean
     */
    public function isBetaUser() {
        return $this->Auth->user('beta');
    }

    /**
     * 
     * Check for showing mobile version
     * To add logic for switching to mobile and normal version
     */
    protected function _checkMobile() {
        //TODO add smarty auto detection
        //$this->layout = 'default';
        if ((isset($this->params['device']) and ($this->params['device'] == 'm'))) { // ||$this->RequestHandler->isMobile ()
            $mobileViewFile = 'View' . DS . $this->name . '/mobile/' . Inflector::underscore($this->params['action']) . '.ctp';
            if (file_exists(APP . DS . $mobileViewFile)) {
                $this->layout = 'mobile';
                $mobileView = $this->name . '/mobile';
                $this->viewPath = $mobileView;
            }
        }
    }

    private function __setTimeZone() {
        $timezone = $this->Auth->user('timezone');
        if ($timezone) {
            date_default_timezone_set($timezone);
        }
    }

    public function beforeFilter() {
        /*
        //        $this->AutoLogin->settings = array(
        //    		// Model settings
        //    		'model' => 'User',
        //    		'username' => 'username',
        //    		'password' => 'password',
        //     
        //    		// Controller settings
        //    		'plugin' => '',
        //    		'controller' => 'users',
        //    		'loginAction' => 'login',
        //    		'logoutAction' => 'logout',
        //     
        //    		// Cookie settings
        //    		'cookieName' => 'rememberMe1',
        //    		'expires' => '+1 month',
        //     
        //    		// Process logic
        //    		'active' => true,
        //    		'redirect' => true,
        //    		'requirePrompt' => false,
        //        );
        //  
         */
        $this->__setTimeZone();
        $this->_checkMobile();
        //$this->loadModel('User');
    }

    public function beforeRender() {
        $this->set('currentUser', $this->Auth->user());
        $this->set('provider', $this->Auth->user('provider'));
        $this->set('isProUser', $this->isProUser());
        $this->set('isBetaUser', $this->isBetaUser());
    }
    
    protected function _prepareResponse() {
        return array(
            'success' => false
        );
    }
    
    protected function _isSetRequestData($data, $model = null) {
         if (!($this->request->is('post') || $this->request->is('put'))) {
            return false;
        }
        $request = $this->request->data;
        if($model){
            $request = $this->request->data[$model];
        }
        if (is_array($data)) {
            foreach ( $data as $value ) {
                if (! isset($request[$value])) {
                    return false;
                }
            }
        } else {
            return isset($request[$data]);
        }
        return true;
    }
}