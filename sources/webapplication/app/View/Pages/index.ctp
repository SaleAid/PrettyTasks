
<div class="start">
  <?php echo $this->Html->image('comics.'. Configure::read('App.version') .'.jpg', array('width' => 970, 'height' =>355)); ?>
</div>
<div class="row">
	<div class="span4 box left">
		<div class="box_header">
            <h1 align="center"><?php echo __('Готовься');?></h1> 
        </div>
		<div class="box_container">
            <p>
                Привет! Скроее всего ты человек, который стремится к лучшему. 
                Иногда трудно себя заставить что-то делать, иногда ты о чем-то забываешь. 
                <strong>Приготовься!</strong> Этот сервис то, что тебе нужно.
		   </p>
        </div>
	</div>
	<div class="span4 box center">
		<div class="box_header">
		   <h1 align="center"><?php echo __('Целься');?></h1>
        </div>   
        <div class="box_container">
            <p>
                Важнее всего иметь цель. Хорошо поставленная цель, это пол дела. 
                Мы поможем тебе ставить цели и задачи. 
                Ни о чем не забывать, и держать руку на пульсе с любого места нашей планеты.
			</p>
        </div>
	</div>
	<div class="span4 box right">
		<div class="box_header">
		   <h1 align="center"><?php echo __('Пли!');?></h1>
        </div>
        <div class="box_container">  
            <p> Пора действовать!</p>
            <p> Отбрось страхи, ты все сможешь!</p>
            <p> 
                Доверься интуиции и жми
               
            </p>
             <?php //echo $this->Html->link(__('Пли!'),array('controller' => 'users', 'action' => 'login'),array('class'=> 'btn btn-success btn-large go')); ?>
             <?php echo $this->Html->link(__('Пли!'),array('controller' => 'users', 'action' => 'login'),array('class'=> 'btn btn-large btn-block btn btn-success')); ?>
        </div>
	</div>
</div>
            