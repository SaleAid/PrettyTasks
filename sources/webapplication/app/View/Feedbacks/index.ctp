<div class="feedbacks index">
	<h2><?php __('Feedbacks');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('lang');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('subject');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('processed');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('version_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($feedbacks as $feedback):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $feedback['Feedback']['id']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['lang']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['email']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['name']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['status']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['subject']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['message']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['processed']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($feedback['User']['id'], array('controller' => 'users', 'action' => 'view', $feedback['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($feedback['Version']['name'], array('controller' => 'versions', 'action' => 'view', $feedback['Version']['id'])); ?>
		</td>
		<td><?php echo $feedback['Feedback']['created']; ?>&nbsp;</td>
		<td><?php echo $feedback['Feedback']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $feedback['Feedback']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $feedback['Feedback']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $feedback['Feedback']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $feedback['Feedback']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Feedback', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Versions', true)), array('controller' => 'versions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Version', true)), array('controller' => 'versions', 'action' => 'add')); ?> </li>
	</ul>
</div>