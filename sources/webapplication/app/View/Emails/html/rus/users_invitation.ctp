<p>
Здравствуйте!
</p>
<p>
Пользователь <?php echo $user['full_name']; ?> пригласил Вас использовать сервис <a href="<?php echo Configure::read('Site.url'); ?>"><?php echo Configure::read('Site.name'); ?></a>
</p>
<p>
Для регистрации на сайте нажмите на ссылку: 
<a href="<?php echo Router::url(array('controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?>"><?php echo Router::url(array('controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?></a>
</p>
<p>
С уважением, команда <?php echo Configure::read('Site.name'); ?>
</p>