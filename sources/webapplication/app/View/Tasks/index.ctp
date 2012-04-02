
<div class="row">
    <div class="span8">
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
                 <div class="span5">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', time(), true); ?></p>
                     <div class="createTask"></div>
                     <hr />
                     <ul class="sortable connectedSortable ui-helper-reset">
                     <?php if(isset($arrTaskOnDays['Today']) && !empty($arrTaskOnDays['Today'])):?>
                        <?php foreach($arrTaskOnDays['Today'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <span class="label label-info"><?php echo $item['Task']['id']; ?></span>
                                <span class="label label-important"><?php echo $item['Task']['order']; ?></span>
                                <div class="editable"><?php echo $item['Task']['title']; ?></div>
                                <span> <i class="icon-move"> </i></span>
                                <span> <i class="icon-refresh divider"> </i></span>
                                <span> <i class="icon-remove"> </i></span>
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
                 <div class="span5">
                     <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+1 days', true); ?></p>
                     <div class="createTask"></div>
                     <hr />
                     <ul class="sortable connectedSortable ui-helper-reset">
                     <?php if(isset($arrTaskOnDays['Tomorrow']) && !empty($arrTaskOnDays['Tomorrow'])):?>
                        <?php foreach($arrTaskOnDays['Tomorrow'] as $item):?>
                            <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                <div class="editable"><?php echo $item['Task']['title']; ?></div>
                                <span> <i class="icon-move"> </i></span>
                                <span> <i class="icon-refresh divider"> </i></span>
                                <span> <i class="icon-remove"> </i></span>
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
                    <div class="span5">
                        <p class="tabDay"><?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?></p>
                        <div class="createTask"></div>
                        <hr />
                        <ul class="sortable connectedSortable ui-helper-reset">
                            <?php if(isset($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)]) && !empty($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)])):?>
                                <?php foreach($arrTaskOnDays[$this->Time->format('l', '+'.$i.' days', true)] as $item):?>
                                    <li id ="<?php echo $item['Task']['id']; ?>" class="ui-state-default">
                                        <div class="editable"><?php echo $item['Task']['title']; ?></div>
                                        <span> <i class="icon-move"> </i></span>
                                        <span> <i class="icon-refresh divider"> </i></span>
                                        <span> <i class="icon-remove"> </i></span>
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
    <div class="span3 well">
        <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active" ><a href="#future" data-toggle="tab">Будущее</a></li>
          <li><a href="#expired" data-toggle="tab">Просроченные</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="future">
            <div class="createTask"></div>
                <hr />
            <ul class="sortable connectedSortable ui-helper-reset">
                
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                    <div class="editable">Lorem ipsum dolor sit amet</div>
                </li>
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                    <input id="resizable" value="123"/>
                </li>
                <li class="ui-state-default ui-state-disabled">(I'm not sortable)</li>
                <li class="ui-state-default ">
                    <span> <i class="icon-move"> </i></span><input class="span2" id="prependedInput" size="16" type="text">
                </li>
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                    Item 4
                </li>
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                    <input value="XYZ" />
                     
                </li>
            </ul>
          </div>
          <div class="tab-pane" id="expired">
            <div class="editable">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit....
            </div>
            <hr/>
            <div class="editable">
            Aenean ut mauris nec nisl varius volutpat....
            </div>
            <hr/>
            <div class="editable">
            Aenean pharetra. Curabitur non turpis....
            </div>
          </div>
        </div>
      </div> <!-- /tabbable -->
    </div>
</div>