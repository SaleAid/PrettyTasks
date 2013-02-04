<div class="row"> 
    <div class="span10 offset1">
<fieldset>
		<legend><?php echo __d('users', 'Забыли пароль?'); ?></legend>
        <p>
            <?php echo __d('users', 'Для сброса пароля введите свой адрес электронной почты'); ?>
        </p>

<?php echo $this->Form->create('User', array('class' => 'well ',
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
		'label' => __d('users', 'Ваш адрес электронной почты'),
		'class' => 'input-xlarge',
        'tabindex' => 1));
?>
        <p>
            <?php //echo __d('users', 'Пожалуйста, подтвердите, что вы человек'); ?>
        </p>
        <?php //echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'clean', 'tabindex' => 2)));?>
        <?php echo $this->Captcha->input(); ?>
        <br/>   
        <?php echo $this->Form->submit(__d('users', 'Отправить запрос'), array('class'=>'btn btn-info', 'tabindex' => 2));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>  
    </div>
</div>
   