<div class="span8 offset2">
<?php echo $this->Form->create('Accounts',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
	<fieldset>
		<legend><?php echo __('Регистрация аккаунта'); ?></legend>
    	   <?php echo $this->Form->input('User.first_name', array('label' =>'Имя:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('User.last_name', array('label' =>'Фамилия:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('User.email', array('label' =>'Email:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
           <?php echo $this->Form->input('Account.username', array('label' =>'Логин:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
    	   <?php echo $this->Form->input('Account.password', array('label' =>'Пароль:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
           <?php echo $this->Form->input('Account.password_confirm',array('label' => 'Повторите пароль:', 'type' => 'password','class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
           <?php echo $this->Form->submit('Регистрация');?>
           
	   </fieldset>
<?php echo $this->Form->end();?>
</div>

