<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Приглашение на сервис PrettyTasks</h1>
<br/>
Здравствуйте!
<br/>
<br/>
Пользователь <?php echo $user['full_name']; ?> пригласил Вас использовать сервис <a href="<?php echo Configure::read('Site.url'); ?>"><?php echo Configure::read('Site.name'); ?></a>
<br/><br/>
Для регистрации на сайте нажмите на ссылку: 
<a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?></a>
<br/>

