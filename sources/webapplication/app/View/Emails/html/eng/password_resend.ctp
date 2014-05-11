<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1"><?php echo __d('mail', Configure::read('Email.user.passwordResend.subject'), Configure::read('Site.name'))?></h1>
<p>
Hello, <?php echo $full_name; ?> , have you forgotten you password? <br />
</p>
<p>
    If you want to change your password, click the link <br/>
 below (or copy it and paste to the address line of your Internet browser):
</p> 

<p>
    <a href="<?php echo Router::url(array('controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?></a>
</p>

<p>If you don't want to change your password, please ignore this message. Your password will remain the same. </p>


