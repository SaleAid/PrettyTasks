<?php

Configure::write('Dispatcher.filters', array(
        'AssetDispatcher',
        'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'FileLog', 
    'types' => array(
        'notice', 
        'info', 
        'debug'
    ), 
    'file' => 'debug'
));
CakeLog::config('error', array(
    'engine' => 'FileLog', 
    'types' => array(
        'warning', 
        'error', 
        'critical', 
        'alert', 
        'emergency'
    ), 
    'file' => 'error'
));

config('caches');
config('appconfig');
config('opauth_config');
config('user_config');

//CakePlugin::load('Recaptcha');

CakePlugin::load(array(
    'OAuth' => array('routes' => true)
));
 
CakePlugin::load(array(
    'ApiV1' => array('routes' => true)
));

CakePlugin::load(
    'Opauth', array('routes' => true, 'bootstrap' => true
));

//CakePlugin::load(array(
//    'AppVK' => array('routes' => true)
//));

// maintenance server 

if (Configure::read('App.maintenanceMode')){
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    header('Retry-After: 60');
    echo file_get_contents(WWW_ROOT . 'maintenence.html');
    exit();
}
  
