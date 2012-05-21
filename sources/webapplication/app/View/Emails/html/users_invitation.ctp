<p>
Здравствуйте!
</p>
<p>
Пользователь <?php echo $user['full_name']; ?> пригласил Вас на сервис <a href="<?php echo Configure::read('Site.url'); ?>"><?php echo Configure::read('Site.name'); ?></a>
</p>
<p>
Для регистрации на сайте нажмите на ссылку: 

<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'register', $user['invite_token']), true); ?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'register', $user['invite_token']), true); ?></a>

С уважением, команда <?php echo Configure::read('Site.name'); ?>

