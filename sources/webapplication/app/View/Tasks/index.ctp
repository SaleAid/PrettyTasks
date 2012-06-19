<?php $this->start ( 'toHead' );?>
    <?php echo $this->Html->css('tasks.'.Configure::read('App.version')); ?>
<?php $this->end ();?>

<?php $this->start ( 'toFooter' );?>
    
    <?php echo $this->Html->script('jquery.ui.touch-punch.min.js'); ?>
    
    <?php echo $this->Html->script('jquery.jgrowl.min.js'); ?>
    
    <?php echo $this->Html->script('jquery.jeditable.mini.js'); ?>
    
    <?php echo $this->Html->script('jquery.ba-hashchange.min.js'); ?>
    
    <?php echo $this->Html->script(array('jquery.timepicker-1.2.2','jquery.inline-confirmation'));?>
    <?php echo $this->Html->script('tasks.'.Configure::read('App.version'));?>
    
<?php $this->end ();?>


      <div id="main" class="tabbable tabs-left" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
            <li class="addDay">
            <div class="btn-group dropdown">
                <button  id="addDay" rel="tooltip" title="Добавить новый день в список" class="btn btn-large">Добавить день</button>
                <button class="btn btn-large dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu daysButton">
                    <li ><a href="#completed" data-toggle="tab" date="completed">Завершенные</a></li>
                    <li ><a href="#expired" data-toggle="tab" date="expired" class="tab2">Просроченные</a></li>
                    <li ><a href="#future" data-toggle="tab" date="future" class="tab2">Будущие</a></li>
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
            <li class="drop userDay"> <a href="#<?php echo $k;?>"
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
                <div class="input-append">
                    <input type="text" size="16" class="input-xxlarge createTask" placeholder=" +Добавить задание…"/><span class="add-on">?</span>
                </div>
                <button class="btn createTaskButton"> Добавить </button>    
            </div>
            <div class="filter">
                <span>Фильтр:&nbsp; </span> 
                <a href="" class="active" data="all">Все</a>
                <span class="all badge badge-info "><?php echo $result['data']['arrAllFutureCount']['all']; ?></span>,
                &nbsp;
                <a href=""  data="inProcess">В Процессе</a>
                <span class="inProcess badge badge-warning"><?php echo $result['data']['arrAllFutureCount']['all'] - $result['data']['arrAllFutureCount']['done']; ?></span>,
                &nbsp;
                <a href="" data="completed">Выполненные</a>
                <span class="completed badge badge-success"><?php echo $result['data']['arrAllFutureCount']['done']; ?></span>
            </div>
            <div class="clear"></div>
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
                    <h3 class="margin-bottom10">Просроченные задачи</h3>
                    <ul class="sortable connectedSortable ui-helper-reset " date="expired">
                    </ul>
                   </div>
              </div>
          </div>
          <div class="tab-pane" id="completed">
              <div class="row">
                  <div class="listTask">
                    <h3 class="margin-bottom10">Завершенные задачи</h3>
                    <ul class=" ui-helper-reset " date="completed">
                    </ul>
                    </div>
                </div>
          </div>
          <div class="tab-pane" id="future">
              <div class="row">
                  <div class="listTask">
                  <h3 class="margin-bottom10">Будущие задачи</h3>
                        <ul class="sortable connectedSortable ui-helper-reset " date="future">
                        </ul>
                    </div>
                </div>
          </div>
          <?php 
            foreach($result['data']['arrTaskOnDays'] as $k => $v):
            $weelDayStyle = '';
            if($k > $this->Time->format('Y-m-d', time())){
                $weelDayStyle = 'underline';
            }elseif($k < $this->Time->format('Y-m-d', time())){
                $weelDayStyle = 'italic';
            }
          ?>
            <div class="tab-pane <?php if($this->Time->isToday($k)):?>active<?php endif;?>" id="<?php echo $k; ?>" >
                <div class="row">
                    <div class="listTask">
                        <h3 class="label label-info margin-bottom10"><?php echo $k; ?> - <span class="<?php echo $weelDayStyle?>"><?php echo $weekday[$this->Time->format('l', $k, true)]; ?></span><img class="print" src="./img/print.png"/></h3>
                        <div class="well form-inline">
                            <div class="input-append">
                                <input type="text" size="16" class="input-xxlarge createTask" placeholder=" +Добавить задание…"/><span class="add-on">?</span>
                            </div>
                            <button class="btn createTaskButton"> Добавить </button>
                        </div>
                        <div class="filter">
                            <span>Фильтр:&nbsp; </span> 
                            <a href=""  class="active" data="all">Все</a>
                            <span class="all badge badge-info"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['all']; ?></span>,
                            &nbsp;
                            <a href=""  data="inProcess">В Процессе</a>
                            <span class="inProcess  badge badge-warning"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['all'] - $result['data']['arrTaskOnDaysCount'][$k]['done']; ?></span>,
                            &nbsp;
                            <a href=""  data="completed">Выполненные</a>
                            <span class="completed badge badge-success"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['done']; ?></span>
                            
                        </div>
                        <div class="days">
                            <a href="" data="commentDay">Комментарий</a>
                            <label class="checkbox ratingDay" >
                                <input type="checkbox" <?php if( isset($result['data']['arrDaysRating'][$k]) and $result['data']['arrDaysRating'][$k][0]['Day']['rating']):?> checked <?php endif; ?> date="<?php echo $k; ?>"/> Удачный день
                            </label>
                        </div>
                        <div class="clear"></div>
                        <ul id="sortable<?php echo $k; ?>" class="sortable connectedSortable ui-helper-reset" date="<?php echo $k; ?>">
                            <?php foreach($v as $item):?>
                                <li id ="<?php echo $item['Task']['id']; ?>" class=" <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['done']):?> complete <?php endif; ?><?php if($item['Task']['priority']):?>important<?php endif; ?>" date="<?php echo $item['Task']['date'];?>">
                                    <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                                    <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                                    <span><i class="icon-move"></i></span>
                                    <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                    <span class=" editable "><?php echo $item['Task']['title']; ?></span>
                                    <span class="editTask"><i class="icon-pencil"></i></span>
                                    <span class="deleteTask"><i class=" icon-ban-circle"></i></span>
                                </li>
                            <?php endforeach;?>
                            <div class ="alert alert-info">
                            <strong>О-о-о!</strong> Ты еще не добавил ни одной задачи. Не спи! Иди к успеху!<br/><br/><br/>
                            </div>
                        </ul>
                    </div>
                   
                </div>
            </div>
          <?php endforeach; ?>
          
    </div> <!-- /tabbable -->
    </div>  


