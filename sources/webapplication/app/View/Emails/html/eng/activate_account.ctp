Hello, <?php echo $full_name; ?>! <br />

Your activation code: 

<p>
    <a href="<?php echo Router::url(array('controller' => strtolower($controllerName), 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('controller' => strtolower($controllerName), 'action' => 'activate', $activate_token), true); ?></a>
</p>

<p>
Sincerely, the Team  <?php echo Configure::read('Site.name'); ?>
</p>
