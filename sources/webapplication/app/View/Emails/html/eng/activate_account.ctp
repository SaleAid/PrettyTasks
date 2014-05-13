<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Welcome to PrettyTasks!</h1>
<br/>
Hello, <?php echo $full_name; ?>!
<br/><br/>
You have registered at prettytasks.com.
<br/><br/>
Prettytasks is the best online organizer. <br/>For full access, please confirm your email.
<br/><br/>
Go to this link: <a href="<?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></a>
<br/><br/>
Or copy this link and paste it into a browser address bar:<br/>  <u><?php echo Router::url(array('plugin' => null, 'controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></u> 
<br/>



