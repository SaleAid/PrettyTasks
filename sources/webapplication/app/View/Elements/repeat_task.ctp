
<div id="repeatTask" class="modal hide fade"  tabindex="-1" data-width="450">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __d('tasks', 'Повторяющиеся задачи');?></h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <table class="form-repeat">
            <tr>
                <td class="label-td">
                    <label class="control-label" for="freq"><?php echo __d('tasks', 'Повторяется');?>:</label>&nbsp;
                </td>
                <td>
                     <?php echo $this->Form->select('freq', array(
                                'dally' => __d('tasks', 'каждый день'),
                                'weekly' => __d('tasks', 'каждую неделю'),
                                'monthly' => __d('tasks', 'каждый месяц'),
                                'yearly' => __d('tasks', 'каждый год'),
                            ),
                            array('value' => array('dally'),
                                  'empty' => false,
                                  )
                        ); ?>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <label class="control-label" for="interval"><?php echo __d('tasks', 'Повторять с интервалом');?>:</label>&nbsp;
                </td>
                <td>
                    <?php echo $this->Form->select('interval', array_combine(range(1,30,1),range(1,30,1)),
                            array('value' => array('1'),
                                  'empty' => false, 
                                  'class' => 'span1'  
                                )
                        ); ?>
                        <span class="interval-d"><?php echo __d('tasks', 'дн');?>.</span>
                        <span class="interval-w hide"><?php echo __d('tasks', 'нед');?>.</span>
                        <span class="interval-m hide"><?php echo __d('tasks', 'мес');?>.</span>
                        <span class="interval-y hide"><?php echo __d('tasks', 'г');?>.</span>
                </td>
            </tr>
            <tr class="days-weekly hide">
                <td class="label-td">
                    <label class="control-label" for="byday"><?php echo __d('tasks', 'Дни повторения');?>:</label>&nbsp;
                </td>
                <td>
                    <?php $weekDays = array(
                    			'sun' => array(__d('tasks', 'воскресенье'),__d('tasks', 'вс')),
                    			'mon' => array(__d('tasks', 'понедельник'),__d('tasks', 'пн')),
                                'tue' => array(__d('tasks', 'вторник'),__d('tasks', 'вт')),
                                'wed' => array(__d('tasks', 'среда'), __d('tasks', 'ср')),
                                'thu' => array(__d('tasks', 'четверг'),__d('tasks', 'чт')),
                                'fri' => array(__d('tasks', 'пятница'),__d('tasks', 'пт')),
                                'sat' => array(__d('tasks', 'суббота'),__d('tasks', 'сб'))
                            );
                    ?>
                    <?php foreach( $weekDays as $key => $day): ?>
                    <span class="week">
                        <input id="<?php echo $key?>" name="data['days'][]" value="<?php echo $key?>" type="checkbox" >
                        <label for="<?php echo $key?>" title="<?php echo $day[0]; ?>"><?php echo $day[1]; ?></label>
                    </span>
                     <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                     <label class="control-label"><?php echo __d('tasks', 'Окончание');?>:</label>&nbsp;
                </td>
                <td>
                     <label class="radio">
                      <input type="radio" name="until" id="never-r" value="never" checked >
                      <?php echo __d('tasks', 'Никогда');?>
                      
                    </label>
                    <label class="radio">
                      <input type="radio" name="until" id="after-r" value="after" >
                      <?php echo __d('tasks', 'После');?>
                      <?php echo $this->Form->input('count', array('label' => false, 'class' => 'inline span1', 'div' => false));?>
                    </label>
                    <label class="radio">
                      <input type="radio" name="until" id="date-r" value="date" >
                      <?php echo $this->Form->input('date', array('label' => false, 'class' => 'inline span2', 'div' => false));?>
                    </label>
                </td>
            </tr>
    	</table>
        </div>
    </div>
    <div class="modal-footer">
        <span><?php echo __d('tasks', 'Максимальное кол-во повторений');?>:&nbsp;<?php echo Configure::read('Repeated.MaxCount');?></span>
        <a href="" class="btn" data-dismiss="modal"><?php echo __d('tasks', 'Закрыть');?></a>
        <button id="saveRepeate" class="btn btn-success"><?php echo __d('tasks', 'Сохранить');?></button>
    </div>
</div>

<!-- repeated comfirm-->

<div class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>
