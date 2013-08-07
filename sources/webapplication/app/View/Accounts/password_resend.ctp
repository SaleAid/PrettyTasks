<div class="login"> 
<?php echo $this->Session->flash(); ?>
<fieldset>
		<legend><?php echo __d('accounts', 'Забыли пароль?'); ?></legend>
        <p>
            <?php echo __d('accounts', 'Для сброса пароля введите свой адрес электронной почты'); ?>
        </p>

<?php echo $this->Form->create('Account', array('class' => 'form-horizontal',
'inputDefaults' => array(
        //'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline account-error')),
    )));?>
    
<?php
	echo $this->Form->input('email', array(
		'label' => array('text' => __d('accounts', 'Email'), 'class' => 'control-label'),
		'class' => 'input-xlarge',
        ));
?>
        
        <?php echo $this->Captcha->input(); ?>
        <br/>   
        <?php echo $this->Form->submit(__d('accounts', 'Отправить запрос'), array('class'=>'btn btn-info pull-right'));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>  
</div>
   