<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1"><?php echo __d('mail', Configure::read('Email.user.passwordResend.subject'), Configure::read('Site.name'))?></h1>
<br/>
Здравствуйте, <?php echo $full_name; ?>, вы забыли пароль?
<br/><br/>
Если вы хотите изменить пароль, нажмите на ссылку, расположенную ниже (или скопируйте и вставьте ссылку в адресную строку Интернет-обозревателя):
<br/> 
<br/>
    <a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?></a>
<br/>
<br/>Если вы не хотите менять пароль, пожалуйста, не обращайте внимания на это сообщение. Ваш пароль останется прежним. <br/>