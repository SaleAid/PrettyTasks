<div class="articles form">
<?php echo $this->Form->create('Article'); ?>
	<fieldset>
		<legend><?php echo __('Add Article'); ?></legend>
	<?php
		echo $this->Form->input('slug');
		echo $this->Form->input('lang');
		echo $this->Form->input('acategory_id');
		echo $this->Form->input('title');
		echo $this->Form->input('content');
		echo $this->Form->input('keywords');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Articles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Acategories'), array('controller' => 'acategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Acategory'), array('controller' => 'acategories', 'action' => 'add')); ?> </li>
	</ul>
</div>
