<?php
App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');
class AppController extends Controller {
    public $helpers = array(
        'Text',
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
                'controller' => 'Pages', 
                'action' => 'index'
            ), 
            'authError' => ' ', 
            'authorize' => array(
                'Controller'
            ), 
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User'
                )
            )
        ), 
        'RequestHandler',
        'Seo'
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
        if ((isset($this->request->params['device']) and ($this->request->params['device'] == 'm'))) { // ||$this->RequestHandler->isMobile ()
            $mobileViewFile = 'View' . DS . $this->name . '/mobile/' . Inflector::underscore($this->request->params['action']) . '.ctp';
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

        $this->_setLanguage();
        $this->__setTimeZone();
        $this->_checkMobile();
        
        $this->Seo->title = Configure::read('Site.title');
        $this->Seo->description = Configure::read('Site.description');
        $this->Seo->keywords = Configure::read('Site.keywords');
    }
    
    public function _setLanguage(){
        if (isset($this->request->params['lang']) and array_key_exists($this->request->params['lang'], Configure::read('Config.langListURL'))) {
            $arrLang = Configure::read('Config.langListURL');
            Configure::write('Config.language', $arrLang[$this->request->params['lang']]);
            Configure::write('Config.langURL', $this->request->params['lang']);
        }else{
            if(($this->request->params['controller'] != 'accounts' and $this->request->params['action'] != 'loginzalogin') 
                and !$this->request->is('ajax')){
                $this->redirect(DS.Configure::read('Config.langURL').$this->request->here);    
            }
        }
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
        sleep(1);
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
                //$request[$value] = Sanitize::clean($request[$value], array('encode' => true ,'remove_html' => true));
            }
        } else {
            //if($model){
            //$this->request->data[$model] = Sanitize::clean($request, array('encode' => true ,'remove_html' => true));
            //}else{
                //$this->request->data = Sanitize::clean($request, array('encode' => true ,'remove_html' => true));    
            //}
            return isset($request[$data]);
        }
        //if($model){
            //$this->request->data[$model] = $request;
        //}else{
                //$this->request->data = $request;    
        //}
        return true;
    }
    
    
    
}