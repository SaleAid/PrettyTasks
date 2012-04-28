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
                <input type="text" class="span2" id="eDate"/>
                <input type="text" class="span1" id="eTime"/>
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

<div class="row">
    <div class="span12">
      <div id="main" class="tabbable tabs-left" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
            <li ><a href="#expired" data-toggle="tab" date="expired" class="tab2">Просроченные</a></li>
            <li class="drop">
                <a href="#future" data-toggle="tab" date="future" class="tab2">Будущее</a>
            </li>
            <li class="active drop">
                <a href="#Today" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                <?php echo __('Сегодня'); ?>
            </a>
          </li>
         <li class="drop">
            <a href="#Tomorrow" data-toggle="tab" date = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                 <?php echo __('Завтра'); ?>
            </a>
          </li>
          <?php for($i = 2; $i <= 5; $i++):?>
            <li class="drop"> <a href="#<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>"
                             data-toggle="tab"
                              date = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                      <?php echo __($this->Time->format('l', '+'.$i.' days', true)); ?>
                 </a>
            </li>
          <?php endfor; ?>
          
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
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <span> <i class="icon-move"> </i></span>
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php else: ?><i class="icon-time"> </i><?php endif; ?></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <span class="editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                            <span class="editTask"><i class="icon-pencil"></i></a></span>
                            <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
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
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <span><i class="icon-move"></i></span>
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php else: ?><i class="icon-time"> </i><?php endif; ?></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <span class=" editable input-xxlarge <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                            <span class="editTask"><i class="icon-pencil"></i></a></span>
                            <span class="deleteTask"><i class=" icon-ban-circle"> </i></span>
                        </li>
                    <?php endforeach;?>
                    </ul>
                <?php endif;?>
        </div>
        </div>
          </div>
          <div class="tab-pane active" id="Today">
             <div class="row">
                 <div class="span10">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', time(), true); ?></p>
                     <div class="well form-inline">
                        <input type="text" class="createTask input-xxlarge" placeholder=" +Добавить задание…"/>
                     </div>
                     <hr />
                     <ul id="sortableToday" class=" sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                     <?php if(isset($result['data']['arrTaskOnDays']['Today']) && !empty($result['data']['arrTaskOnDays']['Today'])):?>
                        <?php foreach($result['data']['arrTaskOnDays']['Today'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <span> <i class="icon-move"></i></span>
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php else: ?><i class="icon-time"> </i><?php endif; ?></span>
                                <input type="checkbox" class="done" <?php if($item['Task']['done']):?> checked <?php endif; ?> />
                                <span class="editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?> "><?php echo $item['Task']['title']; ?></span>
                                <span class="editTask"><i class="icon-pencil"></i></a></span>
                                <span class="deleteTask "><i class="icon-ban-circle"></i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 
            </div>
          </div>
          <div class="tab-pane" id="Tomorrow">
            <div class="row">
                 <div class="span10">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+1 days', true); ?></p>
                     <div class="well form-inline">
                        <input type="text" class="createTask input-xxlarge" placeholder=" +Добавить задание…"/>
                     </div>
                     <hr />
                     <ul id="sortableTomorrow" class="sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                     <?php if(isset($result['data']['arrTaskOnDays']['Tomorrow']) && !empty($result['data']['arrTaskOnDays']['Tomorrow'])):?>
                        <?php foreach($result['data']['arrTaskOnDays']['Tomorrow'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <span> <i class="icon-move"> </i></span>
                                <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php else: ?><i class="icon-time"> </i><?php endif; ?></span>
                                <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                <span class=" editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                                <span class="editTask"><i class="icon-pencil"></i></a></span>
                                <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 
            </div>
          </div>
          <?php for($i = 2; $i <= 5; $i++):?>
            <div class="tab-pane" id="<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>">
                <div class="row">
                    <div class="span10">
                        <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?></p>
                        <div class="well form-inline">
                            <input type="text" class="createTask input-xxlarge" placeholder=" +Добавить задание…"/>
                        </div>
                        <hr />
                        <ul id="sortable<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>" class="sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                            <?php if(isset($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)]) && !empty($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)])):?>
                                <?php foreach($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)] as $item):?>
                                    <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                        <span> <i class="icon-move"> </i></span>
                                        <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php else: ?><i class="icon-time"> </i><?php endif; ?></span>
                                        <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                        <span class=" editable input-xxlarge <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></span>
                                        <span class="editTask"> <i class="icon-pencil"> </i></a></span>
                                        <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                   
                </div>
            </div>
          <?php endfor; ?>
          
    </div> <!-- /tabbable -->
    </div>  
    </div>

</div>



