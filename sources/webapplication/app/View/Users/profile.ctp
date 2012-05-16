<div>
<?php echo $this->Form->create('User',array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>

	<fieldset>
		<legend><?php echo __('Здесь вы можете изменить свои основные данные.'); ?></legend>
        <?php echo $this->Form->input('first_name', array('label' =>'Имя пользователя:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
           
        <?php echo $this->Form->input('last_name', array('label' =>'Фамилия пользователя:', 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
        
	    <?php echo $this->Form->select('timezone', $list)?>
        
        <?php echo $this->Form->submit(__('Сохранить изменения'),array('class'=>'btn btn-large btn-info'));?>
        
    </fieldset>
    <?php echo $this->Form->end();?>

</div>