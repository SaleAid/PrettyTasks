<div class="articles index">
	<h2><?php echo __('Articles'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
	</tr>
	</thead>
	<tbody>

	</tbody>
	</table>
	

	<?php foreach ($articles as $article): ?>
	<div class="artilce">
		<h2><?php echo h($article['Article']['title']); ?></h2>
		<div class="description"><?php echo h($article['Article']['description']); ?></div>
		<div><?php echo $this->Html->link(__('more details...'), array('action' => 'view', $article['Article']['id'])); ?></div>
	</div>
	<?php endforeach; ?>
	
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
