<div class="faqs form">
<?php echo $this->Form->create('Faq');?>
	<fieldset>
 		<legend><?php printf(__('Admin Edit %s', true), __('Faq', true)); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('faqcategory_id');
		echo $this->Form->input('lang', array('type' => 'hidden', 'value' => Configure::read('Config.language')));
		echo $this->Form->input('subject');
        echo $this->Form->input('url');
		echo $tinymce->textarea('annotation');
		echo $tinymce->textarea('content');
		echo $this->Form->input('active');
        echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => 0)); 
        echo $this->Form->input('url');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Faq.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Faq.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Faqs', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Faqcategories', true)), array('controller' => 'faqcategories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Faqcategory', true)), array('controller' => 'faqcategories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Users', true)), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('User', true)), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>