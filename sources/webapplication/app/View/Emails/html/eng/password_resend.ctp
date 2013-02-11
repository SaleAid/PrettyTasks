Hello, <?php echo $fullname; ?> ( <?php echo $username; ?> ) , have you forgotten you password? <br />

<p>
    If you want to change your password, click the link <br/>
 below (or copy it and paste to the address line of your Internet browser):
</p> 

<p>
    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'password_reset', $password_token), true); ?></a>
</p>

<p>If you don't want to change your password, please ignore this message. Your password will remain the same. </p>

<p>
Sincerely, the Team  <?php echo Configure::read('Site.name'); ?>
</p>
