<div class="feedbacks form">
<?php echo $this->Form->create('Feedback');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Feedback', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('lang', array('type' => 'hidden', 'value' => Configure::read('Config.language')));
		echo $this->Form->input('email');
		echo $this->Form->input('name');
		echo $this->Form->input('status');
		echo $this->Form->input('subject');
		echo $this->Form->input('message');
		echo $this->Form->input('processed');
		echo $this->Form->input('user_id');
		echo $this->Form->input('version_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Feedback.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Feedback.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Feedbacks', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Versions', true)), array('controller' => 'versions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Version', true)), array('controller' => 'versions', 'action' => 'add')); ?> </li>
	</ul>
</div>