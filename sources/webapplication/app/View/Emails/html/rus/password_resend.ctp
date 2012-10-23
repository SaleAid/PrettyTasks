Здравствуйте, <?php echo $fullname; ?> ( <?php echo $username; ?> ) , вы забыли пароль? <br />

<p>
    Если вы хотите изменить пароль, нажмите на ссылку, <br/>
    расположенную ниже (или скопируйте и вставьте ссылку в адресную строку Интернет-обозревателя):
</p> 

<p>
    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'password_reset', $password_token), true); ?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'password_reset', $password_token), true); ?></a>
</p>

<p>Если вы не хотите менять пароль, пожалуйста, не обращайте внимания на это сообщение. Ваш пароль останется прежним. </p>

<p>
С уважением, команда <?php echo Configure::read('Site.name'); ?>
</p>
