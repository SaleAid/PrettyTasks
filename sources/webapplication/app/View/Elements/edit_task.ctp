
<div id="editTask" class="modal hide fade" tabindex="-1" data-focus-on="input:first">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?php echo __d('tasks', 'Редактирование задачи');?></h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="span6 form-horizontal">
              <div class="control-group">
                <label class="control-label" for="eTitle"><?php echo __d('tasks', 'Заглавие');?></label>
                <div class="controls">
                  <input type="text" class="span6" id="eTitle" data-tabindex="1" />
                </div>
              </div>
              <div class="control-group form-inline">
                <label class="control-label" for="eDate"><?php echo __d('tasks', 'Дата и время');?></label>
                <div class="controls">
                    <input type="text" id="eDate" data-tabindex="2" />
                    <label><?php echo __d('tasks', 'с');?></label>
                    <input type="text" id="eTime" data-tabindex="3" />
                    <label><?php echo __d('tasks', 'по');?></label>
                    <input type="text" id="eTimeEnd" data-tabindex="4" />
                </div>
              </div>
              
          <div class="row">
              <div class="span5">
                  <div class="control-group">
                    <label class="control-label" for="eComment"><?php echo __d('tasks', 'Комментарий');?></label>
                    <div class="controls">
                      <textarea class="span4" id="eComment" rows="4" data-tabindex="5" ></textarea>
                    </div>
                  </div>
                </div>  
              <div class="priority span1 form-vertical">
              <div class="control-group">
                <label class="control-label"><?php echo __d('tasks', 'Приоритет');?></label>
                <div class="controls">
                  <label class="radio">
                    <input type="radio" name="priority" id="optionsRadios1" value="1" />
                    <?php echo __d('tasks', 'Высокий');?>
                  </label>
                  <label class="radio">
                    <input type="radio" name="priority" id="optionsRadios2" value="0"/>
                    <?php echo __d('tasks', 'Обычный');?>
                  </label>
                </div>
              </div>
            </div>
        </div>
              <div class="done-continued">
                <div class="form-inline">
                    <label class="checkbox continued-task">
                        <input type="checkbox" id="eContinued"/>
                        <?php echo __d('tasks', 'Длительная');?>
                    </label>
                    <!--<label class="checkbox pull-right repeated-task">
                        <input type="checkbox" id="eRepeat" value="option1"/>
                        <?php //echo __d('tasks', 'Повторить');?>...
                    </label>
                    -->
                </div>
                <div class="form-inline">
	                <label class="checkbox">
	                    <input type="checkbox" id="eDone" value="option1"/>
	                    <?php echo __d('tasks', 'Выполнена');?>
	                </label>
                </div>
              </div>
              
        </div>
    </div>
</div>
    <div class="modal-footer">
        <a href="" class="btn" data-dismiss="modal"><?php echo __d('tasks', 'Закрыть');?></a>
        <button id="eSave" class="btn btn-success"><?php echo __d('tasks', 'Сохранить');?></button>
    </div>
</div>
