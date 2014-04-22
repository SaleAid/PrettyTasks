<?php
/**
 * AutoLoginComponent
 *
 * A CakePHP Component that will automatically login the Auth session for a duration if the user requested to (saves data to cookies).
 */
App::uses('Security', 'Utility');
App::uses('Component', 'Controller');

class AutoLoginComponent extends Component {

	/**
	 * Components.
	 *
	 * @access public
	 * @var array
	 */
	public $components = array(
                'Auth', 
                'Cookie' => array(
                        'httpOnly' => true,
                        'name' => 'PT',
                )
        );

	/**
	 * Name of the user model.
	 *
	 * @access public
	 * @var string
	 */
	public $model = 'User';

	/**
	 * Users login/logout controller.
	 *
	 * @access public
	 * @var string
	 */
	public $controller = 'Accounts';

	/**
	 * Name of the auto login cookie.
	 *
	 * @access public
	 * @var string
	 */
	public $cookieName = 'aLpT';

	/**
	 * Duration in cookie length, using strtotime() format.
	 *
	 * @access public
	 * @var string
	 */
	public $expires = '+2 weeks';

	/**
	 * Domain used on a local environment (localhost).
	 *
	 * @access public
	 * @var boolean
	 */
	public $cookieLocalDomain = false;

	/**
	 * Force a redirect after successful auto login.
	 *
	 * @access public
	 * @var boolean
	 */
	public $redirect = true;

	/**
	 * Displayed checkbox determines if cookie is created.
	 *
	 * @access public
	 * @var boolean
	 */
	public $requirePrompt = true;

	/**
	 * Force the process to continue or exit.
	 *
	 * @access public
	 * @var boolean
	 */
	public $active = true;

	/**
	 * Should we debug?
	 *
	 * @access protected
	 * @var boolean
	 */
	protected $_debug = false;

	/**
	 * Initialize settings and debug.
	 *
	 * @access public
	 * @param Controller $controller
	 */
	public function initialize(Controller $controller) {
		
        $autoLogin = (array) Configure::read('AutoLogin');

		// Is debug enabled?
		$this->_debug = (!empty($autoLogin['ips']) && in_array(env('REMOTE_ADDR'), (array) $autoLogin['ips']));
		$this->startup($controller);
	}

	/**
	 * Automatically login existent Auth session; called after controllers beforeFilter() so that Auth is initialized.
	 *
	 * @access public
	 * @param Controller $controller
	 * @return void
	 */
	public function startup(Controller $controller) {
	   
		$this->Cookie->type('rijndael');
        $this->Cookie->key = Configure::read('AutoLogin.cookie.key');
        
        // Backwards support
		if (isset($this->settings)) {
			$this->_set($this->settings);
		}

		// Detect cookie or login
		$cookie = $this->read();
        $user = $this->Auth->user();
        //pr($cookie);
        
        
		if (!$this->active || !empty($user) || !$controller->request->is('get')) {
			return;

		} else if ($cookie === null) {
			$this->debug('cookieFail', $this->Cookie, $user);
			$this->delete();
			return;

		} else if (empty($cookie['hash']) || $cookie['hash'] !== $this->Auth->password(Configure::read('AutoLogin.hash.key') . $cookie['account'] . $cookie['time'])
                    || empty($cookie['user_agent']) || $cookie['user_agent'] !== $controller->request->header('User-Agent')
            ) {
			$this->debug('hashFail', $this->Cookie, $user);
			$this->delete();
			return;
		}

		// Set the data to identify with
		$result = $this->_getUserByememberKey($cookie['rmb_key'], $cookie['account']);
        if(!$result['Account'] or !$result['User']){
            $this->delete();
			return;
        }
        //pr($result);die;
        $user = $result['User'];
        $user['account_id'] = $result['Account'][0]['id'];
        $user['provider'] = $result['Account'][0]['provider'];
        $user['full_name'] = $result['Account'][0]['full_name'];
        
        if ($this->Auth->login($user)) {
			$this->debug('login', $this->Cookie, $this->Auth->user());

			if (in_array('_autoLogin', get_class_methods($controller))) {
				call_user_func(array($controller, '_autoLogin'), $this->Auth->user());
			}

			if ($this->redirect) {
				$controller->redirect(array(), 301);
			}
		} else {
			$this->debug('loginFail', $this->Cookie, $this->Auth->user());

			if (in_array('_autoLoginError', get_class_methods($controller))) {
				call_user_func(array($controller, '_autoLoginError'), $this->read());
			}
		}
	}

	
	/**
	 * Read the AutoLogin cookie and base64_decode().
	 *
	 * @access public
	 * @return array|null
	 */
	public function read() {
		$cookie = $this->Cookie->read($this->cookieName);
        if (empty($cookie) || !is_array($cookie)) {
			return null;
		}
        
		if (isset($cookie['account'])) {
			$cookie['account'] = base64_decode($cookie['account']);
		}

		if (isset($cookie['rmb_key'])) {
		    //$cookie['rmb_key'] = Security::cipher($user['rmb_key'], Configure::read('AutoLogin.rmb.key'));
			//$cookie['rmb_key'] = Security::rijndael($cookie['rmb_key'], Configure::read('AutoLogin.rmb.key'), 'decrypt');
            $cookie['rmb_key'] = base64_decode($cookie['rmb_key']);
		}
        
        if (isset($cookie['user_agent'])) {
			$cookie['user_agent'] = base64_decode($cookie['user_agent']);
		}
		return $cookie;
	}

