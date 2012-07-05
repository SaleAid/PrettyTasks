<footer>
<div class="container">
				<div class="row border-bottom">
					
					<div class="span3">
						<h2>Pages</h2>
						<ul>
							<li><?php echo $this->Html->link(__('Home'), array('controller' => 'pages', 'action' => 'index'));?></li>
							<li><?php echo $this->Html->link(__('About'), array('controller' => 'pages', 'action' => 'about'));?></li>
							<li><?php echo $this->Html->link(__('How it works'), array('controller' => 'pages', 'action' =>  'how-it-works'));?></li>
							<li><?php echo $this->Html->link(__('Testimonials'), array('controller' => 'pages', 'action' =>  'testimonials'));?></li>
							<li><?php echo $this->Html->link(__('Help'), array('controller' => 'pages', 'action' => 'help'));?></li>
							<li><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'));?></li>
							<li><?php echo $this->Html->link(__('Register'), array('controller' => 'users', 'action' => 'login'));?></li>
						</ul>
					</div> 

					<div class="span3">
						<h2>Misc</h2>
						<ul>
							<li><?php echo $this->Html->link(__('Privacy Policy'), array('controller' => 'pages', 'action' => 'privacy-policy'));?></li>
							<li><?php echo $this->Html->link(__('Terms and Conditions'), array('controller' => 'pages', 'action' => 'terms-and-conditions'));?></li>
						</ul>
						
						<h2>To bloggers</h2>
						<ul>
                           <li><?php echo $this->Html->link(__('Welcome'), array('controller' => 'pages', 'action' => 'to-bloggers'));?></li>
                           <li><a href="#">Benefits</a></li>
    					</ul>						
					</div> 

					<div class="span3">
						<h2>Social Media</h2>
						<ul>
							<li><a href="http://www.facebook.com/">Facebook</a></li>
							<li><a href="http://twitter.com/">Twitter</a></li>
							<li><a href="https://plus.google.com">Google Plus</a></li>
							<li><a href="#">Bloggers about us</a></li>
						</ul>
					</div> 
					
					<div class="span3">
						<h2>Follow us</h2>
						<ul>
                           <li><a href="#">On twitter</a></li>
                           <li><a href="#">On facebook</a></li>
                           <li><a href="#">On google +</a></li>
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
