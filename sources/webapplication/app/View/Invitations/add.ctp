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
echo __d('invitations', 'Пригласить друзей');
?></legend>
	<?php
echo $this->Form->input('emails', 
                        array(
                            'label' => __d('invitations', 'Введите емейлы тех, кого вы хотите пригласить на сервис'), 
                            'type' => 'textarea', 
                            'class' => 'input-xxlarge', 
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'controls help-block'
                                ), 
                                'email' => __d('invitations', 'Похоже, емейлы не правильные')
                            )
                        ));
?>
<p>
    <?php echo __d('invitations', 'Пожалуйста, подтвердите, что вы человек.'); ?>
</p>
           
<?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => Configure::read('Recaptcha.theme'))));?>
</fieldset>
<br />
<?php
echo $this->Form->submit(__d('invitations', 'Пригласить'), array(
    'class' => 'btn btn-info'
));
echo $this->Form->end();
?>
</div>