	/**
	 * Remember the user information.
	 *
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return void
	 */
	public function write($user, $userAgent) {
		$time = time();

        if(empty($user['rmb_key'])){
           $user['rmb_key'] = $this->_getRememberKey();
        }
        
        $cookie = array();
		$cookie['account'] = base64_encode($user['account_id']);
        //$cookie['rmb_key'] = Security::cipher($user['rmb_key'], Configure::read('AutoLogin.rmb.key'));
		//$cookie['rmb_key'] = Security::rijndael($user['rmb_key'], Configure::read('AutoLogin.rmb.key'), 'encrypt');
        $cookie['rmb_key'] = base64_encode($user['rmb_key']);
        $cookie['user_agent'] = base64_encode($userAgent);
		$cookie['hash'] = $this->Auth->password(Configure::read('AutoLogin.hash.key') . $user['account_id'] . $time);
		$cookie['time'] = $time;
        if (env('REMOTE_ADDR') === '127.0.0.1' || env('HTTP_HOST') === 'localhost') {
			$this->Cookie->domain = $this->cookieLocalDomain;
		}
        $this->Cookie->write($this->cookieName, $cookie, true, $this->expires);
		$this->debug('cookieSet', $cookie, $this->Auth->user());
    }
    
    private function _getRememberKey(){
        $userModel = ClassRegistry::init('User');
        $user = $userModel->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ),
            'fields' => array('rmb_key', 'id'),
            'contain' => array()
        ));
        
        if(empty($user['User']['rmb_key'])){
            $user['User']['rmb_key'] = Security::generateAuthKey();
            $user = $userModel->save($user, true, array('rmb_key'));
        }
        return isset($user['User']['rmb_key']) ? $user['User']['rmb_key'] : false;
    }
    
    private function _getUserByememberKey($key, $accountId){
        $userModel = ClassRegistry::init('User');
        return $userModel->find('first', array(
            'conditions' => array(
                'User.rmb_key' => $key
            ),
            'contain' => array('Account' => array(
                                    'conditions' => array(
                                    'Account.id' => $accountId
                                )
                            )
            )
        ));
        
    }

	/**
	 * Delete the cookie.
	 *
	 * @access public
	 * @return void
	 */
	public function delete() {
		$this->Cookie->delete($this->cookieName);
	}

	/**
	 * Debug the current auth and cookies.
	 *
	 * @access public
	 * @param string $key
	 * @param array $cookie
	 * @param array $user
	 * @return void
	 */
	public function debug($key, $cookie = array(), $user = array()) {
		$scopes = array(
			'login'				=> 'Login Successful',
			'loginFail'			=> 'Login Failure',
			'loginCallback'		=> 'Login Callback',
			'logout'			=> 'Logout',
			'logoutCallback'	=> 'Logout Callback',
			'cookieSet'			=> 'Cookie Set',
			'cookieFail'		=> 'Cookie Mismatch',
			'hashFail'			=> 'Hash Mismatch',
			'custom'			=> 'Custom Callback'
		);

		if ($this->_debug && isset($scopes[$key])) {
			$debug = (array) Configure::read('AutoLogin');
			$content = "";

			if ($cookie || $user) {
				if ($cookie) {
					$content .= "Cookie information: \n\n" . print_r($cookie, true) . "\n\n\n";
				}

				if ($user) {
					$content .= "User information: \n\n" . print_r($user, true);
				}
			} else {
				$content = 'No debug information.';
			}

			if (empty($debug['scope']) || in_array($key, (array) $debug['scope'])) {
				if (!empty($debug['email'])) {
					mail($debug['email'], '[AutoLogin] ' . $scopes[$key], $content, 'From: ' . $debug['email']);
				} else {
					$this->log($scopes[$key] . ': ' . $content, LOG_DEBUG);
				}
			}
		}
	}

}