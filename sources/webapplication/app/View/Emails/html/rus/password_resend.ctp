<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1"><?php echo __d('mail', Configure::read('Email.user.passwordResend.subject'), Configure::read('Site.name'))?></h1>
<p>
Здравствуйте, <?php echo $full_name; ?>, вы забыли пароль?
</p>
<p>
    Если вы хотите изменить пароль, нажмите на ссылку, расположенную ниже (или скопируйте и вставьте ссылку в адресную строку Интернет-обозревателя):
</p> 
<p>
    <a href="<?php echo Router::url(array('controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('controller' => 'accounts', 'action' => 'password_reset', $password_token), true); ?></a>
</p>
<p>Если вы не хотите менять пароль, пожалуйста, не обращайте внимания на это сообщение. Ваш пароль останется прежним. </p>