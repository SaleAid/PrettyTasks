
<div id="viewTask" class="modal hide fade view-task" tabindex="-1" data-focus-on="input:first">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?php echo __d('tasks', 'Просмотр комментария');?></h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="span6 task-view-comment">
              <textarea readonly="" class="text-task" id="vComment" rows="3" tabindex="1" style="height: 200px;"></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="task-view-date">
          <span class="muted" id="vCreated"></span>
          <span class="muted" id="vModified"></span>
        </div>
        <a href="" class="btn" data-dismiss="modal"><?php echo __d('tasks', 'Закрыть');?></a>
    </div>
</div>
