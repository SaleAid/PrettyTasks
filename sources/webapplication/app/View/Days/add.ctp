<div class="days form">
<?php echo $this->Form->create('Day');?>
	<fieldset>
		<legend><?php echo __('Add Day'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('comment');
		echo $this->Form->input('rating');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Days'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
