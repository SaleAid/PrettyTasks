<div class="goals form">
<?php echo $this->Form->create('Goal'); ?>
	<fieldset>
		<legend><?php echo __('Edit Goal'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('comment');
		echo $this->Form->input('fromdate');
		echo $this->Form->input('todate');
		echo $this->Form->input('datedone');
		echo $this->Form->input('done');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Goal.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Goal.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Goals'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>