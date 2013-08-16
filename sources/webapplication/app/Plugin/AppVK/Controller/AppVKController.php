<?php
App::uses('HttpSocket', 'Network/Http');
App::uses('AppVKAppController', 'AppVK.Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class AppVKController extends AppVKAppController {
	
	public $uses = array('Account');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    
    public function index(){
        
        //pr($this->request->query);die;
        
        $uids = $this->request->query['user_id'];
        $viewer_id = $this->request->query['viewer_id'];
        $access_token = $this->request->query['access_token'];
        $api_url = $this->request->query['api_url'];
        $api_id = $this->request->query['api_id'];
        $auth_key = $this->request->query['auth_key'];
        $v = '3.0';
        $format = 'JSON';
        $sid = $this->request->query['sid'];
        $fields = 'uid,first_name,last_name,nickname';
        $method = 'getProfiles';
        $api_secret = 'n0EuDj5f5gd3j1ms6aYx';
        
        $params['uids'] = $viewer_id;
        $params['api_id'] = $api_id;
		$params['v'] = $v;
		$params['method'] = $method;
		$params['timestamp'] = time();
		$params['format'] = 'json';
		$params['random'] = rand(0,10000);
		ksort($params);
		$sig = '';
		foreach($params as $k=>$v) {
			$sig .= $k.'='.$v;
		}
		$sig .= $api_secret;
		$auth_key_test = md5($api_id . '_' . $viewer_id . '_' . $api_secret);
        
        
        if($auth_key_test != $auth_key) {
            echo 'Error 1';die;
        }
        $params['sig'] = md5($sig);
        $HttpSocket = new HttpSocket();
        $results = $HttpSocket->get($api_url, $params);
        $results = json_decode($results->body);
        //pr($results); die;
        $results = $results->response[0];
        
        if($results->uid != $viewer_id) {
            echo 'Error';die;
        }
        
        $result = $this->Account->findByUidAndProvider($results->uid, 'vkontakte');
        if ( empty($result) ){
            $this->Session->setFlash(__d('users', 'У вас еще нет аккаунта'), 'alert', array(
                        'class' => 'alert-error'
                    ));
            return;
        }
        $this->Auth->login($result['User']);
        if($this->Auth->user('language')){
            $this->Auth->loginRedirect['lang'] = $this->L10n->map($this->Auth->user('language'));
        }
        $this->redirect(array('controller' => 'Tasks', 'action' => 'index'));
    }


}
