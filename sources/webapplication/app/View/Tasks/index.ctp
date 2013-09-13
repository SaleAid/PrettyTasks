<?php
    if( Configure::read('App.Minify.css') ){
        echo $this->Html->css('min/tasks.' . Configure::read('App.version'), null, array('block' => 'toHead'));
    }else{
       echo $this->Html->css('main.' . Configure::read('App.version'), null, array('block' => 'toHead')); 
       echo $this->Html->css('jquery.jgrowl.'.Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('print.' . Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->html->css('jquery.timepicker-1.2.2', null, array('block' => 'toHead'));
       echo $this->Html->css('tasks.'. Configure::read('App.version'), null, array('block' => 'toHead'));
       echo $this->Html->css('ui-lightness/jquery-ui-1.8.18.custom', null, array('block' => 'toHead'));
       //echo $this->Html->css('jquery.mCustomScrollbar', null, array('block' => 'toHead'));
       //echo $this->Html->css('bootstrap-modal', null, array('block' => 'toHead'));
       
    }
    
    if( Configure::read('App.Minify.js') ){
        echo $this->Html->script('min/tasks.' . Configure::read('App.version'), array('block' => 'toFooter'));
    }else{
       echo $this->Html->script(array(
            'jquery.cookie',
            'jquery.jgrowl.min',
            'jquery.jeditable.mini',
            'jquery.ba-hashchange.min',
            'jquery.timepicker-1.2.2.min',
            'jquery.inline-confirmation.'.Configure::read('App.version'),
            'jquery-ui-i18n.min',
            //'jquery.mCustomScrollbar.concat.min'
            //'bootstrap-modalmanager',
            //'bootstrap-modal'
       ), array('block' => 'toFooter'));
       echo $this->Html->script('main.' . Configure::read('App.version'), array('block' => 'toFooter')); 
       echo $this->Html->script('print.'.Configure::read('App.version'), array('block' => 'toFooter'));
       echo $this->Html->script('tasks.' . Configure::read('App.version'), array('block' => 'toFooter'));
       
    }
?>

<div id="main" class="tabbable tabs-left" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs listDay affix1 dthl" >
            <li class="hide"><a href="#lists" data-toggle="tab" date="lists"><?php echo __d('tasks', 'Lists'); ?></a></li>
            <li class="hide"><a href="#list" data-toggle="tab" date="list"><?php echo __d('tasks', 'List'); ?></a></li>
            <li class="addDay">
            <div class="btn-group">
                <button  id="addDay" rel="tooltip" title="<?php echo __d('tasks', 'Добавить новый день в список'); ?>" class="btn btn-block btn-large"><?php echo __d('tasks', 'Добавить день'); ?></button>
            </div>   
           </li>
            <input type="hidden" id="dp"/>
            
            <li class="drop ">
                <span class="btn-group">
                    <span class="dropdown-toggle s4 pull-right" data-toggle="dropdown" data-target="#"><span class="caret"></span></span>
                        <ul class="dropdown-menu daysButton s5">
                            <li ><a href="#expired" data-toggle="tab"  date="expired" class="tab2"><?php echo __d('tasks', 'Просроченные'); ?></a></li>
                            <li ><a href="#completed" data-toggle="tab" date="completed"><?php echo __d('tasks', 'Завершенные'); ?></a></li>
                            <li ><a href="#future" data-toggle="tab" date="future" class="tab2"><?php echo __d('tasks', 'Будущие'); ?></a></li>
                            <li ><a href="#continued" data-toggle="tab" date="continued" class="tab2"><?php echo __d('tasks', 'Длительные'); ?></a></li>
                            <li class="divider"></li>
                            <li ><a href="#deleted" data-toggle="tab" date="deleted" class="tab2"><?php echo __d('tasks', 'Удаленные'); ?></a></li>
                       </ul>
                 </span>
                <a href="#planned" data-toggle="tab" date="planned" class="tab2 "><?php echo __d('tasks', 'Планируемые'); ?></a>
            </li>
          <?php if ( $result['data']['inConfig'] or $result['data']['yesterdayDisp']  ): ?>
          <li class="drop">
            <a href="#<?php echo $this->Time->format('Y-m-d', '-1 days', true, $timezone) ; ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', '-1 days', true, $timezone); ?>">
                 <?php echo __d('tasks', 'Yesterday'); ?>
                 <span class="close">×</span>
            </a>
          </li>
          <?php endif;?>
            <li class="active drop">
                <a href="#<?php echo $this->Time->format('Y-m-d', time(), true, $timezone); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', time(), true, $timezone); ?>">
                <?php echo __d('tasks', 'Today'); ?>
            </a>
          </li>
         <li class="drop">
            <a href="#<?php echo $this->Time->format('Y-m-d', '+1 days', true, $timezone); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', '+1 days', true, $timezone); ?>">
                 <?php echo __d('tasks', 'Tomorrow'); ?>
            </a>
          </li>
          <?php 
          $weekday = array(
                        'Sunday' => __d('tasks', 'Sunday'),
                        'Monday' => __d('tasks', 'Monday'),
                        'Tuesday' => __d('tasks', 'Tuesday'),
                        'Wednesday' => __d('tasks', 'Wednesday'),
                        'Thursday' => __d('tasks', 'Thursday'),
                        'Friday' => __d('tasks', 'Friday'),
                        'Saturday' => __d('tasks', 'Saturday')
                        );
          for($i = 2; $i <= 6; $i++):?>
            <li class="drop"> <a href="#<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true, $timezone); ?>"
                             data-toggle="tab"
                              date = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true, $timezone); ?>">
                      <?php echo $weekday[$this->Time->format('l', '+'.$i.' days', true, $timezone)]; ?>
                 </a>
            </li>
          <?php endfor; ?>
          
          <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
          <?php if($k > $this->Time->format('Y-m-d', '+6 days', true, $timezone) or 
                    $k < $this->Time->format('Y-m-d', '-1 days', true, $timezone) and !$this->Time->wasYesterday($k, $timezone) 
                    //or ($this->Time->wasYesterday($k) and !$result['data']['yesterdayDisp'] and $result['data']['inConfig'])
                    ):?>
            <li class="drop userDay"> <a href="#<?php echo $k;?>"
                             data-toggle="tab"
                              date = "<?php echo $k; ?>">
                      <?php echo __d('tasks', $k); ?> <span class="close">×</span>
                 </a>
            </li>
            <?php endif;?>
          <?php endforeach; ?>
        </ul>
        <div class="tab-content " >
          <div class="tab-pane" id="planned">
          <div class="row">
          <div class="listTask">
            <div class="margin-bottom10">
                <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                <h3 class="head-list-info"><?php echo __d('tasks', 'Задачи на будущее'); ?></h3>
            </div>
            <div class="well form-inline">
                <div class="input-append">
                    <input type="text" size="16" class="input-xxlarge createTask" placeholder="<?php echo __d('tasks', '+Добавить задание…'); ?>"/>
                    <button class="btn createTaskButton"><?php echo __d('tasks', 'Добавить'); ?></button>
                </div>
            </div>
            <div class="filter">
                <span><?php echo __d('tasks', 'Фильтр'); ?>:&nbsp; </span> 
                <a href="" class="active" data="all"><?php echo __d('tasks', 'Все'); ?></a>
                <span class="all badge badge-info "><?php echo $result['data']['arrAllFutureCount']['all']; ?></span>,
                &nbsp;
                <a href=""  data="inProcess"><?php echo __d('tasks', 'В Процессе'); ?></a>
                <span class="inProcess badge badge-warning"><?php echo $result['data']['arrAllFutureCount']['all'] - $result['data']['arrAllFutureCount']['done']; ?></span>,
                &nbsp;
                <a href="" data="completed"><?php echo __d('tasks', 'Выполненные'); ?></a>
                <span class="completed badge badge-success"><?php echo $result['data']['arrAllFutureCount']['done']; ?></span>
            </div>
            <div class="clear"></div>
            <ul class="sortable connectedSortable ui-helper-reset filtered dthl" date="planned" data-refresh="1">
                <?php if(isset($result['data']['arrAllFuture']) && !empty($result['data']['arrAllFuture'])):?>
                    <?php foreach($result['data']['arrAllFuture'] as $item):?>
                        <?php echo $this->Task->taskLi($item);?>
                    <?php endforeach;?>
                <?php endif;?>   
            </ul>
            <?php echo $this->element('empty_lists', array('type' => 'planned', 'hide' => $result['data']['arrAllFutureCount']['all']));?>           
          </div>
          </div>
            </div>
          <div class="tab-pane" id="expired">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><?php echo __d('tasks', 'Просроченные задачи'); ?></h3>
                  </div>
                    <ul class="sortable connectedSortable ui-helper-reset dthl" date="expired" data-refresh="1">
                    </ul>
                    <?php echo $this->element('empty_lists', array('type' => 'overdue', 'hide' => true));?>
                   </div>
              </div>
          </div>
          <div class="tab-pane" id="completed">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><?php echo __d('tasks', 'Завершенные задачи'); ?></h3>
                  </div>
                    <ul class=" ui-helper-reset " date="completed" data-refresh="1">
                    </ul>
                    <?php echo $this->element('empty_lists', array('type' => 'completed', 'hide' => true));?>
                  </div>
                </div>
          </div>
          <div class="tab-pane" id="continued">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><?php echo __d('tasks', 'Длительные задачи'); ?></h3>
                  </div>
                    <ul class="sortable connectedSortable ui-helper-reset dthl" date="continued" data-refresh="1">
                    </ul>
                    <?php echo $this->element('empty_lists', array('type' => 'continued', 'hide' => true));?>
                  </div>
                </div>
          </div>
          <div class="tab-pane" id="deleted">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <button class="btn btn-small btn-danger pull-right delete_all" type="button"><?php echo __d('tasks', 'Удалить все');?></button>
                    <h3 class="head-list-info">
                        <?php echo __d('tasks', 'Удаленные задачи'); ?>&nbsp;
                        <!--(<?php echo $this->Form->postLink(__d('tasks', 'Удалить окончательно'), array('action' => 'deleteAllDetetedTasks'),  array('class' => 'delete-all'), __d( 'tasks', 'Are you sure you want to delete all tasks?')); ?>)
                    
                    --></h3>
                  </div>
                    <ul class="sortable connectedSortable ui-helper-reset dthl" date="deleted" data-refresh="1">
                    </ul>
                    <?php echo $this->element('empty_lists', array('type' => 'deleted', 'hide' => true));?>
                  </div>
                </div>
          </div>
          <div class="tab-pane" id="future">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><?php echo __d('tasks', 'Будущие задачи'); ?></h3>
                  </div>
                        <ul class="sortable connectedSortable ui-helper-reset dthl" date="future" data-refresh="1">
                        </ul>
                        <?php echo $this->element('empty_lists', array('type' => 'future', 'hide' => true));?>
                    </div>
                </div>
          </div>
          <div class="tab-pane" id="lists">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><span class="tag-name"><?php echo __d('tasks', 'Списки'); ?></span></h3>
                  </div>
                  <div class="well form-inline">
                  <div class="input-append">
                        <input type="text" size="16" class="input-xxlarge createList" placeholder="<?php echo __d('tasks', '+Добавить список…'); ?>"/>
                        <button class="btn createListButton"><?php echo __d('tasks', 'Добавить'); ?></button>
                    </div>
                 </div>
                        <div class="clear"></div>
                        <ul class="lists-ul" date="lists">
                        </ul>
                        <div class="clear"></div>
                        <div class="lists-archive">
                            <span class="lists-title">
                                <?php echo __d('tasks', 'Архив'); ?>
                            </span>
                            <ul></ul>
                        </div>
                        <?php echo $this->element('empty_lists', array('type' => 'lists', 'hide' => true));?>
                    </div>
                </div>
          </div>
          <div class="tab-pane" id="list">
              <div class="row">
                  <div class="listTask">
                  <div class="margin-bottom10">
                    <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                    <h3 class="head-list-info"><span class="tag-name"><?php echo __d('tasks', 'Lists'); ?></span></h3>
                  </div>
                        <div class="well form-inline">
                            <div class="input-append">
                                <input type="text" size="16" class="input-xxlarge createTask" placeholder="<?php echo __d('tasks', '+Добавить задание…'); ?>"/>
                                <button class="btn createTaskButton"><?php echo __d('tasks', 'Добавить'); ?></button>
                            </div>
                            
                        </div>
                        <div class="filter">
                            <span><?php echo __d('tasks', 'Фильтр'); ?>:&nbsp; </span> 
                            <a href=""  class="active" data="all"><?php echo __d('tasks', 'Все');?></a>
                            <span class="all badge badge-info">0</span>,
                            &nbsp;
                            <a href=""  data="inProcess"><?php echo __d('tasks', 'В Процессе'); ?></a>
                            <span class="inProcess  badge badge-warning">0</span>,
                            &nbsp;
                            <a href=""  data="completed"><?php echo __d('tasks', 'Выполненные'); ?></a>
                            <span class="completed badge badge-success">0</span>
                            
                        </div>
                        <div class="days">
                            <a href="" data="commentTag"><?php echo __d('tasks', 'Комментарий'); ?></a>
                        </div>
                        <div class="clear"></div>
                        <ul class="sortable connectedSortable ui-helper-reset filtered dthl" date="list" data-refresh="1">
                        </ul>
                        <?php echo $this->element('empty_lists', array('type' => 'future', 'hide' => true));?>
                    </div>
                </div>
          </div>
          <?php 
            foreach($result['data']['arrTaskOnDays'] as $k => $v):
                $weelDayStyle = '';
                $type = 'today';
                if($k > $this->Time->format('Y-m-d', time(), true, $timezone)){
                    $weelDayStyle = 'future';
                    $type = 'future';
                }elseif($k < $this->Time->format('Y-m-d', time(), true, $timezone)){
                    $weelDayStyle = 'past';
                    $type = 'past';
                }
                //if(($this->Time->wasYesterday($k) and !$result['data']['yesterdayDisp'] and !$result['data']['inConfig'])){
//                    continue;
//                }
          ?>
            <div class="tab-pane <?php if($this->Time->isToday($k, $timezone)):?>active<?php endif;?>" id="<?php echo $k; ?>" >
                <div class="row">
                    <div class="listTask">
                        <div class="margin-bottom10">
                            <?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?>
                            <h3 class="head-list-info" ><?php echo $k; ?> - <span class="<?php echo $weelDayStyle?>"><?php echo $weekday[$this->Time->format('l', $k, true, $timezone)]; ?></span><?php if($this->Time->isToday($k, $timezone)):?> - <span id="clock"></span><?php endif;?></h3>
                        </div>
                        <div class="well form-inline">
                            <div class="input-append">
                                <input type="text" size="16" class="input-xxlarge createTask" placeholder="<?php echo __d('tasks', '+Добавить задание…'); ?>"/>
                                <button class="btn createTaskButton"><?php echo __d('tasks', 'Добавить'); ?></button>
                            </div>
                        </div>
                        <div class="filter">
                            <span><?php echo __d('tasks', 'Фильтр'); ?>:&nbsp; </span> 
                            <a href=""  class="active" data="all"><?php echo __d('tasks', 'Все');?></a>
                            <span class="all badge badge-info"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['all']; ?></span>,
                            &nbsp;
                            <a href=""  data="inProcess"><?php echo __d('tasks', 'В Процессе'); ?></a>
                            <span class="inProcess  badge badge-warning"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['all'] - $result['data']['arrTaskOnDaysCount'][$k]['done']; ?></span>,
                            &nbsp;
                            <a href=""  data="completed"><?php echo __d('tasks', 'Выполненные'); ?></a>
                            <span class="completed badge badge-success"><?php echo $result['data']['arrTaskOnDaysCount'][$k]['done']; ?></span>
                            
                        </div>
                        <div class="days">
                            <a href="" data="commentDay"><?php echo __d('tasks', 'Комментарий'); ?></a>
                            <label class="checkbox ratingDay" >
                                <input type="checkbox" <?php if( isset($result['data']['arrDaysRating'][$k]) and $result['data']['arrDaysRating'][$k][0]['Day']['rating']):?> checked <?php endif; ?> date="<?php echo $k; ?>"/> <?php echo __d('tasks', 'Удачный день'); ?>
                            </label>
                        </div>
                        <div class="clear"></div>
                        <ul id="sortable-<?php echo $k; ?>" class="sortable connectedSortable ui-helper-reset filtered dthl" date="<?php echo $k; ?>" data-refresh="0">
                            <?php foreach($v as $item):?>
                                <?php echo $this->Task->taskLi($item);?>
                            <?php endforeach;?>
                        </ul>
                        <?php echo $this->element('empty_lists', array('type' => $type, 'hide' => $result['data']['arrTaskOnDaysCount'][$k]['all']));?>
                    </div>
                   
                </div>
            </div>
          <?php endforeach; ?>
          
    </div> <!-- /tabbable -->
    </div>  


<?php echo $this->element('edit_task', array(), array('cache' => array('key' => 'edit_task', 'config' => 'elements'))); ?>
<?php //echo $this->element('repeat_task', array(), array('cache' => array('key' => 'repeat_task', 'config' => 'elements'))); ?>

<?php echo $this->element('comment_day', array(), array('cache' => array('key' => 'comment_day', 'config' => 'elements'))); ?>

<!-- print_brand -->
<?php echo $this->Html->image("brand.". Configure::read('App.version') .".png", array('class' => 'print_brand', 'width' => 156, 'height' => 30)); ?>

<!-- empty list messages  -->
<?php echo $this->element('empty_lists', array('type' => 'filterProgress', 'hide' => true));?>
<?php echo $this->element('empty_lists', array('type' => 'filterCompleted', 'hide' => true));?>

<?php echo $this->element('connection_error', array(), array('cache' => array('key' => 'connection_error', 'config' => 'elements'))); ?>

<!-- Templates -->
<script type="text/template" id="day_tab_content_template">
    <div class="tab-pane" id="<%= date %>"> 
	<div class="row">  
		<div class="listTask"> 
			<div class="margin-bottom10"> 
				<?php echo $this->Html->image("print.". Configure::read('App.version') .".png", array("alt" => "Print", 'class' => 'print', 'width' => 16, 'height' => 16)); ?> 
				<h3 class="head-list-info"><%= date %><span class="weekday"></span></h3> 
			</div>
			<div class="well form-inline"> 
				<div class="input-append"> 
					<input type="text" size="16" class="input-xxlarge createTask" placeholder="<?php echo __d('tasks', '+Добавить задание…'); ?>"/>
                    <button class="btn createTaskButton"><?php echo __d('tasks', 'Добавить'); ?></button>    
				</div>
			</div>
			<div class="filter"> 
				<span><?php echo __d('tasks', 'Фильтр'); ?>:&nbsp; </span> 
                <a href=""  class="active" data="all"><?php echo __d('tasks', 'Все');?></a>
				<span class="all badge badge-info"> 
					0
				</span>,
				&nbsp; 
				<a href=""  data="inProcess"><?php echo __d('tasks', 'В Процессе'); ?></a>
				<span class="inProcess badge badge-warning"> 
					0
				</span>,
				&nbsp; 
				<a href=""  data="completed"><?php echo __d('tasks', 'Выполненные'); ?></a>
				<span class="completed badge badge-success"> 
					0
				</span>
			</div>
			<div class="days"> 
				<a href="" data="commentDay"><?php echo __d('tasks', 'Комментарий'); ?></a>
				<label class="checkbox ratingDay"> 
					<input type="checkbox" date="<%= date %>"/> <?php echo __d('tasks', 'Удачный день'); ?> 
				</label>
			</div>
			<div class="clear"></div>
			<ul class="sortable connectedSortable ui-helper-reset filtered dthl" date="<%= date %>" data-refresh="0"> 
				<p class="loadContent" align=center>
                    <?php echo $this->Html->image("ajax-loader-content.". Configure::read('App.version') .".gif"); ?>
                </p>
			</ul>
            
		</div>
	</div>
</div>
</script>

<script type="text/template" id="ajax_loader_content">
    <p class="loadContent" align=center>
        <?php echo $this->Html->image("ajax-loader-content.". Configure::read('App.version') .".gif"); ?>
    </p>
</script>


<script type="text/template" id="day_h3_label">
    <h3 class="day label label-info margin-bottom10" rel="tooltip" date="<%= date %>" title="<?php echo __d('tasks', 'Кликните для перехода на'); ?>&nbsp;<%= date %>">
	   <span class="dayDate"><%= date %></span><span class="dash"> - </span><span class="<%= weekDayStyle %>"><%= weekDay %></span>
    </h3>
</script>

<script type="text/template" id="empty_list_day_tasks">
    <% if ( type == "past") { %>
        <?php echo $this->element('empty_lists', array('type' => 'past', 'hide' => true));?>
    <% } else { %>
        <?php echo $this->element('empty_lists', array('type' => 'future', 'hide' => true));?>
    <% }  %>
</script>

<script type="text/template" id="task_tag">
        <?php echo $this->Task->taskLiTag();?>
</script>
<script type="text/template" id="add_task">
        <?php echo $this->Task->addTaskLi();?>
</script>