<div class="faqs index">
	<h2><?php __('Faqs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('faqcategory_id');?></th>
			<th><?php echo $this->Paginator->sort('subject');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($faqs as $faq):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $faq['Faq']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($faq['Faqcategory']['name'], array('controller' => 'faqcategories', 'action' => 'view', $faq['Faqcategory']['id'])); ?>
		</td>
		<td><?php echo $faq['Faq']['subject']; ?>&nbsp;</td>
		<td><?php echo $faq['Faq']['active']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $faq['Faq']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $faq['Faq']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $faq['Faq']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faq['Faq']['id'])); ?>
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
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Faq', true)), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Faqcategories', true)), array('controller' => 'faqcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Faqcategory', true)), array('controller' => 'faqcategories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>