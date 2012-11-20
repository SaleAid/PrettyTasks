<?php

Router::connect('/api/v1/tasks/list/*', array('plugin' => 'ApiV1', 'controller' => 'Tasks', 'action' => 'lists'));
Router::connect('/api/v1/:controller/:action/', array('plugin' => 'ApiV1'));
Router::connect('/api/v1/:controller/:action/*', array('plugin' => 'ApiV1'));

?>
