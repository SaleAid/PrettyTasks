<div data-role="page" id="today">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a class="ui-btn-active ui-state-persist" href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a  href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a  href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" placeholder="Type to add new task for today" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>"/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays']['Today']) && !empty($result['data']['arrTaskOnDays']['Today'])):
			foreach($result['data']['arrTaskOnDays']['Today'] as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>

<div data-role="page" id="tomorrow">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a class="ui-btn-active ui-state-persist"  href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" placeholder="Type to add new task for tomorrow" date="<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>"/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays']['Tomorrow']) && !empty($result['data']['arrTaskOnDays']['Tomorrow'])):
			foreach($result['data']['arrTaskOnDays']['Tomorrow'] as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>

<div data-role="page" id="overdue">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a class="ui-btn-active ui-state-persist" href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<h2>There are your overdue tasks</h2>
		<fieldset data-role="controlgroup" id="incomplete-overdue" >
		<?php 
			if(isset($result['data']['arrAllExpired']) && !empty($result['data']['arrAllExpired'])):
			foreach($result['data']['arrAllExpired'] as $item):

		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>


<div data-role="page" id="overview">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a class="ui-btn-active ui-state-persist" href="#overview">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<input type="text" class="span3" name="newTask" id="newTask-future" placeholder="Type to add new task for future" date=""/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays']) && !empty($result['data']['arrTaskOnDays'])):
			foreach($result['data']['arrTaskOnDays'] as $datelabel => $day):
			if(isset($day) && !empty($day)):
		?>
		<h3><?php echo $datelabel; ?></h3>
		<fieldset data-role="controlgroup" id="incomplete-overview-<?php echo $datelabel; ?>" >
		<?
			foreach($day as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>"><?php echo $item['Task']['title']; ?></label>
		<?php
		endforeach;
		?>
		</fieldset>
		<?php
		endif;
		endforeach;
		endif;
		?>
	</div>
	
	<div data-role="footer">

	</div><!-- /footer -->

</div>






