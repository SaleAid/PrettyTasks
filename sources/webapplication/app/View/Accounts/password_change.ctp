<div class="well">

<?php if($currentUser['provider'] == 'local'):?>

<?php echo $this->Form->create('Account', array('class' => ' ',
'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
    )));?>
    <fieldset>
		<legend><?php echo __d('accounts', 'Изменение пароля'); ?></legend>
        <p>
            <?php echo __d('accounts', 'Пожалуйста, введите свой старый пароль из соображений безопасности, а затем новый пароль дважды'); ?>
        </p>
        <?php
        	echo $this->Form->input('old_password', array(
        		'label' => __d('accounts', 'Текущий пароль'),
        		'type' => 'password',
                'class' => 'input-xlarge'));
         ?>
         
         <?php echo $this->Html->link(__d('accounts', 'Забыли пароль?'), array('controller' => 'accounts', 'action' => 'password_resend')); ?>
         
         <?php
        	echo $this->Form->input('password', array(
        		'label' => __d('accounts', 'Новый пароль'),
        		'type' => 'password',
                'class' => 'input-xlarge'));
        ?>
        
        <?php	
            echo $this->Form->input('password_confirm', array(
        		'label' =>__d('accounts', 'Повторите пароль'),
        		'type' => 'password', 'class' => 'input-xlarge'));
                
        ?>

        <?php echo $this->Form->submit(__d('accounts', 'Сохранить изменения'), array('class' => 'btn btn-info')) ;?>
  
  	    <?php echo $this->Form->end();?>
    
    </fieldset>      
<?php else: ?>
    <?php echo $this->element('empty_lists', array('type' => 'password_change', 'hide' => false));?>
<?php endif; ?>
</div>