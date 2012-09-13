<p>
Hello!
</p>
<p>
A user <?php echo $user['full_name']; ?> invited you to use the service <a href="<?php echo Configure::read('Site.url'); ?>"><?php echo Configure::read('Site.name'); ?></a>
</p>
<p>
To register at the site follow the link: 
<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'register', $user['invite_token']), true); ?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'register', $user['invite_token']), true); ?></a> .
</p>
<p>
Sincerely, the Team <?php echo Configure::read('Site.name'); ?>
</p>