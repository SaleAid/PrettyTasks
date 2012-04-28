

<?php echo $this->Form->create('User',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
    <fieldset>
		<legend><?php echo __('Изменение пароля:'); ?></legend>
        <p>
            <?php echo __('Пожалуйста, введите свой старый пароль из соображений безопасности, а затем новый пароль дважды.'); ?>
        </p>
<?php
	echo $this->Form->input('old_password', array(
		'label' => __( 'Текущий пароль ', true),
		'type' => 'password',
        'class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));
 ?>
 
 <?php echo $this->Html->link(' Забыли пароль? ', array('controller' => 'users', 'action' => 'password_resend')); ?>
 
 <?php
	echo $this->Form->input('password', array(
		'label' => __('Новый пароль ', true),
		'type' => 'password',
        'class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));
?>

<?php	
    echo $this->Form->input('password_confirm', array(
		'label' => __('Повторите пароль ', true),
		'type' => 'password','class' => 'input-xlarge',
        'error' => array('attributes' => array('class' => 'controls help-block'))));
        
?>

        <?php echo $this->Form->submit(__('Сохранить изменения'),array('class'=>'btn btn-info'));?>
  
  	<?php echo $this->Form->end();?>
    
    </fieldset>      