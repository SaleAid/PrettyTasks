<div class="articles view">
<h2><?php echo __('Article'); ?></h2>
	<dl>

		<dt><?php echo __('Acategory'); ?></dt>
		<dd>
			<?php echo $this->Html->link($article['Acategory']['name'], array('controller' => 'acategories', 'action' => 'view', $article['Acategory']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($article['Article']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($article['Article']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keywords'); ?></dt>
		<dd>
			<?php echo h($article['Article']['keywords']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($article['Article']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($article['Article']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($article['Article']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

