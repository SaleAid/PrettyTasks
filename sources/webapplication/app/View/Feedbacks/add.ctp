<?php echo $this->Html->css('feedbacks.'.Configure::read('App.version'), null, array('block' => 'toHead')); ?>
<?php echo $this->Html->script('feedbacks.'.Configure::read('App.version'), array('block' => 'toFooter')); ?>
<?php App::uses('Feedback', 'Model');?>
<div class="row">
    <div class="span8 feedbacks">
    <?php echo $this->Form->create('Feedback', array('class' => 'well',
                                                'inputDefaults' => array(
                                                'div' => array('class' => 'control-group'),
                                                'label' => array('class' => 'control-label'),
                                                'between' => '<div class="controls">',
                                                'after' => '</div>',
                                                'class' => '')
        )); ?>
    	<fieldset>
     		<legend><?php echo __d('feedbacks', 'Сообщение разработчикам'); ?></legend>
            <div class="btn-group categories" data-toggle="buttons-radio">
              <button type="button" value="idea" class="btn btn-primary"><?php echo __d('feedbacks', 'Идея'); ?></button>
              <button type="button" value="problem" class="btn btn-primary"><?php echo __d('feedbacks', 'Проблема'); ?></button>
              <button type="button" value="question" class="btn btn-primary active"><?php echo __d('feedbacks', 'Вопрос'); ?></button>
              <button type="button" value="testimonial" class="btn btn-primary"><?php echo __d('feedbacks', 'Благодарность'); ?></button>
            </div>
         
    	<?php
            echo $this->Form->input('category', array('label' => false, 'type' => 'hidden', 'class' => 'category', 'error' => false ));
    		echo $this->Form->input('subject', array('label' => __d('feedbacks', 'Тема'), 'class' => 'span7', 'error' => array('attributes' => array('class' => 'controls help-block')) ));
    		echo $this->Form->input('message', array('label' => __d('feedbacks', 'Сообщение'), 'class' => 'span7', 'error' => array('attributes' => array('class' => 'controls help-block')) ));
    	?>
    	<?php echo $this->Form->submit(__d('feedbacks', 'Отправить'), array('class' => 'btn btn-info')); ?>
        </fieldset>
         
    <?php echo $this->Form->end(); ?>
    </div>
    <div class="span4 message">
        <div class="note">
            <h3><?php echo __d('feedbacks', 'Сообщение'); ?></h3>
            <p><?php echo __d('feedbacks', 'Ваше мнение очень важно для нас.'); ?><br/>
            <?php echo __d('feedbacks', 'Пожалуйста, опишите Вашу просьбу, проблему как можно более подробно, чтобы мы могли быстрее и полнее ее проработать.'); ?><br/>
            <?php echo __d('feedbacks', 'Спасибо за сотрудничество.'); ?><br/>
            <?php echo __d('feedbacks', 'Мы делаем все, чтобы наш сервис приносил Вам наибольшую пользу и комфорт.'); ?></p>
            <!--  <p>Также вы можете найти ответы на наиболее распостраненные вопросы в разделе <?php //echo $this->Html->link('Faq', array('controller' => 'faqs', 'action' => 'index')); ?>. </p> -->
        </div>
    </div>
</div>
