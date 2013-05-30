<?php

App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');
//App::uses('L10n', 'I18n');
class AppController extends Controller {
    public $helpers = array(
        'Text', 
        'Form', 
        'Html', 
        'Js', 
        'Time', 
        'Session', 
        'Loginza', //TODO Maybe move to needed controllers only?
        //'Captcha'
    );
    public $components = array(
        'AutoLogin' => array('cookieName' => 'RM',
                             'expires' => '+1 month',
                             'username' => 'email'
                            ), 
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
            'authError' => ' ', 
            'authorize' => array(
                'Controller'
            ), 
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'User', 
                    'fields' => array(
                        'username' => 'email'
                    )
                )
            )
        ), 
        'RequestHandler', 
        'Seo',
        'Captcha'   
    );
    
    public $L10n = null;


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
        date_default_timezone_set(Configure::read('Config.timezone'));
        //$timezone = $this->Auth->user('timezone');
        //if ($timezone) {
            //date_default_timezone_set($timezone);
        //}
    }
    
    private function __userTimeZoneOffset(){
        $timezone = $this->Auth->user('timezone');
        
        if (!$timezone) {
            return;    
        }
        $dateTimeZoneServer = new DateTimeZone(Configure::read('Config.timezone'));
        $dateTimeZoneUser = new DateTimeZone($timezone);
        $dateTimeServer = new DateTime("now", $dateTimeZoneServer);
        $dateTimeUser = new DateTime("now", $dateTimeZoneUser);
        $timeOffset = $dateTimeZoneUser->getOffset($dateTimeServer);
        return $timeOffset;
    }
    
    public function beforeFilter() {
        $this->_setLanguage();
        $this->__setTimeZone();
        $this->_checkMobile();
        
        $this->Seo->title = Configure::read('Site.title');
        $this->Seo->description = Configure::read('Site.description');
        $this->Seo->keywords = Configure::read('Site.keywords');
        
        $this->set('isAuth', $this->Auth->loggedIn()); 
        $this->set('currentUser', $this->Auth->user());
        $this->set('provider', $this->Auth->user('provider'));
        $this->set('timezone', $this->__userTimeZoneOffset());
        $this->set('isProUser', $this->isProUser());
        $this->set('isBetaUser', $this->isBetaUser());
        
    }

    public function _setLanguage() {
        $this->L10n = new L10n();
        $params = $this->request->params;
        //pr($this->request);die;
        if (isset($params['lang'])) {
            $lang = $this->_hasLangList($params['lang']);
            if($lang){
                Configure::write('Config.langURL', $params['lang']);
                Configure::write('Config.language', $lang);
                return;
            }elseif($lang = $this->_userLang()){
                $params['lang'] = $this->L10n->map($lang);
            }elseif($lang = $this->_browserLang()){
                $params['lang'] = $this->L10n->map($lang);
            }else{
                $lang = $this->L10n->map(Configure::read('Config.language'));
                $params['lang'] = $this->L10n->map($lang);
            }
        } else {
            if ( $params['action'] == 'loginzalogin' or $this->request->is('ajax')) {
               return;  
            }
            if($lang = $this->_userLang()){
                $language = $lang;
            }elseif($lang = $this->_browserLang()){
                $language = $lang;
            }else{
                //$language = $this->L10n->map(Configure::read('Config.language'));
                $language = Configure::read('Config.language');
            }
            $params['lang'] = $this->L10n->map($language);
        }
        if(empty($params['named']))
            unset($params['named']);
        if(empty($params['pass']))
            unset($params['pass']);
        if( !empty($this->request->query))   
            $params['?'] = $this->request->query;
        //pr($params);die;        
        $this->redirect($params);
    }
    
    protected function _browserLang(){
        $brLangs = CakeRequest::acceptLanguage();
        foreach($brLangs as $brLang){
            $lang = $this->_hasLangList($brLang);
            if($lang){
                return $lang;
            }
        }
        return false;
    }
    
    protected function _userLang(){
        if($this->Auth->loggedIn()){
            return $this->Auth->user('language');
        }
        return false;
    }
    
    protected function _hasLangList($lang){
        if(empty($lang)){
           return false; 
        }
        if(array_key_exists($lang, Configure::read('Config.lang.available'))){
            $langL10n = $this->L10n->catalog($lang);
            return $langL10n['locale'];
        }
        return false;
    }

    protected function _prepareResponse() {
        return array(
            'success' => false
        );
    }

    protected function _isSetRequestData($data, $model = null) {
        if (! ($this->request->is('post') || $this->request->is('put'))) {
            return false;
        }
        $request = $this->request->data;
        if ($model) {
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
    
    public function captcha() {
        //comment out the code below if the captcha doesn't render on localhost,For Unix/Linux Servers it works fine.
       /* $this->Captcha->configCaptcha(array(
         'pathType'=>2
         ));*/
         $this->Captcha->getCaptcha();
    }
}