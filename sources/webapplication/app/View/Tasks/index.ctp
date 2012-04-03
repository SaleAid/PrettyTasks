 <style type="text/css">
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
</style>
  
<div class="row">
    <div class="span8">
      <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#1" data-toggle="tab">Сегодня</a></li>
          <li><a href="#2" data-toggle="tab">Завтра</a></li>
          <li><a href="#3" data-toggle="tab">Неделя</a></li>
          <li><a href="#4" data-toggle="tab">Будущее</a></li>
          <li><a href="#5" data-toggle="tab">Просроченные</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="1">
            <p>Задачи на сегодня. <input type="text" id="datepicker" size="10" readonly="readonly"/></p>
            <ul id="sortable">
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                     <input value="" />
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
          <div class="tab-pane" id="2">
            <p>Howdy, I'm in Section 2.</p>
          </div>
          <div class="tab-pane" id="3">
            <p>What up girl, this is Section 3.</p>
          </div>
        </div>
      </div> <!-- /tabbable -->
    </div>
    <div class="span3 well">
        <div class="tabbable" style="margin-bottom: 9px;">
        <ul class="nav nav-tabs">
          <li class="active" ><a href="#future" data-toggle="tab">Будущее</a></li>
          <li><a href="#expired" data-toggle="tab">Просроченные</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="future">
            <ul id="sortable">
                <li class="ui-state-default">
                    <span> <i class="icon-move"> </i></span>
                     <input value="" />
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