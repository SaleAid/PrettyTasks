<div class="row"> 
    <div class="span6 offset3">
<fieldset>
		<legend><?php echo __('Забыли пароль?'); ?></legend>
        <p>
            <?php echo __('Для сброса пароля введите свой адрес электронной почты.'); ?>
        </p>

<?php echo $this->Form->create('User',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
    
<?php
	echo $this->Form->input('email', array(
		'label' => __( 'Ваш адрес электронной почты:', true),
		'class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));

?>
        <p>
            <?php echo __('Пожалуйста, подтвердите, что вы человек.'); ?>
        </p>
        <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'clean')));?>
           
        <?php echo $this->Form->submit('Сохранить изменения');?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>  
    </div>
</div>
   