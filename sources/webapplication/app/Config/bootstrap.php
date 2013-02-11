<?php

Configure::write('Dispatcher.filters', array(
        'AssetDispatcher',
                'CacheDispatcher'
                ));

Cache::config('default', array(
    'engine' => 'File'
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

config('appconfig');

CakePlugin::load('Recaptcha');

CakePlugin::load(array(
    'OAuth' => array('routes' => true)
));
 
CakePlugin::load(array(
    'ApiV1' => array('routes' => true)
));

CakePlugin::load(array(
    'AppVK' => array('routes' => true)
));

CakePlugin::load('Tags');
  