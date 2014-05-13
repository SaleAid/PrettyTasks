<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Добро пожаловать в PrettyTasks!</h1>
<br/>
Здравствуйте, <?php echo $full_name; ?>!
<br/>
<br/>
Вы зарегистрировались на сервисе prettytasks.com.
<br/>
<br/>
Prettytasks - самый удобный онлайн органайзер. <br/>Для полного доступа ко всем функциям необходимо подтверждение Вашего емейла.
<br/>
<br/>
Перейдите по этой ссылке: <a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></a>
<br/>
<br/>
Если ссылка не работает, скопируйте ее в строку браузера:<br/>  <u><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></u> 
<br/>

