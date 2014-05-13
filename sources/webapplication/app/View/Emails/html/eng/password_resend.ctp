<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1"><?php echo __d('mail', Configure::read('Email.user.passwordResend.subject'), Configure::read('Site.name'))?></h1>
<br/>
Hello, <?php echo $full_name; ?> , have you forgotten you password? <br />
<br/><br/>
    If you want to change your password, click the link <br/>
 below (or copy and paste it to the address bar of your browser):
<br/><br/>
    <a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?></a>
<br/>
<br/>
If you don't want to change your password, please ignore this message. Your password will remain the same. 
<br/>


