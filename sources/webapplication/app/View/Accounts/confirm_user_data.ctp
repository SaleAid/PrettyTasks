<div class="row"> 
    <div class="span6 offset3">
        <fieldset>
		  <legend><?php echo __('Confirm user data'); ?></legend>
            <?php echo $this->Form->create('User', array('class' => 'well',
                                                        'inputDefaults' => array(
                                                        'div' => array('class' => 'control-group'),
                                                        'label' => array('class' => 'control-label'),
                                                        'between' => '<div class="controls">',
                                                        'after' => '</div>',
                                                        'class' => '')
                )); ?>
            	<?php echo $this->Form->input('User.username',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block')))); ?>
                
            	<?php echo $this->Form->input('User.first_name',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block')))); ?>
            	
                <?php echo $this->Form->input('User.last_name',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block')))); ?> 
                
                <?php echo $this->Form->input('User.email',array('readonly'=>'readonly'));?>
            	
                <?php echo $this->Form->submit(__(' Далее '),array('class'=>'btn btn-info '));?>
                        
                <?php echo $this->Form->end();?>
        </fieldset>
    </div>
</div>
