<h1>Empty list</h1>
<div class="actions">
	
    <h3><?php echo __('ActLogin '); ?></h3>
	<ul>
		
        <li><?php echo $this->Html->link(__('Twiter'), array('controller'=>'example','action' => 'twitter')); ?></li>
        <li><?php echo $this->Html->link(__('VK'), array('controller'=>'example','action' => 'vk')); ?></li>
         <li><?php echo $this->Html->link(__('Google'), array('controller'=>'example','action' => 'google')); ?></li>
          <li><?php echo $this->Html->link(__('Facebook'), array('controller'=>'example','action' => 'facebook')); ?></li>
	</ul>
</div>