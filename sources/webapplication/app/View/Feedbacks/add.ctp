<div id="itemsbox">
<div class="feedbacks form">
<?php echo $this->Form->create('Feedback');?>
	<fieldset>
 		<legend><?php echo __('Сообщение разработчикам', true); ?></legend>
	<?php
		echo $this->Form->input('email', array('label' => __('Емейл', true)));
		echo $this->Form->input('name', array('label' => __('Имя', true)));
		echo $this->Form->input('subject', array('label' => __('Тема', true)));
		echo $this->Form->input('message', array('label' => __('Сообщение', true)));
	?>
	</fieldset>
    <br class="clear"/> 
<?php echo $this->Form->end(__('Отправить', true));?>
</div>
<div class="box">
                    <div class="note">
                        <h4>Сообщение</h4>
                        <p>Ваше мнение очень важно для нас. <br/>Пожалуйста, опишите Вашу просьбу, проблему как можно более подробно, чтобы мы могли быстрее и полнее ее проработать. <br/> Спасибо за сотрудничество. <br/>Мы делаем все, чтобы наши продукты приносили Вам наибольшую пользу и комфорт.</p>
                        <p>Также вы можете найти ответы на наиболее распостраненные вопросы в разделе <? echo $this->Html->link('Faq', array('controller' => 'faqs', 'action' => 'index')); ?>. </p>
        
                    </div>
</div>
</div>
