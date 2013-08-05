<div class="login"> 
    <?php echo $this->Session->flash(); ?>
    
    <?php echo $this->Form->create('Account', array('class' => '',
    'inputDefaults' => array(
            'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
            'div' => array('class' => 'control-group'),
            'label' => array('class' => 'control-label'),
            'between' => '<div class="controls">',
            'after' => '</div>',
            'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
        )));?>
        <fieldset>
    		<legend><?php echo __d('accounts', 'Выберите новый пароль'); ?></legend>
            
    <?php
    	
    	echo $this->Form->input('password', array(
    		'label' => __d('accounts', 'Новый пароль'),
    		'type' => 'password',
            'class' => 'input-xlarge'));
            
    	echo $this->Form->input('password_confirm', array(
    		'label' => __d('accounts', 'Повторите пароль'),
    		'type' => 'password',
            'class' => 'input-xlarge'));
            
    ?>
       
        <?php echo $this->Form->submit(__d('accounts', 'Отправить'), array('class'=>'btn btn-info'));?>
      
      	<?php echo $this->Form->end();?>
        
        </fieldset>      
</div>