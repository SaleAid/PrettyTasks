<?php
/**
 * Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 *
 * @copyright Copyright 2012-2014, PrettyTasks (http://prettytasks.com)
 * @author Vladyslav Kruglyk <krugvs@gmail.com>
 * @author Alexandr Frankovskiy <afrankovskiy@gmail.com>
 */
App::uses ( 'AppController', 'Controller' );
App::uses ( 'Validation', 'Utility' );
/**
 * Users Controller
 *
 * @property Task $Task
 * @property User $User
 * @property Account $Account
 */
class UsersController extends AppController {
	public $name = 'Users';
	public $uses = array (
			'User',
			'Task',
			'Account' 
	);
	public $components = array (
			'RequestHandler',
			'Captcha' 
	);
	public $layout = 'profile';
	public function beforeFilter() {
		$this->Auth->allow ( 'check' );
		parent::beforeFilter ();
		if ($this->Auth->loggedIn () and in_array ( $this->params ['action'], array (
				'login',
				'register',
				'activate',
				'reactivate' 
		) )) {
			$this->redirect ( array (
					'controller' => 'tasks',
					'action' => 'index',
					'lang' => $this->params ['lang'] 
			) );
		}
	}
	public function isAuthorized($user) {
		return true;
	}
	public function checkLogin() {
		$this->autoRender = false;
		return $this->Auth->loggedIn ();
	}
	public function check() {
		$result ['status'] = 0;
		
		if ($this->Auth->loggedIn ()) {
			$date = $this->request->query ( 'date' );
			$result ['status'] = 1;
			// $result['data']['full_name'] = $this->Auth->user('full_name');
			$result ['data'] ['token'] = $this->generateCsrfToken ();
			$result ['data'] ['timezone'] = $this->Auth->user ( 'timezone' );
			$result ['data'] ['language_url'] = $this->Auth->user ( 'language' );
			if (! empty ( $date )) {
				$result ['data'] ['count'] = $this->Task->find ( 'count', array (
						'conditions' => array (
								'Task.done' => 0,
								'Task.deleted' => 0,
								'Task.date' => $date,
								'Task.user_id' => $this->Auth->user ( 'id' ) 
						) 
				) );
			}
		}
		$this->set ( 'result', $result );
		$this->set ( '_serialize', 'result' );
	}
	public function index() {
		$this->redirect ( array (
				'action' => 'profile' 
		) );
	}
	public function profile() {
		$this->User->id = $this->Auth->user ( 'id' );
		if ($this->request->is ( 'post' ) || $this->request->is ( 'put' )) {
			$expectedData = array (
					'timezone',
					'language' 
			)
			;
			if (! $this->_isSetRequestData ( $expectedData, 'User' )) {
				$this->Session->setFlash ( __d ( 'users', 'Ошибка при передаче данных' ), 'alert', array (
						'class' => 'alert-error' 
				) );
			} else {
				
				$data ['User'] ['timezone'] = $this->request->data ['User'] ['timezone'];
				$data ['User'] ['language'] = $this->request->data ['User'] ['language'];
				if ($this->User->save ( $data )) {
					$this->_refreshAuth ();
					$this->Session->setFlash ( __d ( 'users', 'Профиль был сохранен' ), 'alert', array (
							'class' => 'alert-success' 
					) );
					$params = $this->request->params;
					if (! empty ( $data ['User'] ['language'] )) {
						$params ['lang'] = $this->L10n->map ( $data ['User'] ['language'] );
						$this->redirect ( $params );
					}
					$params ['lang'] = false;
					$this->redirect ( $params );
				} else {
					$this->Session->setFlash ( __d ( 'users', 'Профиль не может быть сохранен. Пожалуйста, попробуйте еще раз' ), 'alert', array (
							'class' => 'alert-error' 
					) );
				}
			}
		} else {
			$this->request->data = $this->User->read ();
		}
		
		foreach ( Configure::read ( 'Config.lang.available' ) as $lang ) {
			$listLang [$lang ['lang']] = $lang ['name'];
		}
		$this->set ( 'listLang', $listLang );
		
		$options = Cache::read ( 'TimeZoneList' );
		if (! $options) {
			App::uses ( 'CakeTime', 'Utility' );
			// pr(CakeTime::listTimezones());
			// TODO: Rewrite it
			$list = DateTimeZone::listAbbreviations ();
			$idents = DateTimeZone::listIdentifiers ();
			$data = $offset = $added = array ();
			foreach ( $list as $abbr => $info ) {
				foreach ( $info as $zone ) {
					if (! empty ( $zone ['timezone_id'] ) and ! in_array ( $zone ['timezone_id'], $added ) and in_array ( $zone ['timezone_id'], $idents )) {
						$z = new DateTimeZone ( $zone ['timezone_id'] );
						$c = new DateTime ( null, $z );
						$zone ['time'] = $c->format ( 'H:i ' );
						$data [] = $zone;
						$offset [] = $z->getOffset ( $c );
						$added [] = $zone ['timezone_id'];
					}
				}
			}
			// debug($offset);
			// debug($data);
			array_multisort ( $offset, SORT_ASC, $data );
			$options = array ();
			foreach ( $data as $key => $row ) {
				$options [$row ['timezone_id']] = $row ['time'] . ' - ' . formatOffset ( $row ['offset'] ) . ' ' . $row ['timezone_id'];
			}
			// debug($options);
			Cache::write ( 'TimeZoneList', $options );
		}
		$this->set ( 'list', $options );
	}
	public function accounts() {
		$this->paginate = array (
				'conditions' => array (
						'User.id' => $this->Auth->user ( 'id' ) 
				)
				// 'Account.active' => 1
				,
				'contain' => 'User' 
		);
		$accounts = $this->paginate ( 'Account' );
		$this->set ( 'accounts', $accounts );
	}
	public function subscriptions() {
		
		$options_subscribtions_news = [
				0 => __d('users', 'Не получать'),
				1 => __d('users', 'Получать'),
		];
		$this->set ('options_subscribtions_news', $options_subscribtions_news);
		$options_subscribe_daily_digest = [
				0 => __d('users', 'Не получать'),
				1 => __d('users', 'Получать, если есть изменения'),
				2 => __d('users', 'Получать всегда'),
		];
		$this->set ('options_subscribe_daily_digest', $options_subscribe_daily_digest);
		$options_subscribe_weekly_digest = [
				0 => __d('users', 'Не получать'),
				1 => __d('users', 'Получать'),
		];
		$this->set ('options_subscribe_weekly_digest', $options_subscribe_weekly_digest);
		
	}
	public function changeLanguage() {
		$result = $this->_prepareResponse ();
		if ($this->_isSetRequestData ( 'lang' ) && $this->User->changeLanguage ( $this->Auth->user ( 'id' ), $this->request->data ['lang'] )) {
			$this->_refreshAuth ();
			$result ['success'] = true;
		}
		$this->set ( 'result', $result );
		$this->set ( '_serialize', array (
				'result' 
		) );
	}
	protected function _refreshAuth() {
		$this->User->contain ();
		$user = $this->User->read ( false, $this->Auth->user ( 'id' ) );
		$user = $user ['User'];
		// pr($this->Auth->user());die;
		$user ['account_id'] = $this->Auth->user ( 'account_id' );
		$user ['provider'] = $this->Auth->user ( 'provider' );
		$user ['full_name'] = $this->Auth->user ( 'full_name' );
		$this->Session->write ( 'Auth.User', $user );
		// $this->Auth->login($user);
	}
}

// TODO Place this function in other file
// now you can use $options;
function formatOffset($offset) {
	$hours = $offset / 3600;
	$remainder = $offset % 3600;
	$sign = $hours > 0 ? '+' : '-';
	$hour = ( int ) abs ( $hours );
	$minutes = ( int ) abs ( $remainder / 60 );
	if ($hour == 0 and $minutes == 0) {
		$sign = ' ';
	}
	return 'GMT' . $sign . str_pad ( $hour, 2, '0', STR_PAD_LEFT ) . ':' . str_pad ( $minutes, 2, '0' );
}