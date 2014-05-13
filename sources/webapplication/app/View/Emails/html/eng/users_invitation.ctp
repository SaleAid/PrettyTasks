<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Invitation to PrettyTasks</h1>
<br/>
Hello!
<br/><br/>
A user <?php echo $user['full_name']; ?> invited you to use the service <a href="<?php echo Configure::read('Site.url'); ?>"><?php echo Configure::read('Site.name'); ?></a>
<br/><br/>
To register at the site follow the link: 
<a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'register', $user['invite_token']), true); ?></a>
<br/>