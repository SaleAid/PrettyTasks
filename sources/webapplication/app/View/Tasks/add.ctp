<div class="tasks form">
<?php echo $this->Form->create('Task');?>
	<fieldset>
		<legend><?php echo __('Add Task'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('title');
		//echo $this->Form->input('datetime');
		//echo $this->Form->input('checktime');
		echo $this->Form->input('order');
		//echo $this->Form->input('done');
		echo $this->Form->input('future', array('type' => 'checkbox'));
		echo $this->Form->input('repeatid');
		echo $this->Form->input('transfer');
		echo $this->Form->input('priority');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tasks'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
