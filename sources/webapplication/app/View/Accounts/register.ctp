<div class="login"> 
<?php echo $this->Session->flash(); ?>
    <?php echo $this->Form->create('Account', array('class' => 'form-horizontal',
        'inputDefaults' => array(
                //'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
                'div' => array('class' => 'control-group'),
                'label' => array('class' => 'control-label'),
                'between' => '<div class="controls">',
                'after' => '</div>',
                'error' => array('attributes' => array('wrap' => 'span', 'class' => 'account-error help-inline ')),
            )));?>
	<fieldset>
		<legend><?php echo __d('accounts', 'Регистрация аккаунта'); ?></legend>
    	   <?php echo $this->Form->input('full_name', array('label' => array('text' => __d('accounts', 'Имя'), 'class' => 'control-label'), 'class' => 'input-xlarge', 'placeholder' => __d('accounts', 'Введите ваше имя')));?>
           
    	   <?php echo $this->Form->input('email', array('label' => array('text' => __d('accounts', 'Email'), 'class' => 'control-label'), 'class' => 'input-xlarge', 'placeholder' => __d('accounts', 'Укажите адрес электронной почты'), 'type' => 'text', 'required' => true));?>
           
           <?php //echo $this->Form->input('login', array('label' => array('text' => __d('accounts', 'Логин'), 'class' => 'control-label'), 'class' => 'input-xlarge', 'placeholder' => __d('accounts', 'Введите ваше логин')));?>
           
    	   <?php echo $this->Form->input('password', array('label' => array('text' => __d('accounts', 'Пароль'), 'class' => 'control-label'), 'class' => 'input-xlarge', 'placeholder' => __d('accounts', '6 знаков или больше! Будьте хитрее')));?>
           
           <?php echo $this->Form->input('password_confirm',array('label' => array('text' => __d('accounts', 'Повторите пароль'), 'class' => 'control-label'), 'type' => 'password', 'class' => 'input-xlarge', 'placeholder' => __d('accounts', 'Повторите пароль')));?>
           
           <?php echo $this->Captcha->input(); ?>
           
           <div class="grp-btn-reg">
               <div class="box-loginza-registr pull-right">
                    <span><?php echo __d('accounts', 'ИЛИ'); ?></span>
                    <div class="box-icons-widget">
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('google'),
                                     array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                         'google'
                                     ),
                                     array('escape' => false, 'tabindex' => -1, "alt" => "Google", "title" => "Google")
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('facebook'),
                                     array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                         'facebook'
                                     ),
                                     array('escape' => false, 'tabindex' => -1, "alt" => "Facebook", "title" => "Facebook")
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('linkedin'),
                                     array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                         'linkedin'
                                     ),
                                     array('escape' => false, 'tabindex' => -1, "alt" => "LinkedIn", "title" => "LinkedIn")
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('twitter'),
                                     array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                         'twitter'
                                     ),
                                     array('escape' => false, 'tabindex' => -1, "alt" => "Twitter", "title" => "Twitter")
                                 );
                        ?>
                        <?php
                            echo $this->Html->link(
                                     $this->Loginza->ico('vkontakte'),
                                     array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index',
                                         'vkontakte'
                                     ),
                                     array('escape' => false, 'tabindex' => -1, "alt" => "ВКонтакте", "title" => "ВКонтакте")
                                 );
                        ?>
                    </div>
               </div>
               </div>
               <?php echo $this->Form->submit(__d('accounts', 'Регистрация'), array('class' => 'btn btn-info pull-right'));?>
                
       </fieldset>
    <?php echo $this->Form->end();?>
    <p>
        <?php echo __d('accounts', 'Уже регистрировались? Тогда'); ?>  <?php echo $this->Html->link(__d('accounts', 'войдите'), array('controller' => 'accounts', 'action' => 'login'));?>            
    </p> 
        <div class="social-bnts">
        <span class="social-or"><?php echo __d('accounts', 'ИЛИ'); ?></span>
        <ul>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('google'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'google'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('facebook'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'facebook'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('linkedin'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'linkedin'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
            <li><?php echo $this->Form->postLink($this->Loginza->logo('twitter'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'twitter'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        	<li><?php echo $this->Form->postLink($this->Loginza->logo('vkontakte'), array('plugin' => 'Opauth', 'controller' => 'Opauth', 'action' => 'index', 'vkontakte'), array('class' => 'btn social-bnt', 'escape' => false)); ?></li>
        </ul>
    </div>
</div>
