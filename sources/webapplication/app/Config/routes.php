<?php

App::uses('LangRoute', 'Routing/Route');

Router::defaultRouteClass('LangRoute');
Router::parseExtensions('xml', 'json', 'xhtml', 'html');



//задачи
//Router::connect('/'. rawurlencode('задачи') .'', array('controller' => 'tasks', 'action' => 'index', 'lang' => 'ru'));
//Router::connect('/tasks1', array('controller' => 'tasks', 'action' => 'index', 'lang' => 'en'));

Router::connect('/', array('controller' => 'pages', 'action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang', array('controller' => 'pages', 'action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/pages', array('controller' => 'pages', 'action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/pages/index', array('controller' => 'pages', 'action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/pages/*', array('controller' => 'pages', 'action' => 'view'), array('lang' => '[a-z]{2}'));


//login && singup
Router::connect('/:lang/login', array('controller' => 'accounts', 'action' => 'login'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/login/selectmode', array('controller' => 'accounts', 'action' => 'selectMode'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/accounts/confirm-social-links', array('controller' => 'accounts', 'action' => 'confirmSocialLinks'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/accounts/register/success', array('controller' => 'accounts', 'action' => 'register_success'), array('lang' => '[a-z]{2}'));
/**
 * Opauth callback
 */
	Router::connect(
		'/opauth-complete/*', 
		array('controller' => 'accounts', 'action' => 'opauth_complete')
  );

CakePlugin::routes();

Router::connect('/:lang/:controller', array('action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/:controller/:action', array(), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/:controller/:action/*', array(), array('lang' => '[a-z]{2}'));

require CAKE . 'Config' . DS . 'routes.php';
