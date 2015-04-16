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
		<legend><?php echo __d('users', 'Управление подписками'); ?></legend>
        
        <?php 
        echo $this->Form->label('subscribe_news', __d('users', 'Получать новости')); 
	    echo $this->Form->select('subscribe_news', $options_subscribtions_news, array('class' => 'input-xlarge', 'value' =>1, 'empty' => false));
	    echo $this->Form->label('subscribe_daily_digest', __d('users', 'Получать ежедневные отчеты'));
	    echo $this->Form->select('subscribe_daily_digest', $options_subscribe_daily_digest, array('class' => 'input-xlarge', 'value' =>0, 'empty' => false));        
	    echo $this->Form->label('subscribe_weekly_digest', __d('users', 'Получать еженедельные отчеты'));
	    echo $this->Form->select('subscribe_weekly_digest', $options_subscribe_weekly_digest, array('class' => 'input-xlarge', 'value' =>1, 'empty' => false));       
        echo $this->Form->submit(__d('users', 'Сохранить изменения'),array('class'=>'btn btn-large btn-info'));?>
        
    </fieldset>
    <?php echo $this->Form->end();?>
</div>