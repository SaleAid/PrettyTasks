<?php
/**
 * CakePHP OAuth Server Plugin
 * 
 * This is an example controller providing the necessary endpoints
 * 
 * @author Thom Seddon <thom@seddonmedia.co.uk>
 * @see https://github.com/thomseddon/cakephp-oauth-server
 *  
 */

App::uses('Validation', 'Utility');
App::uses('OAuthAppController', 'OAuth.Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class OAuthController extends OAuthAppController {
	
	public $components = array('OAuth.OAuth', 'Auth', 'Session', 'Security');

	public $uses = array('Users', 'Tasks');

	public $helpers = array('Form');
	
	private $blackHoled = false;

/**
 * beforeFilter
 *  
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->OAuth->authenticate = array('fields' => array('username' => 'email'));
		$this->Auth->allow($this->OAuth->allowedActions);
        
        $this->Security->blackHoleCallback = 'blackHole';
	}
    
   

/**
 * Example Authorize Endpoint
 * 
 * Send users here first for authorization_code grant mechanism
 * 
 * Required params (GET or POST):
 *	- response_type = code
 *	- client_id
 *	- redirect_url
 *  
 */
	public function authorize () {
       // $this->addC();
		if (!$this->Auth->loggedIn()) {
			$this->redirect(array('action' => 'login', '?' => $this->request->query));
		}
		
		if ($this->request->is('post')) {
			$this->validateRequest();

			$userId = $this->Auth->user('user_id');

			if ($this->Session->check('OAuth.logout')) {
				$this->Auth->logout();
				$this->Session->delete('OAuth.logout');
			}

			//Did they accept the form? Adjust accordingly
			$accepted = $this->request->data['accept'] == 'Allow';
            //debug($userId);
			try {
				$this->OAuth->finishClientAuthorization($accepted, $userId, $this->request->data['Authorize']);
			} catch (OAuth2RedirectException $e) {
				$e->sendHttpResponse();
			}
		}

		// Clickjacking prevention (supported by IE8+, FF3.6.9+, Opera10.5+, Safari4+, Chrome 4.1.249.1042+)
		$this->response->header('X-Frame-Options: DENY');

		if ($this->Session->check('OAuth.params')) {
				$OAuthParams = $this->Session->read('OAuth.params');
				$this->Session->delete('OAuth.params');
		} else {
			try {
				$OAuthParams =  $this->OAuth->getAuthorizeParams();
			} catch (Exception $e){
				$e->sendHttpResponse();
			}
		}
		$this->set(compact('OAuthParams'));
	}

/**
 * Example Login Action
 * 
 * Users must authorize themselves before granting the app authorization
 * Allows login state to be maintained after authorization
 *  
 */
	public function login () {
	   	$OAuthParams = $this->OAuth->getAuthorizeParams();
        if ($this->request->is('post')) {
            	$this->validateRequest();
			$message = __d('users', 'Ваш емейл или пароль не совпадают');
			if( isset($this->data['Account']['email']) && !Validation::email($this->data['Account']['email']) ){
			      $this->request->data['Account']['login'] = $this->data['Account']['email'];
			      $this->Auth->authenticate['Form'] = array('fields' => array('username' => 'login'));
			      //$this->AutoLogin->username = 'username';  
			      $message = __d('users', 'Ваш логин или пароль не совпадают');
			}
			//Attempted login
			if ($this->Auth->login()) {
				//Write this to session so we can log them out after authenticating
				$this->Session->write('OAuth.logout', true);
				
				//Write the auth params to the session for later
				$this->Session->write('OAuth.params', $OAuthParams);
				
				//Off we go
				$this->redirect(array('action' => 'authorize'));
			} else {
				$this->Session->setFlash($message, 'alert', array(
					'class' => 'alert-error'
					),
					'auth'
				);
				//$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
		}
		$this->set(compact('OAuthParams'));
	}


/**
 * Example Token Endpoint - this is where clients can retrieve an access token
 * 
 * Grant types and parameters:
 * 1) authorization_code - exchange code for token
 *	- code
 *	- client_id
 *	- client_secret
 *
 * 2) refresh_token - exchange refresh_token for token
 *	- refresh_token
 *	- client_id
 *	- client_secret
 * 
 * 3) password - exchange raw details for token
 *	- username
 *	- password
 *	- client_id
 *	- client_secret
 *  
 */
	public function token(){
		$this->autoRender = false;
		try {
			$this->OAuth->grantAccessToken();
		} catch (OAuth2ServerException $e) {
			$e->sendHttpResponse();
		}
		
	}
	
/**
 * Quick and dirty example implementation for protecetd resource
 * 
 * User accesible via $this->OAuth->user();
 * Single fields avaliable via $this->OAuth->user("id"); 
 * 
 */
	public function userinfo() {
		$this->layout = null;
		$user = $this->OAuth->user();
		$this->set('user', $user);
        $this->set('_serialize', array('user'));
    }
    
    
/**
 * Blackhold callback
 * 
 * OAuth requests will fail postValidation, so rather than disabling it completely
 * if the request does fail this check we store it in $this->blackHoled and then
 * when handling our forms we can use $this->validateRequest() to check if there
 * were any errors and handle them with an exception.
 * Requests that fail for reasons other than postValidation are handled here immediately
 * using the best guess for if it was a form or OAuth
 * 
 * @param string $type
 */
	public function blackHole($type) {
		$this->blackHoled = $type;
       	if ($type != 'auth') {
		  
			if (isset($this->request->data['_Token'])) {
				//Probably our form
				$this->validateRequest();
			} else {
				//Probably OAuth
				$e = new OAuth2ServerException(OAuth2::HTTP_BAD_REQUEST, OAuth2::ERROR_INVALID_REQUEST, 'Request Invalid.');
				$e->sendHttpResponse();
			}
		}
	}

/**
 * Check for any Security blackhole errors
 * 
 * @throws BadRequestException 
 */
	private function validateRequest() {
		if ($this->blackHoled) {
			//Has been blackholed before - naughty
			throw new BadRequestException(__d('OAuth', 'The request has been black-holed'));
		}
	}
    
    public function success(){
        $this->layout = false;
    }
    
    public function addC(){
        //$client = $this->OAuth->Client->add('http://localhost');
       //print_r($client);die;
    }
    
    public function googlelogin(){
        CakeLog::debug(__LINE__ . print_r($this->request, true));
    	$result = $data = array();
    	if ( !$this->request->isPost() ) {
    		$result["error"] = 1;//WRONG_REQUEST
    	} else {
    	    CakeLog::debug(__LINE__ . print_r($this->request, true));
    		$data = $this->request->input('json_decode');
    		CakeLog::debug(__LINE__ . print_r($data, true));
    		$gToken = (isset($data->token)&&!empty($data->token))?$data->token:null;
    		$gId = (isset($data->id)&&!empty($data->id))?$data->id:null;
    		$gEmail = (isset($data->email)&&!empty($data->email))?$data->email:null;
    		CakeLog::debug(__LINE__ . print_r($gToken, true));
    		
    		
    		if ($gToken){
    			$response = file_get_contents("https://www.googleapis.com/plus/v1/people/me?alt=json&access_token={$gToken}");
    			CakeLog::debug(__LINE__ . print_r($response, true));
    			$response = json_decode($response);
    			CakeLog::debug(__LINE__ . print_r($response, true));
    			if ($response){
    				//check data
    			    CakeLog::debug(__LINE__ . print_r($response, true));
    			    if (($response->id!='')&&($gId==$response->id)&&($response->emails[0]->value==$gEmail)){
    			        CakeLog::debug(__LINE__ . print_r('Everything ok!', true));
    			        //TODO Login or register user here
    			        //TODO Return good credentials for user
    			        $result["access_token"] = "057f1dcc76ff446ebee977153eafec5d6c047d90";
    			        $result["expires_in"] = 3600;
    			        $result["token_type"] = "bearer";
    			        $result["scope"] = null;
    			        $result["refresh_token"] = "057f1dcc76ff446ebee977153eafec5d6c047d90";
    			    }else{
    			        CakeLog::debug(__LINE__ . print_r($response->id, true).'=?'.$gId.' '.$response->emails[0]->value.'=?'.$gEmail);
    			        $result["error"] = 4;//WRONG_GOOGLE_USER
    			    }
    				

    			}else{
    				$result["error"] = 3;//WRONG_GOOGLE_RESPONSE
    			}
    
    		}
    		else{
    			$result["error"] = 2;//WRONG_INPUT_DATA
    		}
    	}
    	$this->set('result', $result);
    	$this->set('_serialize', 'result');
    
    }

}
