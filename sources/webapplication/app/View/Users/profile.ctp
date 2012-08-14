<div>
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
		<legend><?php echo __d('users', 'Здесь вы можете изменить свои основные данные.'); ?></legend>
        <?php echo $this->Form->input('first_name', array('label' => __d('users', 'Имя пользователя:'), 'class' => 'input-xlarge'));?>
           
        <?php echo $this->Form->input('last_name', array('label' => __d('users', 'Фамилия пользователя:'), 'class' => 'input-xlarge'));?>
        
        <?php echo $this->Form->label('timezone', __d('users', 'Часовой пояс:')); ?>
	    
        <?php echo $this->Form->select('timezone', $list)?>
        
        <?php echo $this->Form->submit(__d('users', 'Сохранить изменения'),array('class'=>'btn btn-large btn-info'));?>
        
    </fieldset>
    <?php echo $this->Form->end();?>
</div>