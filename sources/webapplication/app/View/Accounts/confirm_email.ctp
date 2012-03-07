<div class="users form">

<?php echo $this->Form->create('Account',array('class' => 'well form-inline',
    'inputDefaults' => array(
        'div' => array('class' => 'control-group'),
        'label' => array('class' => 'control-label'),
        'between' => '<div class="controls">',
        'after' => '</div>',
        'class' => '')
        )); ?>
	<fieldset>
	     <legend><?php echo __('Введите Ваш e-mail ...'); ?></legend>
    
            <?php echo $this->Form->input('User.email',array('label' =>false, 'class' => 'input-xlarge', 'error' => array('attributes' => array('class' => 'controls help-block'))));?>
    
    </fieldset>
<?php echo $this->Form->end(__('Submit'),array('class' => ''));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>

</div>
