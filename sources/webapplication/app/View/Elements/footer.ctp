<footer>
<div class="container">
				<div class="row border-bottom">
					
					<div class="span3">
						<h2>Pages</h2>
						<ul>
							<li><?php echo $this->Html->link(__('Home'), '/');?></li>
							<li><?php echo $this->Html->link(__('About'), array('controller' => 'Pages', 'action' => 'view', 'about'));?></li>
							<li><?php echo $this->Html->link(__('How it works'), array('controller' => 'Pages', 'action' => 'view', 'how-it-works'));?></li>
							<li><?php echo $this->Html->link(__('Testimonials'), array('controller' => 'Pages', 'action' => 'view', 'testimonials'));?></li>
							<li><?php echo $this->Html->link(__('Help'), array('controller' => 'Pages', 'action' => 'view', 'help'));?></li>
							<li><?php echo $this->Html->link(__('Login'), array('controller' => 'Users', 'action' => 'login'));?></li>
							<li><?php echo $this->Html->link(__('Register'), array('controller' => 'Users', 'action' => 'login'));?></li>
						</ul>
					</div> 

					<div class="span3">
						<h2>Social Media</h2>
						<ul>
							<li><a href="http://www.facebook.com/">Facebook</a></li>
							<li><a href="http://twitter.com/">Twitter</a></li>
							<li><a href="https://plus.google.com">Google Plus</a></li>
						</ul>

						<h2>Misc</h2>
						<ul>
							<li><?php echo $this->Html->link(__('Privacy Policy'), array('controller' => 'Pages', 'action' => 'view', 'privacy-policy'));?></li>
							<li><?php echo $this->Html->link(__('Terms and Conditions'), array('controller' => 'Pages', 'action' => 'view', 'terms-and-conditions'));?></li>
						</ul>
					</div> 

					<div class="span3">
						<h2>Bloggers about us</h2>
						<ul>
                           <li><a href="#">On habrahabr</a></li>
                           <li><a href="#">On techcrunch</a></li>
                           <li><a href="#">On ReadWrite Web</a></li>
                           <li><a href="#">On Personal blogs</a></li>
    					</ul>
					</div> 
					
					<div class="span3">
						<h2>Follow us</h2>
						<ul>
                           <li><a href="#">On twitter</a></li>
                           <li><a href="#">On facebook</a></li>
                           <li><a href="#">On google +</a></li>
                           <li><a href="#">On livejournal</a></li>
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
