<?php $this->start ( 'toHead' );?>
<?php $this->Combinator->add_libs('css', array('loginza/widget_style'));?>
<?php $this->end ();?>
<?php $this->start ( 'toFooter' );?>
<?php echo $this->Html->script('http://loginza.ru/js/widget.js'); ?>
<?php $this->end ();?>
        <h2 align="center">Авторизация</h2>
        <div class="login"> 
            <div class="span370">
                <h3 >Войдите используя Ваш аккаунт:</h3>
                    <?php echo $this->Form->create('User',array('class' => 'well ',
                                    'inputDefaults' => array(
                                    'div' => array('class' => 'control-group'),
                                    'label' => array('class' => 'control-label'),
                                    'between' => '<div class="controls">',
                                    'after' => '</div>',
                                    'class' => '')
                                )); ?>
            
                    <?php echo $this->Form->input('username',array('label'=>' Логин: ','class'=>'input-xlarge', 'placeholder'=>'Ваш логин')); ?>
            
                    <?php echo $this->Form->input('password',array('label'=>' Пароль: ','class'=>'input-xlarge', 'placeholder'=>'Ваш пароль')); ?>
            
                     <label class="checkbox">
                        <?php echo $this->Form->input('auto_login', array('label'=> __('Оставаться в системе'), 'type'=>'checkbox')); ?>
                        
                     </label>
                    <?php echo $this->Form->submit(' Войти ',array('class'=>' btn btn-primary')); ?>
                    
                    <?php echo $this->Html->link(' Забыли пароль? ', array('controller' => 'users', 'action' => 'password_resend')); ?>
                    
                    |
                    
                    <?php echo $this->Html->link(' Регистрация ', array('controller' => 'users', 'action' => 'register')); ?>
                    
                    <?php echo $this->Form->end(); ?>
                            
            </div>
            <div class="span370">
                <h3>Вы можете войти как:</h3>
                 <div class="well">
                     <iframe src="http://loginza.ru/api/widget?overlay=loginza&token_url=<?php echo Configure::read('loginza.token_url');?>
                                    &providers_set=vkontakte,facebook,twitter,google" 
                             style="width:330px;height:210px;" scrolling="no" frameborder="no">
                    </iframe>
                 </div>   
            </div>
        </div>

           
            
                            
            
        
        

