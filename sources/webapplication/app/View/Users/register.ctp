<div class="span8 offset2">
<?php echo $this->Form->create('User',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
	<fieldset>
		<legend><?php echo __('Регистрация аккаунта'); ?></legend>
    	   <?php echo $this->Form->input('first_name', array('label' =>'Имя:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('last_name', array('label' =>'Фамилия:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('email', array('label' =>'Email:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
           <?php echo $this->Form->input('username', array('label' =>'Логин:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('password', array('label' =>'Пароль:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
           <?php echo $this->Form->input('password_confirm',array('label' => 'Повторите пароль:', 'type' => 'password','class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
            <p>
                <?php echo __('Пожалуйста, подтвердите, что вы человек.'); ?>
            </p>
           
           <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => 'clean')));?>
           
           <?php echo $this->Form->submit(__('Регистрация'),array('class'=>'btn btn-info'));?>
           
           
           
	   </fieldset>
<?php echo $this->Form->end();?>
</div>

