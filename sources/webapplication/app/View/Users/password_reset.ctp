

<?php echo $this->Form->create('User',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
    <fieldset>
		<legend><?php echo __('Выберите новый пароль.'); ?></legend>
        
<?php
	
	echo $this->Form->input('password', array(
		'label' => __('Новый пароль:', true),
		'type' => 'password',
        'class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));
	echo $this->Form->input('password_confirm', array(
		'label' => __('Повторите пароль:', true),
		'type' => 'password','class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));
        
?>

        <?php //echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => Configure::read('Recaptcha.theme'))));?>
           
        <?php echo $this->Form->submit('Отправить',array('class'=>'btn btn-info'));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>      