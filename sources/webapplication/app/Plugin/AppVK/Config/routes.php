<?php

Router::connect('/:lang/appvk', array('controller' => 'AppVK', 'action' => 'index', 'plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/appvk/:action/', array('controller' => 'AppVK', 'plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));
//Router::connect('/:lang/appvk/:action/*', array('controller' => 'AppVK', 'plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/appvk/:controller', array('action' => 'index', 'plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));

Router::connect('/:lang/appvk/:controller/:action/', array('plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));
Router::connect('/:lang/appvk/:controller/:action/*', array('plugin' => 'AppVK'), array('lang' => '[a-z]{2}'));

?>
