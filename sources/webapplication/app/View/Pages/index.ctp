
<div class="">
  <img  src="/img/start.gif"/>
</div>
<div class="row">
				<div class="span4 box left">
					<div class="box_header">
                        <h1 align="center"><?php echo __('Готовься');?></h1> 
                    </div>
					<div class="box_container">
                        <h2></h2>
                        <ul class="thumbnails">
                          <li class="">
                            <a href="#" class="thumbnail">
                              <img style="margin:0" src="http://placehold.it/300x200" alt=""/>
                            </a>
                          </li>
                        </ul>
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
                        <h2></h2>
                        <ul class="thumbnails">
                          <li class="">
                            <a href="#" class="thumbnail">
                              <img style="margin:0" src="http://placehold.it/300x200" alt="">
                            </a>
                          </li>
                        </ul>
                        <p>
                            Важнее всего иметь цель. Хорошо поставленная цель, это пол дела. 
                            Мы поможем тебе ставить цели и задачи. 
                            Ниочем не забывать, и держать руку на пульсе с любого места нашей планеты.
    					</p>
                    </div>
				</div>

				<div class="span4 box right">
					<div class="box_header">
					   <h1 align="center"><?php echo __('Пли!');?></h1>
                    </div>
                    <div class="box_container">  
                        <h2></h2> 
                        <ul class="thumbnails">
                          <li class="">
                            <a href="#" class="thumbnail">
                              <img style="margin:0" src="http://placehold.it/300x200" alt="">
                            </a>
                          </li>
                        </ul>
                        <p> Пора действовать!</p>
                        <p> Отбрось страхи, ты все сможешь!</p>
                        <p> 
                            Доверься интуиции и жми
                            <?php echo $this->Html->link(__('Пли!'),array('controller' => 'users', 'action' => 'login'),array('class'=> 'btn btn-primary')); ?>
                        </p>
                    </div>
				</div>

				
			</div>