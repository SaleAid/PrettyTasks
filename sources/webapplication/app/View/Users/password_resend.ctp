<div class="row"> 
    <div class="span10 offset1">
<fieldset>
		<legend><?php echo __('Забыли пароль?'); ?></legend>
        <p>
            <?php echo __('Для сброса пароля введите свой адрес электронной почты.'); ?>
        </p>

<?php echo $this->Form->create('User',array('class' => 'well ',
'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    )));?>
    
<?php
	echo $this->Form->input('email', array(
		'label' => __( 'Ваш адрес электронной почты:'),
		'class' => 'input-xlarge'));
?>
        <p>
            <?php echo __('Пожалуйста, подтвердите, что вы человек.'); ?>
        </p>
        <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'clean')));?>
           
        <?php echo $this->Form->submit('Отправть запрос',array('class'=>'btn btn-info'));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>  
    </div>
</div>
   