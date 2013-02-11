<?php
		echo $this->Session->flash('auth');
	?>
<div class="span5 offset3">
	

	<?php echo $this->Form->create('User', array('class' => 'well ',
			'inputDefaults' => array(
			'div' => array('class' => 'control-group'),
			'label' => array('class' => 'control-label'),
			'between' => '<div class="controls">',
			'after' => '</div>',
			'class' => '')
		    )); ?>
	<fieldset>
	<legend><?php echo __d('users', 'Войдите используя Ваш аккаунт'); ?></legend>
	
	    <?php echo $this->Form->input('email', array('label' => __d('users', 'Логин или Емейл'), 'type' => 'text', 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Логин или Емейл'))); ?>
    
	    <?php echo $this->Form->input('password' ,array('label' => __d('users', 'Пароль'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Пароль'))); ?>
	    <?php echo $this->Form->submit(__d('users', 'Войти'), array('class' => 'btn btn-large btn-block btn-primary')); ?>
	    
	    <div class="clearfix"></div>
	    
	    <?php echo $this->Html->link(__d('users', 'Забыли пароль?') , array('controller' => 'users', 'action' => 'password_resend', 'plugin' => false)); ?>
	    &nbsp;&bull;&nbsp;
	    <?php echo $this->Html->link(__d('users', 'Регистрация'), array('controller' => 'users', 'action' => 'register', 'plugin' => false)); ?>
	    
	    <?php foreach ($OAuthParams as $key => $value) {
		echo $this->Form->hidden(h($key), array('value' => h($value)));
	    } ?>
	    
	    <?php echo $this->Form->end(); ?>
	</fieldset>
		
</div>

