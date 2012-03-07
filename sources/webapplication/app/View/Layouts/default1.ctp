<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<?php echo $this->Html->docType('html5'); ?>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
    <meta name="google-site-verification" content="eaAqHVdKZqG9JWK-q64SVmGnr8CAJdhWYBzdWI0sHQM" />
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
        
        echo $this->Html->css('loginza');
        
        //echo $this->Html->css('bootstrap.min');
        
        //echo $this->Html->script('jquery-1.7.1.min.js');
        
        //echo $this->Html->script('bootstrap.min.js');

		echo $scripts_for_layout;
	?>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-29304740-1']);
      _gaq.push(['_trackPageview']);
        
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>

<?php //echo $this->Js->writeBuffer(array('cache'=>TRUE));?>

</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
            <div id="login" style="text-align: right;">
                <?php 
                //debug($user);
               
                if(!empty($currentUser)): ?>
                    Welcome <?php echo $this->Html->link($currentUser['Profile']['first_name'].' '.$currentUser['Profile']['last_name']
                            ,array('controller' => 'profiles', 'action' => 'index')); ?>. 
                            <?php echo $this->Html->link('Logout',array('controller' => 'users', 'action' => 'logout')); ?>
                <?php else: ?>
                     <?php echo $this->Html->link('Login',array('controller' => 'users', 'action' => 'login')); ?>
                <?php endif; ?>
            </div>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
            
            <?php echo $this->Session->flash('auth'); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>