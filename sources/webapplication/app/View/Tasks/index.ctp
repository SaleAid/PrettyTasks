
<div class="row">
    <div class="span12">
      <div id="main" class="tabbable tabs-left" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
 <!-- 
           <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span id="addDay">select day </span>   <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li ><a id="addDay1" class="addDay">Add Day</a></li>
                  
                </ul>
              </li>
               -->
           
            <li ><a id="addDay" class="addDay">Add Day</a></li>
            <input type="hidden" id="dp"/>
            <hr />
            <li ><a href="#expired" data-toggle="tab" date="expired" class="tab2">Просроченные</a></li>
            <li class="drop">
                <a href="#future" data-toggle="tab" date="future" class="tab2">Будущее</a>
            </li>
            <li class="active drop">
                <a href="#<?php echo $this->Time->format('Y-m-d', time(), true); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                <?php echo __('Сегодня'); ?>
            </a>
          </li>
         <li class="drop">
            <a href="#<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                 <?php echo __('Завтра'); ?>
            </a>
          </li>
          <?php for($i = 2; $i <= 5; $i++):?>
            <li class="drop"> <a href="#<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>"
                             data-toggle="tab"
                              date = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                      <?php echo __($this->Time->format('l', '+'.$i.' days', true)); ?>
                 </a>
            </li>
          <?php endfor; ?>
          
          <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
          <?php if($k > $this->Time->format('Y-m-d', '+7 days') or $k < $this->Time->format('Y-m-d', time())):?>
            <li class="drop"> <a href="#<?php echo $k; ?>"
                             data-toggle="tab"
                              date = "<?php echo $k; ?>">
                      <?php echo __($k); ?> <span class="close">×</span>
                 </a>
            </li>
            <?php endif;?>
          <?php endforeach; ?>
        </ul>
        <div class="tab-content" >
          <div class="tab-pane" id="future">
          <div class="row">
          <div class="span10">
           <div class="well form-inline">
                <input type="text" class="input-xxlarge" placeholder=" +Добавить задание…"/>
             </div>
            <hr />
            <ul class="sortable connectedSortable ui-helper-reset" date="future">
                <?php if(isset($result['data']['arrAllFuture']) && !empty($result['data']['arrAllFuture'])):?>
                    <?php foreach($result['data']['arrAllFuture'] as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['done']):?> complete <?php endif; ?> " date="<?php echo $item['Task']['date'];?>">
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                            <span><i class="icon-move"></i></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <span class="editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
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
          <div class="span8">
            <hr />
                <?php if(isset($result['data']['arrAllExpired']) && !empty($result['data']['arrAllExpired'])):?>
                <ul class="sortable connectedSortable ui-helper-reset " date="expired">
                    <?php foreach($result['data']['arrAllExpired'] as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['priority']):?> important <?php endif; ?>" date="<?php echo $item['Task']['date'];?>">
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                            <span><i class="icon-move"> </i></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <span class=" editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                            <span class="deleteTask"><i class=" icon-ban-circle"></i></span>
                        </li>
                    <?php endforeach;?>
                    </ul>
                <?php endif;?>
        </div>
        </div>
          </div>
          <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
            <div class="tab-pane <?php if($this->Time->isToday($k)):?>active<?php endif;?>" id="<?php echo $k; ?>" >
                <div class="row">
                    <div class="span10">
                        <p class="tabDay"><?php echo $k; ?></p>
                        <div class="well form-inline">
                            <input type="text" class="createTask input-xxlarge" placeholder=" +Добавить задание…"/>
                        </div>
                        <hr />
                        <ul id="sortable<?php echo $k; ?>" class="sortable connectedSortable ui-helper-reset" date="<?php echo $k; ?>">
                            <?php foreach($v as $item):?>
                                <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default <?php if($item['Task']['time']):?> setTime <?php endif;?> <?php if($item['Task']['done']):?> complete <?php endif; ?>" date="<?php echo $item['Task']['date'];?>">
                                    <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                                    <span><i class="icon-move"></i></span>
                                    <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                    <span class=" editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
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
    </div>

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
        <a href="#" id="eSave" class="btn btn-success">Сохранить</a>
        <a href="#" class="btn" data-dismiss="modal">Закрыть</a>
    </div>
</div>
<!-- End modal --!>



