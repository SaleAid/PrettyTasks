<?php $this->start ( 'toHead' );?>
    <?php echo $this->Html->css('feedbacks.'.Configure::read('App.version')); ?>
<?php $this->end ();?>
<?php $this->start ( 'toFooter' );?>
    <?php echo $this->Html->script('feedbacks.'.Configure::read('App.version')); ?>
<?php $this->end ();?>

<div class="row">

<div class="span7 feedbacks form well">
<?php echo $this->Form->create('Feedback');?>
	<fieldset>
 		<legend><?php echo __('Сообщение разработчикам', true); ?></legend>
        <div class="btn-group categories" data-toggle="buttons-radio">
          <button type="button" value="idea" class="btn btn-primary">Идея</button>
          <button type="button" value="problem" class="btn btn-primary">Проблема</button>
          <button type="button" value="question" class="btn btn-primary">Вопрос</button>
          <button type="button" value="testimonial" class="btn btn-primary">Благодарность</button>
        </div>
     
	<?php
        echo $this->Form->input('category', array('label' => false, 'type' =>'hidden', 'class' =>'category', 'error' => false ));
		echo $this->Form->input('subject', array('label' => __('Тема', true), 'class' =>'span7', 'error' => false ));
		echo $this->Form->input('message', array('label' => __('Сообщение', true), 'class' =>'span7', 'error' => false ));
	?>
	</fieldset>
    <br class="clear"/> 
<?php echo $this->Form->end(__('Отправить', true));?>
</div>
<div class="span4 message">
                    <div class="note">
                        <h3>Сообщение</h3>
                        <p>Ваше мнение очень важно для нас. <br/>Пожалуйста, опишите Вашу просьбу, проблему как можно более подробно, чтобы мы могли быстрее и полнее ее проработать. <br/> Спасибо за сотрудничество. <br/>Мы делаем все, чтобы наши продукты приносили Вам наибольшую пользу и комфорт.</p>
                        <p>Также вы можете найти ответы на наиболее распостраненные вопросы в разделе <? echo $this->Html->link('Faq', array('controller' => 'faqs', 'action' => 'index')); ?>. </p>
        
                    </div>
</div>
</div>
