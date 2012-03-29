
<div class="row">
    <div class="span8">
    <div id="data"></div>
      <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs main">
          <li class="active"><a href="#Today" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', time(), true); ?>">Сегодня</a></li>
          <li><a href="#Tomorrow" data-toggle="tab" name = "<?php echo $this->Time->format('Y-m-d', '+1 days', true); ?>">Завтра</a></li>
          <li class="diliver"></li>
          <?php for($i = 2; $i <= 8; $i++):?>
            <li> <a href="#<?php echo $this->Time->format('l', '+'.$i.' days', true); ?>"
                             data-toggle="tab"
                              name = "<?php echo $this->Time->format('Y-m-d', '+'.$i.' days', true); ?>">
                     <?php echo $this->Time->format('l', '+'.$i.' days', true); ?> 
                 </a>
            </li>
          <?php endfor; ?>
          
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="Today">
             <div class="row">
             <div class="span5">
            
             <div class="newTask"></div>
            <hr />
            <div class="list"></div>
           <!-- <ul class="sortable connectedSortable ui-helper-reset">
               
                <li class="ui-state-default ui-state-disabled">
                    <div class="editable">Lorem ipsum dolor sit amet 4 4 4 4 4 4 4</div>
                    <span> <i class="icon-move"> </i></span>
                    <span> <i class="icon-refresh divider"> </i></span>
                    <span> <i class="icon-remove"> </i></span>
                 
                </li>
                <li class="ui-state-default ">
                    <div class="editable">Lorem ipsum dolor sit amet 4 4 4 4 4 4 4</div>
                    <span> <i class="icon-move"> </i></span>
                    <span> <i class="icon-refresh divider"> </i></span>
                    <span> <i class="icon-remove"> </i></span>
                 
                </li>
               
            </ul> --!>
                </div>
      <div class="span2 well">
      </div>
      </div>
    
          </div>
          <div class="tab-pane" id="Tomorrow">
            <p>tomorrow.</p>
          </div>
          <div class="tab-pane" id="Sunday">
            <p>Sunday </p>
          </div>
          <div class="tab-pane" id="Monday">
            <p>Monday </p>
          </div>
          <div class="tab-pane" id="Tuesday">
            <p>Tuesday </p>
          </div>
          <div class="tab-pane" id="Wednesday">
            <p>Wednesday </p>
          </div>
          <div class="tab-pane" id="Thursday">
            <p>Thursday </p>
          </div>
          <div class="tab-pane" id="Friday">
            <p>Friday </p>
          </div>
          <div class="tab-pane" id="Saturday">
            <p>Saturday </p>
          </div>
        
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