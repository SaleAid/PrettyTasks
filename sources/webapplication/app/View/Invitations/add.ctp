<div class="invitations form">
<?php
echo $this->Form->create('Invitation', 
                        array(
                            'class' => 'well', 
                            'inputDefaults' => array(
                                'div' => array(
                                    'class' => 'control-group'
                                ), 
                                'label' => array(
                                    'class' => 'control-label'
                                ), 
                                'between' => '<div class="controls">', 
                                'after' => '</div>', 
                                'class' => ''
                            )
                        ));
?>
<fieldset><legend><?php
echo __('Пригласить друзей');
?></legend>
	<?php
echo $this->Form->input('emails', 
                        array(
                            'label' => __('Введите емейлы тех, кого вы хотите пригласить на сервис', true), 
                            'type' => 'textarea', 
                            'class' => 'input-xxlarge', 
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'controls help-block'
                                ), 
                                'email' => __('Похоже, емейлы не правильные')
                            )
                        ));
?>
<p>
    <?php echo __('Пожалуйста, подтвердите, что вы человек.'); ?>
</p>
           
<?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => Configure::read('Recaptcha.theme'))));?>
</fieldset>
<?php
echo $this->Form->submit(__('Пригласить'), array(
    'class' => 'btn btn-info'
));
echo $this->Form->end();
?>
</div>
