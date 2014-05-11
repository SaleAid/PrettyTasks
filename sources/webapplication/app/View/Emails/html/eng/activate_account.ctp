<h1 style="font-weight: bold; font-size: 18px; line-height: 24px; color: #007ca1">Welcome to PrettyTasks!</h1>
<p>
Hello, <?php echo $full_name; ?>!
</p>
<p>
You have registered at prettytasks.com.
</p>
<p> 
Prettytasks is the best online organizer. <br/>For full access, please confirm your email.
</p>
<p>
Go to this link: <a href="<?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?>"><?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></a>
</p>
<p>
Or copy this link to browser address bar:<br/>  <u><?php echo Router::url(array('controller' => 'accounts', 'action' => 'activate', $activate_token), true); ?></u> 
</p>



