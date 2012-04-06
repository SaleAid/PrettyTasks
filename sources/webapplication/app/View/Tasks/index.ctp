<!-- modal --!>
<div id="example" class="modal hide fade in" style="display: none; ">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Удаление задачи.</h3>
    </div>
    <div class="modal-body">
        <h4>Text in a modal</h4>
        <p>You can add some text here.</p>		        
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger">Call to action</a>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>

<div class="row-fluid row">
    <div class="span7 span-fixed-sidebar">
    <div id="data"></div>
      <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs main">
          <li class="active">
            <a href="#Today" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">
                <?php echo __('Сегодня'); ?>
                <br />
                 <?php echo $this->Time->format('Y-m-d', time(), true); ?>
            </a>
          </li>
          <li>
            <a href="#Tomorrow" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">
                 <?php echo __('Завтра'); ?>
                  <br />
                 <?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>
            </a>
          </li>
          <li class="divider-vertical"></li>
          <?php for($i = 2; $i <= 5; $i++):?>
            <li> <a href="#<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>"
                             data-toggle="tab"
                              name = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                      <?php echo __($this->Time->format('l', '+'.$i.' days', true)); ?>
                      <br />
                <?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>
                 </a>
            </li>
          <?php endfor; ?>
          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="Today">
             <div class="row">
                 <div class="span4">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', time(), true); ?></p>
                     <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                     <p><a data-toggle="modal" href="#example" class="btn btn-primary btn-large">Launch demo modal</a></p>
                     <hr />
                     <ul class="sortable conWith ui-helper-reset">
                     <?php if(isset($arrTaskOnDays['Today']) && !empty($arrTaskOnDays['Today'])):?>
                        <?php foreach($arrTaskOnDays['Today'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                 <span> <i class="icon-move"> </i></span>
                                <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                               
                                <span> <i class="icon-refresh divider"> </i></span>
                                <span class="deleteTask "> <i class="icon-remove "> </i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 <div class="span2 well">
                 </div>
            </div>
          </div>
          <div class="tab-pane" id="Tomorrow">
            <div class="row">
                 <div class="span4">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+1 days', true); ?></p>
                     <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                     <hr />
                     <ul class="sortable connectedSortable ui-helper-reset">
                     <?php if(isset($arrTaskOnDays['Tomorrow']) && !empty($arrTaskOnDays['Tomorrow'])):?>
                        <?php foreach($arrTaskOnDays['Tomorrow'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                                <span> <i class="icon-move"> </i></span>
                                <span> <i class="icon-refresh divider"> </i></span>
                                <span class="deleteTask"> <i class="icon-remove"> </i></span>
                            </li>
                        <?php endforeach;?>
                     <?php endif;?>
                     </ul>
                 </div>
                 <div class="span2 well">
                 </div>
            </div>
          </div>
          <?php for($i = 2; $i <= 5; $i++):?>
            <div class="tab-pane" id="<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>">
                <div class="row">
                    <div class="span4">
                        <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?></p>
                        <input type="text" class="createTask span4" placeholder=" +Добавить задание…"/>
                        <hr />
                        <ul class="sortable connectedSortable ui-helper-reset">
                            <?php if(isset($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)]) && !empty($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)])):?>
                                <?php foreach($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)] as $item):?>
                                    <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                        <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                                        <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                                        <span> <i class="icon-move"> </i></span>
                                        <span> <i class="icon-refresh divider"> </i></span>
                                        <span class="deleteTask"> <i class="icon-remove"> </i></span>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="span2 well">
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
                <?php if(isset($arrAllFuture) && !empty($arrAllFuture)):?>
                    <?php foreach($arrAllFuture as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <div class="editable <?php if($item['Task']['done']):?> complete <?php endif; ?>"><?php echo $item['Task']['title']; ?></div>
                            <span> <i class="icon-move"> </i></span>
                            <span> <i class="icon-refresh divider"> </i></span>
                            <span class="deleteTask"> <i class="icon-remove"> </i></span>
                        </li>
                    <?php endforeach;?>
                <?php endif;?>   
            </ul>
          </div>
          <div class="tab-pane" id="expired">
                <?php if(isset($arrAllExpired) && !empty($arrAllExpired)):?>
                <ul class="sortable connectedSortable ui-helper-reset">
                    <?php foreach($arrAllExpired as $item):?>
                        <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                            <input type="checkbox" class="done" value="1" <?php if($item['Task']['done']):?> checked <?php endif; ?>/>
                            <div class="editable"><?php echo $item['Task']['title']; ?></div>
                            <span> <i class="icon-move"> </i></span>
                            <span> <i class="icon-refresh divider"> </i></span>
                            <span class="deleteTask"> <i class="icon-remove"> </i></span>
                        </li>
                    <?php endforeach;?>
                    </ul>
                <?php endif;?>
        </div>
      </div> <!-- /tabbable -->
    </div>
</div>

</div>

