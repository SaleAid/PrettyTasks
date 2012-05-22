Здравствуйте, <?php echo $full_name; ?>! <br />

Ваш код активации на сайте: 

<p>
    <a href="<?php echo Router::url(array('controller' => strtolower($controllerName), 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('controller' => strtolower($controllerName), 'action' => 'activate', $activate_token), true); ?></a> .
</p>

<p>
С уважением, команда <?php echo Configure::read('Site.name'); ?>
</p>