<!-- modal editTask --!>
<div id="editTask" class="modal hide fade in" style="display: none;">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Редактирование задачи</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="span6 form-horizontal">
              <div class="control-group">
                <label class="control-label" for="eTitle">Title</label>
                <div class="controls">
                  <input type="text" class="span6" id="eTitle"/>
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
          <div class="row">
          
          <div class="span5">
              <div class="control-group">
                <label class="control-label" for="eComment">Comment</label>
                <div class="controls">
                  <textarea class="span4" id="eComment" rows="3"></textarea>
                </div>
              </div>
            </div>  
          <div class="priority span1 form-vertical">
          <div class="control-group">
            <label class="control-label">Priority</label>
            <div class="controls">
              <label class="radio">
                <input type="radio" name="priority" id="optionsRadios1" value="1" />
                High
              </label>
              <label class="radio">
                <input type="radio" name="priority" id="optionsRadios2" value="0"/>
                Normal
              </label>
            </div>
          </div>
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
            
          

        
        </div>
    </div>
</div>
    <div class="modal-footer">
        <button id="eSave" class="btn btn-success">Сохранить</button>
        <a href="" class="btn" data-dismiss="modal">Закрыть</a>
    </div>
</div>
<!-- End modal --!>

<!-- modal commentDay --!>
<div id="commentDay" class="modal hide fade in" style="display: none;">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Комментарий</h3>
    </div>
    <div class="modal-body">
      <form class="form-horizontal">
        <fieldset>
            <textarea  class="span6" id="eCommentDay" rows="4"></textarea>
        </fieldset>
      </form>
    </div>
    <div class="modal-footer">
        <button id="eCommentDaySave" class="btn btn-success">Сохранить</button>
        <a href="" class="btn" data-dismiss="modal">Закрыть</a>
    </div>
</div>
<!-- End modal --!>



