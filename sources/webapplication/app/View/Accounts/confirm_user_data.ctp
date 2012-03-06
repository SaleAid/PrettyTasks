<div class="users form">
<?php echo $this->Form->create('Account', array('class' => 'well',
                                            'inputDefaults' => array(
                                            'div' => array('class' => 'control-group'),
                                            'label' => array('class' => 'control-label'),
                                            'between' => '<div class="controls">',
                                            'after' => '</div>',
                                            'class' => '')
    )); ?>
	<fieldset>
		<legend><?php echo __('Confirm user data'); ?></legend>
	<?php
		  echo $this->Form->input('User.first_name',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));
		  echo $this->Form->input('User.last_name',array('class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));  
		  
          echo $this->Form->input('User.email',array('readonly'=>'readonly'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
</div>