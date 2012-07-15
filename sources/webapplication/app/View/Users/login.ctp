<?php $this->start ( 'toHead' );?>
<?php echo $this->Html->css($this->Loginza->getCssUrl());?>
<?php $this->end ();?>
<?php $this->start ( 'toFooter' );?>
<?php echo $this->Html->script($this->Loginza->getJs()); ?>
<?php $this->end ();?>
        <div class="login"> 
            <div class="span370">
                    <?php echo $this->Form->create('User',array('class' => 'well ',
                                    'inputDefaults' => array(
                                    'div' => array('class' => 'control-group'),
                                    'label' => array('class' => 'control-label'),
                                    'between' => '<div class="controls">',
                                    'after' => '</div>',
                                    'class' => '')
                                )); ?>
                    <fieldset>
                    <legend><?php echo __('Войдите используя Ваш аккаунт'); ?></legend>
                        <?php echo $this->Form->input('email',array('label'=>' Email: ','class'=>'input-xlarge', 'placeholder'=>'Ваш email')); ?>
                
                        <?php echo $this->Form->input('password',array('label'=>' Пароль: ','class'=>'input-xlarge', 'placeholder'=>'Ваш пароль')); ?>
                
                         <label class="checkbox">
                            <?php echo $this->Form->input('auto_login', array('label'=> __('Оставаться в системе'), 'type'=>'checkbox')); ?>
                            
                         </label>
                        
                        <?php echo $this->Form->submit(' Войти ',array('class'=>' btn btn-primary')); ?>
                        <br />
                        <?php echo $this->Html->link(' Забыли пароль? ', array('controller' => 'users', 'action' => 'password_resend')); ?>
                        
                        |
                        
                        <?php echo $this->Html->link(' Регистрация ', array('controller' => 'users', 'action' => 'register')); ?>
                        
                        <?php echo $this->Form->end(); ?>
                    </fieldset>
                            
            </div>
            <div class="span370">
                 <div class="well">
                 <fieldset>
                 <legend><?php echo __('Вы можете войти как'); ?></legend>
                    <?php echo $this->Loginza->iframeWidget(Configure::read('loginza.token_url'))?>
                     
                     <!-- <iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url=<?php echo Configure::read('loginza.token_url');?>
                                    &providers_set=vkontakte,facebook,twitter,google" 
                             style="width:330px;height:244px;" scrolling="no" frameborder="no">
                    </iframe>
                    -->
                 </fieldset>   
                 </div>   
            </div>
        </div>

           
            
                            
            
        
        

