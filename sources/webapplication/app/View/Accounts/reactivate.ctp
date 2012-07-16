<div class="row"> 
    <div class="span10 offset1">
       
            <?php echo $this->Form->create('User', array('class' => 'well',
                                                                        'inputDefaults' => array(
                                                                        'div' => array('class' => 'control-group'),
                                                                        'label' => array('class' => 'control-label'),
                                                                        'between' => '<div class="controls">',
                                                                        'after' => '</div>',
                                                                        'class' => '')
                                )); ?>

            <fieldset>
    	   <legend><?php echo __('Повторная активация'); ?></legend>
            <?php echo $this->Form->input('User.first_name',array('label' => 'Имя','class'=>'input-xlarge', 'readonly' => 'readonly')); ?>
            
            <?php //echo $this->Form->input('User.last_name',array('readonly' => 'readonly')); ?>
            
            <?php echo $this->Form->input('User.email',array('class'=>'input-xlarge', 'readonly' => 'readonly')); ?>
            
            <?php echo $this->Form->submit(__('Далее'),array('class'=>'btn btn-info '));?>
    
             <?php echo $this->Form->end();?>
    	    
	   </fieldset>
    </div>
</div>
