<div class="goals index">
	<h2><?php echo __('Goals'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th><?php echo $this->Paginator->sort('fromdate'); ?></th>
			<th><?php echo $this->Paginator->sort('todate'); ?></th>
			<th><?php echo $this->Paginator->sort('datedone'); ?></th>
			<th><?php echo $this->Paginator->sort('done'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($goals as $goal): ?>
	<tr>
		<td><?php echo h($goal['Goal']['id']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['title']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['comment']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['fromdate']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['todate']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['datedone']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['done']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($goal['User']['id'], array('controller' => 'users', 'action' => 'view', $goal['User']['id'])); ?>
		</td>
		<td><?php echo h($goal['Goal']['created']); ?>&nbsp;</td>
		<td><?php echo h($goal['Goal']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $goal['Goal']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $goal['Goal']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $goal['Goal']['id']), null, __('Are you sure you want to delete # %s?', $goal['Goal']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Goal'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
