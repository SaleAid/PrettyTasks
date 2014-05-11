<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Добро пожаловать в PrettyTasks!</h1>
<p>
Здравствуйте, <?php echo $full_name; ?>!
</p>
<p>
Вы зарегистрировались на сервисе prettytasks.com.
</p>
<p> 
Prettytasks - самый удобный онлайн органайзер. <br/>Для полного доступа ко всем функциям необходимо подтверждение Вашего емейла.
</p>
<p>
Перейдите по этой ссылке: <a href="<?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></a>
</p>
<p>
Если ссылка не работает, скопируйте ее в строку браузера:<br/>  <u><?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></u> 
</p>

