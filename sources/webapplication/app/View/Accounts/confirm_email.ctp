<div class="row"> 
    <div class="span6 offset3">
   	    <fieldset>
	     <legend><?php echo __('Введите Ваш e-mail ...'); ?></legend>
            <?php echo $this->Form->create('Account',array('class' => 'well form-inline',
                'inputDefaults' => array(
                    'div' => array('class' => 'control-group'),
                    'label' => array('class' => 'control-label'),
                    'between' => '<div class="controls">',
                    'after' => '</div>',
                    'class' => '')
                    )); ?>
            
            <?php echo $this->Form->input('User.email',array('label' =>false, 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
            
            <?php echo $this->Form->submit(__(' Далее '),array('class'=>'btn btn-info'));?>
            
            <?php echo $this->Form->end();?>
        </fieldset>
    </div>
</div>

