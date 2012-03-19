<div class="row"> 
    <div class="span6 offset3">
        <fieldset>
    	   <legend><?php echo __('Re-activation'); ?></legend>
                <?php echo $this->Form->create('Account', array('class' => 'well',
                                                                        'inputDefaults' => array(
                                                                        'div' => array('class' => 'control-group'),
                                                                        'label' => array('class' => 'control-label'),
                                                                        'between' => '<div class="controls">',
                                                                        'after' => '</div>',
                                                                        'class' => '')
                                )); ?>

           	<?php echo $this->Form->input('User.first_name',array('readonly' => 'readonly')); ?>
            
            <?php echo $this->Form->input('User.last_name',array('readonly' => 'readonly')); ?>
            
            <?php echo $this->Form->input('User.email',array('readonly' => 'readonly')); ?>
            
            <?php echo $this->Form->submit(__(' Далее '),array('class'=>'btn btn-info '));?>
    
             <?php echo $this->Form->end();?>
    	    
	   </fieldset>
    </div>
</div>
