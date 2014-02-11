<?php

Router::connect('/api/v2/sync/status/*', array('plugin' => 'ApiV2', 'controller' => 'Syncs', 'action' => 'status'));
Router::connect('/api/v2/sync/partition/*', array('plugin' => 'ApiV2', 'controller' => 'Syncs', 'action' => 'getChanges'));
Router::connect('/api/v2/sync/update/*', array('plugin' => 'ApiV2', 'controller' => 'Syncs', 'action' => 'update'));

//Router::connect('/api/v2/:controller/:action/', array('plugin' => 'ApiV2'));
//Router::connect('/api/v2/:controller/:action/*', array('plugin' => 'ApiV2'));

?>
