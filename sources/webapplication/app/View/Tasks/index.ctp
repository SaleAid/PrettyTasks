<?php $this->start ( 'toHead' );?>
<?php echo $this->Html->css('tasks');?>
<?php $this->end ();?>


      <div id="main" class="tabbable tabs-left" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs noPrint">
            <li class="addDay">
            <div class="btn-group dropup">
                <button  id="addDay" rel="tooltip" title="Добавить новый день в список" class="btn btn-large">Добавить день</button>
                <button class="btn btn-large dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li ><a href="#completed" data-toggle="tab" date="completed">Завершенные</a></li>
                    <li ><a href="#expired" data-toggle="tab" date="expired" class="tab2">Просроченные</a></li>
                    
                </ul>
            </div>   
           </li>
            <input type="hidden" id="dp"/>
            <li class="drop">
                <a href="#planned" data-toggle="tab" date="planned" class="tab2">Планируемые</a>
            </li>
            <li class="active drop">
                <a href="#<?php echo $this->Time->format('Y-m-d', time(), true); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                <?php echo __('today'); ?>
            </a>
          </li>
         <li class="drop">
            <a href="#<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                 <?php echo __('tomorrow'); ?>
            </a>
          </li>
          <?php 
          $weekday = array(
                        'Sunday' => __('Sunday'),
                        'Monday' => __('Monday'),
                        'Tuesday' => __('Tuesday'),
                        'Wednesday' => __('Wednesday'),
                        'Thursday' => __('Thursday'),
                        'Friday' => __('Friday'),
                        'Saturday' => __('Saturday')
                        );
          for($i = 2; $i <= 6; $i++):?>
            <li class="drop"> <a href="#<?php echo $this->Time->format('Y-m-d', '+'.$i.' days'); ?>"
                             data-toggle="tab"
                              date = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days'); ?>">
                      <?php echo $weekday[$this->Time->format('l', '+'.$i.' days', true)]; ?>
                 </a>
            </li>
          <?php endfor; ?>
          
          <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
          <?php if($k > $this->Time->format('Y-m-d', '+6 days') or $k < $this->Time->format('Y-m-d', time())):?>
            <li class="drop"> <a href="#<?php echo $k;?>"
                             data-toggle="tab"
                              date = "<?php echo $k; ?>">
                      <?php echo __($k); ?> <span class="close">×</span>
                 </a>
            </li>
            <?php endif;?>
          <?php endforeach; ?>
        </ul>
        <div class="tab-content" >
          <div class="tab-pane" id="planned">
          <div class="row">
          <div class="listTask">
            <h3 class="label label-info margin-bottom10">Задачи на будущие.</h3>
            <div class="well form-inline">
                <input type="text" class="input-xxlarge createTask" placeholder=" +Добавить задание…"/>
                <button class="btn createTaskButton"> Добавить </button>
            </div>
            <div class="filter">
                <span>Фильтр: </span> 
                <a href="" class="active" data="all">Все</a>,&nbsp; 
                <a href="" data="inProcess">В Процессе</a>,&nbsp; 
                <a href="" data="completed">Выполненные</a>
            </div>
            <ul class="sortable connectedSortable ui-helper-reset" date="planned">
                <?php if(isset($result['data']['arrAllFuture']) && !empty($result['data']['arrAllFuture'])):?>
                    <?php foreach($result['data']['arrAllFuture'] as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class=" <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['done']):?> complete <?php endif; ?> " date="<?php echo $item['Task']['date'];?>">
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                            <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                            <span><i class="icon-move"></i></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <span class="editable <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                            <span class="editTask"><i class="icon-pencil"></i></a></span>
                            <span class="deleteTask"><i class=" icon-ban-circle"></i></span>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>   
            </ul>
          </div>
          </div>
            </div>
          <div class="tab-pane" id="expired">
              <div class="row">
                  <div class="listTask">
                  <h3 class="margin-bottom10">Просроченные задачи.</h3>
                        <?php if(isset($result['data']['arrAllOverdue']) && !empty($result['data']['arrAllOverdue'])):?>
                        <ul class="sortable connectedSortable ui-helper-reset " date="expired">
                            <?php foreach($result['data']['arrAllOverdue'] as $datelabel => $day):
                                    if(isset($day) && !empty($day)):  
                            ?>
                                <h3 class="day label label-info margin-bottom10"><?php echo $datelabel; ?></h3>
                                    <? foreach($day as $item):?>
                                        <li id ="<?php echo $item['Task']['id']; ?>" class=" <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['priority']):?> important <?php endif; ?>" date="<?php echo $item['Task']['date'];?>">
                                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                                            <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                                            <span><i class="icon-move"> </i></span>
                                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                            <span class=" editable <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                                            <span class="editTask hide"><i class="icon-pencil"></i></a></span>
                                            <span class="deleteTask"><i class=" icon-ban-circle"></i></span>
                                        </li>
                             		<?php endforeach; ?>
                            <?php 
                                    endif;
                                endforeach;
                            ?>
                            </ul>
                        <?php endif;?>
                    </div>
                </div>
          </div>
          <div class="tab-pane" id="completed">
              <div class="row">
                  <div class="listTask">
                  <h3 class="margin-bottom10">Завершенные задачи.</h3>
                        <?php if(isset($result['data']['arrAllCompleted']) && !empty($result['data']['arrAllCompleted'])):?>
                        <ul class=" ui-helper-reset " date="completed">
                            <?php foreach($result['data']['arrAllCompleted'] as $datelabel => $day):
                                    if(isset($day) && !empty($day)):  
                            ?>
                                <h3 class="day label label-info margin-bottom10" rel="tooltip" title="Кликните для перехода <br/> на <?php echo $datelabel; ?>"><?php echo $datelabel; ?></h3>
                                	<? foreach($day as $item):?>
                                        <li class=" <?php if($item['Task']['priority']):?>important<?php endif; ?>">
                                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                                            <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                                            <span class="title"><?php echo $item['Task']['title']; ?></span>
                                        </li>
                             		<?php endforeach; ?>
                            <?php 
                                    endif;
                                endforeach;
                            ?>
                            </ul>
                        <?php endif;?>
                    </div>
                </div>
          </div>
          <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
            <div class="tab-pane <?php if($this->Time->isToday($k)):?>active<?php endif;?>" id="<?php echo $k; ?>" >
                <div class="row">
                    <div class="listTask">
                        <h3 class="label label-info margin-bottom10"><?php echo $k; ?><img class="print" src="./img/print.png"/></h3>
                        <div class="well form-inline noPrint">
                            <input type="text" class="createTask input-xxlarge" placeholder=" +Добавить задание…"/>
                            <img class="help" src="./img/help.gif" rel="tooltip" title="Help:  <br/> !	Priority"/>
                            <button class="btn createTaskButton"> Добавить </button>
                            <label class="checkbox ratingDay" >
                                <input type="checkbox" <?php if( isset($result['data']['arrDaysRating'][$k]) and $result['data']['arrDaysRating'][$k][0]['Day']['rating']):?> checked <?php endif; ?> date="<?php echo $k; ?>"/> Удачный день
                            </label>
                        </div>
                        <div class="filter">
                            <span>Фильтр: </span> 
                            <a href="" class="active" data="all">Все</a>,&nbsp; 
                            <a href="" data="inProcess">В Процессе</a>,&nbsp; 
                            <a href="" data="completed">Выполненные</a>
                        </div>
                        <ul id="sortable<?php echo $k; ?>" class="sortable connectedSortable ui-helper-reset" date="<?php echo $k; ?>">
                            <?php foreach($v as $item):?>
                                <li id ="<?php echo $item['Task']['id']; ?>" class=" <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['done']):?> complete <?php endif; ?><?php if($item['Task']['priority']):?>important<?php endif; ?>" date="<?php echo $item['Task']['date'];?>">
                                    <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                                    <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                                    <span><i class="icon-move"></i></span>
                                    <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                    <span class=" editable "><?php echo $item['Task']['title']; ?></span>
                                    <span class="editTask"><i class="icon-pencil"></i></a></span>
                                    <span class="deleteTask"><i class=" icon-ban-circle"></i></span>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                   
                </div>
            </div>
          <?php endforeach; ?>
          
    </div> <!-- /tabbable -->
    </div>  


<!-- modal --!>
<div id="editTask" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Редактирование задачи.</h3>
    </div>
    <div class="modal-body">
        <div class="row">
       
            <div class="span4">
               <form class="form-horizontal">
        <fieldset>
          
          <div class="control-group">
            <label class="control-label" for="eTitle">Title</label>
            <div class="controls">
              <input type="text" class="span3" id="eTitle"/>
            </div>
          </div>
          <div class="control-group form-inline">
            <label class="control-label" for="eDate">Date, time?</label>
            <div class="controls">
                <input type="text"  id="eDate"/>
                <input type="text"  id="eTime"/>
                <label>to</label>
                <input type="text"  id="eTimeEnd"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="eComment">Comment</label>
            <div class="controls">
              <textarea class="span3" id="eComment" rows="3"></textarea>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" id="eDone" value="option1"/>
                Done
              </label>
            </div>
          </div>
        </fieldset>
      </form>
            </div>
            <div class="span2">
            
            </div>
            
        </div>
    </div>
    <div class="modal-footer">
    
        <button id="eSave" class="btn btn-success">Сохранить</button>
        <a href="" class="btn" data-dismiss="modal">Закрыть</a>
    </div>
</div>
<!-- End modal --!>



