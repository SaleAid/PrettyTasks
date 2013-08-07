<footer>
<div class="container">
				<div class="row border-bottom">
					
					<div class="span3">
						<h2><?php echo __d('pages', 'Pages'); ?></h2>
						<ul>
							<li><?php echo $this->Html->link(__d('pages', 'Home'), array('controller' => 'pages', 'action' => 'index'));?></li>
							<li><?php echo $this->Html->link(__d('pages', 'Contacts'), array('controller' => 'pages', 'action' => 'contacts'));?></li>
							<?php /*
                            <li><?php echo $this->Html->link(__d('pages', 'Testimonials'), array('controller' => 'pages', 'action' =>  'testimonials'));?></li>
							<li><?php echo $this->Html->link(__d('pages', 'Help'), array('controller' => 'pages', 'action' => 'help'));?></li>
            				*/ ?>
							<li><?php echo $this->Html->link(__d('pages', 'Login'), array('controller' => 'accounts', 'action' => 'login'));?></li>
							<li><?php echo $this->Html->link(__d('pages', 'Register'), array('controller' => 'accounts', 'action' => 'register'));?></li>
						</ul>
					</div> 
					<div class="span3">
						<h2><?php echo __d('pages', 'Misc'); ?></h2>
						<ul>
							<li><?php echo $this->Html->link(__d('pages', 'About'), array('controller' => 'pages', 'action' => 'about'));?></li>
                            <li><?php echo $this->Html->link(__d('pages', 'How it works'), array('controller' => 'pages', 'action' =>  'how-it-works'));?></li>
							<li><?php echo $this->Html->link(__d('pages', 'Privacy Policy'), array('controller' => 'pages', 'action' => 'privacy-policy'));?></li>
							<li><?php echo $this->Html->link(__d('pages', 'Terms and Conditions'), array('controller' => 'pages', 'action' => 'terms-and-conditions'));?></li>
						</ul>
											
					</div> 
                    <div class="span3">
                        <h2><?php echo __d('pages', 'To bloggers'); ?></h2>
						<ul>
                           <li><?php echo $this->Html->link(__d('pages', 'Welcome'), array('controller' => 'pages', 'action' => 'to-bloggers'));?></li>
                           <!--<li><a href="#">Benefits</a></li>-->
    					</ul>
                         <h2><?php echo __d('pages', 'Follow us');?></h2>
            			<ul>
                           <li><a href="http://www.twitter.com/prettytasks" target="_blank"><?php echo __d('pages', 'On twitter');?></a></li>
                           <li><a href="http://www.facebook.com/prettytasks" target="_blank"><?php echo __d('pages', 'On facebook');?></a></li>
                        </ul>	
						
					</div> 
					
					<div class="span3">
						<h2><?php echo __d('pages', 'Social Media'); ?></h2>
						<?php echo $this->element('share'); ?> 
					</div> 
					
				</div> 
				
				<div class="row copyright">
					<div class="span8 right">
						&copy; 2012-<?php echo date('Y'); ?> Pretty Tasks - <a href="<?php echo Configure::read('Site.url')?>"><?php echo Configure::read('Site.url')?></a> 
					</div> 
				</div>
			</div> 
</footer>
