<div class="users form">

<?php echo $this->Form->create('User');?>

	<fieldset>
    	<legend><?php echo __('Re-activation'); ?></legend>
    	<?php echo $this->Form->input('User.first_name',array('readonly' => 'readonly')); ?>
        
        <?php echo $this->Form->input('User.last_name',array('readonly' => 'readonly')); ?>
        
        <?php echo $this->Form->input('User.email',array('readonly' => 'readonly')); ?>
	    
	</fieldset>
    <?php echo $this->Form->submit('Send ',array('class' => 'btn-primary'));?>
    
    <?php echo $this->Form->end();?>

</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>

</div>
