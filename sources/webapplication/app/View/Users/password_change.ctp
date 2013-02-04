
<?php echo $this->Form->create('User', array('class' => 'well ',
'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    )));?>
    <fieldset>
		<legend><?php echo __d('users', 'Изменение пароля'); ?></legend>
        <p>
            <?php echo __d('users', 'Пожалуйста, введите свой старый пароль из соображений безопасности, а затем новый пароль дважды'); ?>
        </p>
        <?php
        	echo $this->Form->input('old_password', array(
        		'label' => __d('users', 'Текущий пароль'),
        		'type' => 'password',
                'class' => 'input-xlarge'));
         ?>
         
         <?php echo $this->Html->link(__d('users', 'Забыли пароль?'), array('controller' => 'users', 'action' => 'password_resend')); ?>
         
         <?php
        	echo $this->Form->input('password', array(
        		'label' => __d('users', 'Новый пароль'),
        		'type' => 'password',
                'class' => 'input-xlarge'));
        ?>
        
        <?php	
            echo $this->Form->input('password_confirm', array(
        		'label' =>__d('users', 'Повторите пароль'),
        		'type' => 'password', 'class' => 'input-xlarge'));
                
        ?>

        <?php echo $this->Form->submit(__d('users', 'Сохранить изменения'), array('class' => 'btn btn-info')) ;?>
  
  	    <?php echo $this->Form->end();?>
    
    </fieldset>      