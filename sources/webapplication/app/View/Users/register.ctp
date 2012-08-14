<?php $this->start ( 'toFooter' );?>
<?php echo $this->Html->script($this->Loginza->getJs()); ?>
<?php $this->end ();?>

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
		<legend><?php echo __d('users', 'Регистрация аккаунта'); ?>
                <div class="box-loginza-registr-top pull-right">
                <span><?php echo __d('users', 'Или использовать аккаунт социальной сети'); ?></span>
                    <div class="box-icons-widget">
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'google')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'facebook')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'twitter')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'vkontakte')?>
                    </div>
               </div>
        </legend>
    	   <?php echo $this->Form->input('first_name', array('label' =>__d('users', 'Имя:'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Введите ваше имя')));?>
           
    	   <?php //echo $this->Form->input('last_name', array('label' =>'Фамилия:', 'class' => 'input-xlarge'));?>
           
    	   <?php echo $this->Form->input('email', array('label' => __d('users', 'Email:'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Укажите адрес электронной почты')));?>
           
           <?php echo $this->Form->input('username', array('label' => __d('users', 'Логин:'), 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Введите ваше логин')));?>
           
    	   <?php echo $this->Form->input('password', array('label' => __d('users', 'Пароль:'), 'class' => 'input-xlarge', 'placeholder' => __d('users', '6 знаков или больше! Будьте хитрее')));?>
           
           <?php echo $this->Form->input('password_confirm',array('label' => __d('users', 'Повторите пароль:'), 'type' => 'password', 'class' => 'input-xlarge', 'placeholder' => __d('users', 'Повторите пароль')));?>
           
            <p>
                <?php echo __d('users', 'Пожалуйста, подтвердите, что вы человек.'); ?>
            </p>
           
           <?php echo $this->Recaptcha->display(array('recaptchaOptions' => array('theme' => Configure::read('Recaptcha.theme'))));?>
           
           <br />
           <label class="checkbox">
                <?php echo $this->Form->input('agreed', array('label'=> __d('users', 'Я согласен с ') . $this->Html->link(__d('users', 'условиями использования'), array('controller' => 'pages', 'action' => 'terms-and-conditions')), 'type'=>'checkbox', 'format' => array('before', 'label', 'between', 'error', 'after'))); ?>
           </label>
           <br />
           <div class="grp-btn-reg">
               <?php echo $this->Form->submit(__d('users', 'Регистрация'), array('class' => 'btn btn-info pull-left'));?>
               <div class="box-loginza-registr pull-left">
                    <span><?php echo __d('users', 'ИЛИ'); ?></span>
                    <div class="box-icons-widget">
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'google')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'facebook')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'twitter')?>
                        <?php echo $this->Loginza->iconsWidget(Configure::read('loginza.token_url'),'vkontakte')?>
                    </div>
               </div>
           </div>
       </fieldset>
<?php echo $this->Form->end();?>
                    
</div>
