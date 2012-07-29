<footer>
<div class="container">
				<div class="row border-bottom">
					
					<div class="span3">
						<h2><?php echo __('Pages');?></h2>
						<ul>
							<li><?php echo $this->Html->link(__('Home'), array('controller' => 'pages', 'action' => 'index'));?></li>
							<li><?php echo $this->Html->link(__('About'), array('controller' => 'pages', 'action' => 'about'));?></li>
							<li><?php echo $this->Html->link(__('How it works'), array('controller' => 'pages', 'action' =>  'how-it-works'));?></li>
							<?php /*
							<li><?php echo $this->Html->link(__('Help'), array('controller' => 'pages', 'action' => 'help'));?></li>
							*/ ?>
							<li><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'));?></li>
							<li><?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'register'));?></li>
						</ul>
					</div> 

					<div class="span3">
						<h2><?php echo __('Misc');?></h2>
						<ul>
						    <?php /*
							<li><?php echo $this->Html->link(__('Privacy Policy'), array('controller' => 'pages', 'action' => 'privacy-policy'));?></li>
							*/?>
							<li><?php echo $this->Html->link(__('Terms and Conditions'), array('controller' => 'pages', 'action' => 'terms-and-conditions'));?></li>
						</ul>
					</div>
					<div class="span3">	
						<h2><?php echo __('To bloggers');?></h2>
						<ul>
                           <li><?php echo $this->Html->link(__('Welcome'), array('controller' => 'pages', 'action' => 'to-bloggers'));?></li>
    					</ul>						
					</div> 
					<?php /*
					<div class="span3">
						<h2><?php echo __('Social Media');?></h2>
						<ul>
							<li><a href="http://www.facebook.com/prettytasks">Facebook</a></li>
							<li><a href="http://twitter.com/prettytasks">Twitter</a></li>
							<li><a href="https://plus.google.com">Google Plus</a></li>
							<li><a href="#"><?php echo __('Bloggers about us');?></a></li>
						</ul>
					</div> 
					*/?>
					
					<div class="span3">
						<h2><?php echo __('Follow us');?></h2>
						<ul>
                           <li><a href="http://twitter.com/prettytasks" target="_blank"><?php echo __('On twitter');?></a></li>
                           <li><a href="http://www.facebook.com/prettytasks" target="_blank"><?php echo __('On facebook');?></a></li>
                           <?php /*
                           <li><a href="#"><?php echo __('On Google+');?></a></li>
                           */?>
    					</ul>
					</div> 
					
				</div> 
				
				<div class="row copyright">
					<div class="span8 right">
						&copy; 2012 Pretty Tasks - <a href="<?php echo Configure::read('Site.url')?>"><?php echo Configure::read('Site.url')?></a> 
					</div> 
				</div>
			</div> 
</footer>
