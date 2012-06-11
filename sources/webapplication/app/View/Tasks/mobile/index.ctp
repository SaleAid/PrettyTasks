<div data-role="page" id="today">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a class="ui-btn-active ui-state-persist" href="#today" data-transition="flow">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a  href="#tomorrow" data-transition="flow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a  href="#overdue" data-transition="flow">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview" data-transition="flow">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', time(), true); ?>" placeholder="Type to add new task for today" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>"/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays'][$this->Time->format('Y-m-d', time(), true)]) && !empty($result['data']['arrTaskOnDays'][ $this->Time->format('Y-m-d', time(), true)])):
			foreach($result['data']['arrTaskOnDays'][ $this->Time->format('Y-m-d', time(), true)] as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>">
		<?php echo $item['Task']['title']; ?>
		<?php if($item['Task']['time']):?><span class="time" style="float: right;"><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?></span>&nbsp;<?php endif; ?>
		</label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer">
		<a href="/Tasks" rel="external">Go to full version</a>
		<a href="#about">About</a>
	</div><!-- /footer -->

</div>

<div data-role="page" id="tomorrow">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today" data-transition="flow">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a class="ui-btn-active ui-state-persist"  href="#tomorrow" data-transition="flow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue" data-transition="flow">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview" data-transition="flow">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<fieldset data-role="controlgroup" id="incomplete-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" >
		<input type="text" class="span3" name="newTask" id="newTask-<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" placeholder="Type to add new task for tomorrow" date="<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>"/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays'][$this->Time->format('Y-m-d', '+1 days', true)]) && !empty($result['data']['arrTaskOnDays'][$this->Time->format('Y-m-d', '+1 days', true)])):
			foreach($result['data']['arrTaskOnDays'][$this->Time->format('Y-m-d', '+1 days', true)] as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>">
		<?php echo $item['Task']['title']; ?>
		<?php if($item['Task']['time']):?><span class="time" style="float: right;"><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?></span>&nbsp;<?php endif; ?>
		</label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer" data-position="fixed">
		<a href="/Tasks" rel="external">Go to full version</a>
		<a href="#about">About</a>
	</div><!-- /footer -->

</div>

<div data-role="page" id="overdue">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today" data-transition="flow">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow" data-transition="flow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a class="ui-btn-active ui-state-persist" href="#overdue" data-transition="flow">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a href="#overview" data-transition="flow">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<h3>There are your overdue tasks</h3>
		<fieldset data-role="controlgroup" id="incomplete-overdue" >
		<?php 
			if(isset($result['data']['arrAllExpired']) && !empty($result['data']['arrAllExpired'])):
			foreach($result['data']['arrAllExpired'] as $item):

		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>">
		<?php echo $item['Task']['title']; ?>
		<?php if($item['Task']['time']):?><span class="time" style="float: right;"><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?></span>&nbsp;<?php endif; ?>
		</label>
		<?php
		endforeach;
		endif;
		?>
		</fieldset>
	</div>
	
	<div data-role="footer" data-position="fixed">
		<a href="/Tasks" rel="external">Go to full version</a>
		<a href="#about">About</a>
	</div><!-- /footer -->

</div>


<div data-role="page" id="overview">
	
	<div data-role="header" id="primary" data-id="primary">
		<div data-role="navbar">
			<ul>
							<li id="nav-index" class="icon-index"><a href="#today" data-transition="flow">Today</a></li>
							<li id="nav-speakers" class="icon-speakers"><a href="#tomorrow" data-transition="flow">Tomorrow</a></li>
							<li id="nav-schedule" class="icon-schedule"><a href="#overdue" data-transition="flow">Overdue</a></li>
							<li id="nav-venue" class="icon-venue"><a class="ui-btn-active ui-state-persist" href="#overview" data-transition="flow">Overview</a></li>
						</ul>
		</div>
	</div>
	
	
	<div  data-role="fieldcontain">
		<input type="text" class="span3" name="newTask" id="newTask-future" placeholder="Type to add new task for future" date=""/><br/>
		<?php 
			if(isset($result['data']['arrTaskOnDays']) && !empty($result['data']['arrTaskOnDays'])):
			$countDays=0;
			foreach($result['data']['arrTaskOnDays'] as $datelabel => $day):
			$countDays++;
			if ($countDays>7) break;
			if(isset($day) && !empty($day)):
		?>
		<h3><?php echo $datelabel; ?></h3>
		<fieldset data-role="controlgroup" id="incomplete-overview-<?php echo $datelabel; ?>" >
		<?
			foreach($day as $item):
		?>
		<input type="checkbox" data-id="<?php echo $item['Task']['id']; ?>" name="checkbox-<?php echo $item['Task']['id']; ?>" id="checkbox-<?php echo $item['Task']['id']; ?>" class="custom" <?php if($item['Task']['done']):?> checked="checked" <?php endif; ?>/>
		<label for="checkbox-<?php echo $item['Task']['id']; ?>"  class="<?php if($item['Task']['done']):?>complete<?php endif; ?> <?php if($item['Task']['priority']):?>important<?php endif; ?>">
		<?php echo $item['Task']['title']; ?>
		<?php if($item['Task']['time']):?><span class="time" style="float: right;"><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?></span>&nbsp;<?php endif; ?>
		</label>
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
	
	<div data-role="footer" data-position="fixed">
		<a href="/Tasks" rel="external">Go to full version</a>
		<a href="#about">About</a>
	</div><!-- /footer -->

</div>

<!-- Start of second page: #two -->
<div data-role="page" id="about" data-theme="a">

	<div data-role="header">
		<h1>About</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">	
		<h2>This is the best task application</h2>
		<p>Welcome to the best task management site!</p>	
		<p><a href="#today" data-direction="reverse" data-role="button" data-theme="b">Back to Today tasks</a></p>	
		
	</div><!-- /content -->
	
	<div data-role="footer" data-position="fixed">
		<a href="/Tasks" rel="external">Go to full version</a>
		<a href="#about">About</a>
	</div><!-- /footer -->
</div><!-- /page two -->




