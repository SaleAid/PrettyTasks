<div class="goals view">
<h2><?php  echo __('Goal'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fromdate'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['fromdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Todate'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['todate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Datedone'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['datedone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Done'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['done']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($goal['User']['id'], array('controller' => 'users', 'action' => 'view', $goal['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($goal['Goal']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Goal'), array('action' => 'edit', $goal['Goal']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Goal'), array('action' => 'delete', $goal['Goal']['id']), null, __('Are you sure you want to delete # %s?', $goal['Goal']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Goals'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Goal'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
