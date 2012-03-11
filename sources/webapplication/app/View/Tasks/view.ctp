<div class="tasks view">
<h2><?php  echo __('Task');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($task['Task']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($task['User']['id'], array('controller' => 'users', 'action' => 'view', $task['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($task['Task']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Datetime'); ?></dt>
		<dd>
			<?php echo h($task['Task']['datetime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Checktime'); ?></dt>
		<dd>
			<?php echo h($task['Task']['checktime']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo h($task['Task']['order']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Done'); ?></dt>
		<dd>
			<?php echo h($task['Task']['done']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Future'); ?></dt>
		<dd>
			<?php echo h($task['Task']['future']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Repeatid'); ?></dt>
		<dd>
			<?php echo h($task['Task']['repeatid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transfer'); ?></dt>
		<dd>
			<?php echo h($task['Task']['transfer']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Priority'); ?></dt>
		<dd>
			<?php echo h($task['Task']['priority']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($task['Task']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($task['Task']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Task'), array('action' => 'edit', $task['Task']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Task'), array('action' => 'delete', $task['Task']['id']), null, __('Are you sure you want to delete # %s?', $task['Task']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
