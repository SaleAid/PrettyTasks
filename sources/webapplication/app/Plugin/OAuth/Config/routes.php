<?php

Router::connect('/oauth/:action/*', array('controller' => 'OAuth', 'plugin' => 'OAuth'));

?>
