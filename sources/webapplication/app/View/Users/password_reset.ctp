
<?php echo $this->Form->create('User',array('class' => 'well ',
'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    )));?>
    <fieldset>
		<legend><?php echo __('Выберите новый пароль.'); ?></legend>
        
<?php
	
	echo $this->Form->input('password', array(
		'label' => __('Новый пароль:', true),
		'type' => 'password',
        'class' => 'input-xlarge'));
	echo $this->Form->input('password_confirm', array(
		'label' => __('Повторите пароль:', true),
		'type' => 'password',
        'class' => 'input-xlarge'));
        
?>
   
        <?php echo $this->Form->submit('Отправить',array('class'=>'btn btn-info'));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>      