<div class="span10 offset1">
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
		<legend><?php echo __('Регистрация аккаунта'); ?></legend>
    	   <?php echo $this->Form->input('first_name', array('label' =>'Имя:', 'class' => 'input-xlarge'));?>
           
    	   <?php //echo $this->Form->input('last_name', array('label' =>'Фамилия:', 'class' => 'input-xlarge'));?>
           
    	   <?php echo $this->Form->input('email', array('label' =>'Email:', 'class' => 'input-xlarge'));?>
           
           <?php echo $this->Form->input('username', array('label' =>'Логин:', 'class' => 'input-xlarge'));?>
           
    	   <?php echo $this->Form->input('password', array('label' =>'Пароль:', 'class' => 'input-xlarge'));?>
           
           <?php echo $this->Form->input('password_confirm',array('label' => 'Повторите пароль:', 'type' => 'password','class' => 'input-xlarge'));?>
           
            <p>
                <?php echo __('Пожалуйста, подтвердите, что вы человек.'); ?>
            </p>
           
           <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => Configure::read('Recaptcha.theme'))));?>
           
           <br />
           <label class="checkbox">
                <?php echo $this->Form->input('agreed', array('label'=> __('Я согласен с условиями использования'), 'type'=>'checkbox', 'format' => array('before', 'label', 'between',  'error', 'after'))); ?>
           </label>
           <br />
           <?php echo $this->Form->submit(__('Регистрация'),array('class'=>'btn btn-info'));?>
           
	   </fieldset>
<?php echo $this->Form->end();?>
                    
</div>

