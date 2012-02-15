<?php

App::uses('HttpSocket', 'Network/Http');

class ExampleController extends AppController {
    
    public $components = array('OAuthConsumer');

    public function index() {
        $requestToken = $this->OAuthConsumer->getRequestToken('Twitter', 'https://api.twitter.com/oauth/request_token', 'http://' . $_SERVER['HTTP_HOST'] . '/example/tw_callback');

        if ($requestToken) {
            $this->Session->write('twitter_request_token', $requestToken);
            $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        } else {
            $this->Session->setFlash(__('An unknown error'));
			$this->redirect(array('controller'=>'users','action'=>'login'));
        }
    }

    public function tw_callback() {
        if(isset($this->request->query['denied'])){
            $this->redirect(array('controller'=>'users','action'=>'login'));
        }
        $requestToken = $this->Session->read('twitter_request_token');
        $accessToken = $this->OAuthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);
        if ($accessToken) {
              $test = $this->OAuthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'https://api.twitter.com/1/account/verify_credentials.json');
              debug(json_decode ($test));die;
              
        }
    }
    public function vk(){
        $client_id = '2805375';
        $redirect_uri = 'http://learning-2012.org.ua/example/vk_callback';
        $url = 'http://oauth.vkontakte.ru/authorize?client_id='.$client_id.'&scope=&redirect_uri='.$redirect_uri.'&response_type=code&display=page';
        $this->redirect($url);
        
    }
    public function vk_callback(){
        
        $fielsd ='uid, first_name, last_name, nickname, screen_name, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, has_mobile, rate, contacts, education, online, counters';
        $url = 'https://oauth.vkontakte.ru/access_token?client_id=2805375&client_secret=w5Vis0PPZnd4bjfRMlfd&code='.$this->request->query['code'];
        $socket = new HttpSocket();
        $result = json_decode($socket->get($url));
        debug($result);
        //https://api.vkontakte.ru/method/getProfiles?uid=66748&access_token=533bacf01e11f55b536a565b57531ac114461ae8736d6506a3
        if(isset($result->error)){
            $this->Session->setFlash(__($result->error_description));
			$this->redirect(array('controller'=>'users','action'=>'login'));
        }
        $url1 = 'https://api.vkontakte.ru/method/getProfiles?uid='.$result->user_id.'&fields='.$fielsd.'&access_token='.$result->access_token;
        $return1 = json_decode($socket->post($url1));
        debug($return1); die;
    }
   
} 