<div>
<?php echo $this->Form->create('Setting', array('class' => 'well ',
'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'error' => array('attributes' => array('wrap' => 'span', 'class' => 'help-inline')),
		'url' => ['controller' => 'users', 'action' => 'subscriptions']
    )));?>

	<fieldset>
		<legend><?php echo __d('users', 'Управление подписками'); ?></legend>
        
        <?php 
        //Prepare data for lists
        $options_subscribtions_news = [
        		0 => __d('users', 'Не получать'),
        		1 => __d('users', 'Получать'),
        ];

        $options_subscribe_daily_digest = [
        		0 => __d('users', 'Не получать'),
        		1 => __d('users', 'Получать, если есть изменения'),
        		2 => __d('users', 'Получать всегда'),
        ];

        $options_subscribe_weekly_digest = [
        		0 => __d('users', 'Не получать'),
        		1 => __d('users', 'Получать'),
        ];

        echo $this->Form->label('subscribe_news', __d('users', 'Получать новости')); 
	    echo $this->Form->select('subscribe_news', $options_subscribtions_news, array('class' => 'input-xlarge', 'empty' => false));
	    echo $this->Form->label('subscribe_daily_digest', __d('users', 'Получать ежедневные отчеты'));
	    echo $this->Form->select('subscribe_daily_digest', $options_subscribe_daily_digest, array('class' => 'input-xlarge', 'empty' => false));        
	    echo $this->Form->label('subscribe_weekly_digest', __d('users', 'Получать еженедельные отчеты'));
	    echo $this->Form->select('subscribe_weekly_digest', $options_subscribe_weekly_digest, array('class' => 'input-xlarge', 'empty' => false));       
        echo $this->Form->submit(__d('users', 'Сохранить изменения'),array('class'=>'btn btn-large btn-info'));?>
        
    </fieldset>
    <?php echo $this->Form->end();?>
</div>