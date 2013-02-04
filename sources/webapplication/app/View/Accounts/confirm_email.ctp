<div class="row"> 
    <div class="span10 offset1">
        <?php echo $this->Form->create('User', array('class' => 'well ',
        'inputDefaults' => array(
                'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
                'div' => array('class' => 'control-group'),
                'label' => array('class' => 'control-label'),
                'between' => '<div class="controls">',
                'after' => '</div>',
                'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
            )));?>

   	    <fieldset>
	     <legend><?php echo __d('accounts', 'Введите Ваш e-mail'); ?></legend>
            
            <?php echo $this->Form->input('User.email',array('label' =>false, 'class' => 'input-xlarge'));?>
           
            <?php echo $this->Form->submit(__d('accounts', 'Далее'),array('class'=>'btn btn-info pull-right'));?>
            
            <?php echo $this->Form->end();?>
        </fieldset>
    </div>
</div>

