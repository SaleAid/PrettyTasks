<?php
   echo $this->Html->css('start.'.Configure::read('App.version'), null, array('block' => 'toHead'));
   echo $this->Html->script('main.'.Configure::read('App.version'), array('block' => 'toFooter'));
 ?>
<div class="start">
  <?php echo $this->Html->image('comics_eng.'. Configure::read('App.version') .'.jpg', array('width' => 970, 'height' =>355)); ?>
</div>
<div class="row">
	<div class="span4 box left">
		<div class="box_header">
            <h1 align="center"><?php echo __('Get ready');?></h1> 
        </div>
		<div class="box_container">
            <p>
                Hi! you're likely a person, striving for the best. Sometimes it's difficult to make yourself do something, sometimes you forget something. <strong>Prepare yourself!</strong> This service is what you need.
		   </p>
        </div>
	</div>
	<div class="span4 box center">
		<div class="box_header">
		   <h1 align="center"><?php echo __('Aim');?></h1>
        </div>   
        <div class="box_container">
            <p>
                The most important thing is to have a goal. Well-set goal is a half the work. We will help you to set goals and aims. Forget nothing, feel the pulse from any place of our planet.
			</p>
        </div>
	</div>
	<div class="span4 box right">
		<div class="box_header">
		   <h1 align="center"><?php echo __('Fire!');?></h1>
        </div>
        <div class="box_container">  
            <p> It's time to act! </p>
            <p>Get rid of any fears, you can do everything!</p>
        </div>
	</div>
</div>
<?php echo $this->Html->link('Try it out now. It is totally free!',array('controller' => 'accounts', 'action' => 'register'),array('class'=> 'btn btn-large btn-block btn btn-success fire')); ?>
            