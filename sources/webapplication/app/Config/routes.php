<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */

App::uses('LangRoute', 'Routing/Route');

//Router::resourceMap(array(
//    array('action' => 'index', 'method' => 'GET', 'id' => false),
//    array('action' => 'view', 'method' => 'GET', 'id' => true),
//    array('action' => 'add', 'method' => 'POST', 'id' => false),
//    array('action' => 'edit', 'method' => 'PUT', 'id' => true),
//    array('action' => 'delete', 'method' => 'DELETE', 'id' => true),
//    array('action' => 'update', 'method' => 'POST', 'id' => true)
//));
//Router::mapResources('notes');
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

Router::connect('/:lang/:device', array(
	'controller' => 'tasks', 'action' => 'index'
), array(
	'device' => '[m]{1}',
    'lang' => '[a-z]{2}'
));
Router::connect('/:lang/:device/:controller', array(
	'action' => 'index'
), array(
	'device' => '[m]{1}',
    'lang' => '[a-z]{2}'
));
Router::connect('/:lang/:device/:controller/:action', array(), array(
	'device' => '[m]{1}',
    'lang' => '[a-z]{2}'
));
Router::connect('/:lang/:device/:controller/:action', array(), array(
	'device' => '[m]{1}',
    'lang' => '[a-z]{2}'
));

CakePlugin::routes();

Router::connect('/:lang/:controller', array('action' => 'index'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/:controller/:action', array(), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/:controller/:action/*', array(), array('lang' => '[a-z]{2}'));




/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */


/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
