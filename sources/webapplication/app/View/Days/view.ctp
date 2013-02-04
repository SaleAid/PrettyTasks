<div class="days view">
<h2><?php  echo __('Day');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($day['Day']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($day['User']['id'], array('controller' => 'users', 'action' => 'view', $day['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($day['Day']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rating'); ?></dt>
		<dd>
			<?php echo h($day['Day']['rating']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($day['Day']['date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Day'), array('action' => 'edit', $day['Day']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Day'), array('action' => 'delete', $day['Day']['id']), null, __('Are you sure you want to delete # %s?', $day['Day']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Days'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Day'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
