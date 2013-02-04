<div class="row"> 
    <div class="span10 offset1">
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
                <legend><?php echo __d('accounts', 'Регистрация аккаунта'); ?></legend>
            	<?php echo $this->Form->input('User.username', array('label' => __d('accounts', 'Логин'), 'class' => 'input-xlarge')); ?>
                
            	<?php echo $this->Form->input('User.first_name', array('label' => __d('accounts', 'Имя'), 'class' => 'input-xlarge')); ?>
            	
                <?php //echo $this->Form->input('User.last_name',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block')))); ?> 
                
                <?php echo $this->Form->input('User.email', array('readonly' => 'readonly', 'class' => 'input-xlarge'));?>
                <label class="checkbox">
                    <?php echo $this->Form->input('agreed', array('label'=>  __d('accounts', 'Я согласен с').'&nbsp;'.$this->Html->link(__d('accounts', 'условиями использования'),array('controller' => 'pages', 'action' => 'terms-and-conditions')), 'type'=>'checkbox', 'format' => array('before', 'label', 'between', 'error', 'after'))); ?>
                </label>
           
            	
                <?php echo $this->Form->submit(__d('accounts', 'Далее'), array('class'=>'btn btn-info pull-right'));?>
                        
                <?php echo $this->Form->end();?>
        </fieldset>
    </div>
</div>
