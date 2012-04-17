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
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger">Сохранить</a>
        <a href="#" class="btn" data-dismiss="modal">Закрыть</a>
    </div>
</div>
<!-- End modal --!>

<div class="row-fluid row">
    <div class="span7 span-fixed-sidebar">
    
      <div id="main" class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#Today" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                <?php echo __('Сегодня'); ?>
            </a>
          </li>
          <li>
            <a href="#Tomorrow" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                 <?php echo __('Завтра'); ?>
            </a>
          </li>
          <?php for($i = 2; $i <= 5; $i++):?>
            <li> <a href="#<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>"
                             data-toggle="tab"
                              name = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                      <?php echo __($this->Time->format('l', '+'.$i.' days', true)); ?>
                 </a>
            </li>
          <?php endfor; ?>
          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="Today">
             <div class="row">
                 <div class="span5">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', time(), true); ?></p>
                     <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                     <hr />
                     <ul id="sortableToday" class="sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                     <?php if(isset($result['data']['arrTaskOnDays']['Today']) && !empty($result['data']['arrTaskOnDays']['Today'])):?>
                        <?php foreach($result['data']['arrTaskOnDays']['Today'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <span> <i class="icon-move"> </i></span>
                                <span class="time"> <i class="icon-time"> </i></span>
                                <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                                <span class="editTask"> <i class="icon-pencil"> </i></a></span>
                                <span class="deleteTask "> <i class=" icon-ban-circle "> </i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 <div class="span2 comment">
                 </div>
            </div>
          </div>
          <div class="tab-pane" id="Tomorrow">
            <div class="row">
                 <div class="span5">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+1 days', true); ?></p>
                     <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                     <hr />
                     <ul id="sortableTomorrow" class="sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                     <?php if(isset($result['data']['arrTaskOnDays']['Tomorrow']) && !empty($result['data']['arrTaskOnDays']['Tomorrow'])):?>
                        <?php foreach($result['data']['arrTaskOnDays']['Tomorrow'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <span> <i class="icon-move"> </i></span>
                                <span class="time"> <i class="icon-time"> </i></span>
                                <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                                <span> <i class="icon-pencil"> </i></span>
                                <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 <div class="span2 comment">
                 </div>
            </div>
          </div>
          <?php for($i = 2; $i <= 5; $i++):?>
            <div class="tab-pane" id="<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>">
                <div class="row">
                    <div class="span5">
                        <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?></p>
                        <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                        <hr />
                        <ul id="sortable<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>" class="sortable connectedSortable ui-helper-reset" date="<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                            <?php if(isset($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)]) && !empty($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)])):?>
                                <?php foreach($result['data']['arrTaskOnDays'][$this->Time->format('l', '+'.$i.' days', true)] as $item):?>
                                    <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                        <span> <i class="icon-move"> </i></span>
                                        <span class="time"> <i class="icon-time"> </i></span>
                                        <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                        <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                                        <span> <i class="icon-pencil"> </i></span>
                                        <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="span2 comment">
                    </div>
                </div>
            </div>
          <?php endfor; ?>
          
    </div> <!-- /tabbable -->
    </div>  
    </div>
    <div class="span4 well">
        <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active" ><a href="#future" data-toggle="tab">Будущее</a></li>
          <li><a href="#expired" data-toggle="tab">Просроченные</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="future">
            <input type="text" class="span4" placeholder=" +Добавить задание…"/>
            <hr />
            <ul class="sortable conWith ui-helper-reset">
                <?php if(isset($result['data']['arrAllFuture']) && !empty($result['data']['arrAllFuture'])):?>
                    <?php foreach($result['data']['arrAllFuture'] as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <span> <i class="icon-move"> </i></span>
                            
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                            <span> <i class="icon-pencil"> </i></span>
                            <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>   
            </ul>
          </div>
          <div class="tab-pane" id="expired">
                <?php if(isset($result['data']['arrAllExpired']) && !empty($result['data']['arrAllExpired'])):?>
                <ul class="sortable connectedSortable ui-helper-reset">
                    <?php foreach($result['data']['arrAllExpired'] as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <span> <i class="icon-move"> </i></span>
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <div class="editable <?php if($item['Task']['priority']):?> important <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                            <span> <i class="icon-pencil"> </i></span>
                            <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
                        </li>
                    <?php endforeach;?>
                    </ul>
                <?php endif;?>
        </div>
      </div> <!-- /tabbable -->
    </div>
</div>

</div>

