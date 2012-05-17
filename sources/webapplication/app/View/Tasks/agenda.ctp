<?php $this->start ( 'toHead' );?>
<?php echo $this->Html->css('agenda');?>
<?php $this->end ();?>
<div class="row">
    <div class="agenda">
        <?php foreach($result['data']['arrTaskOnDays'] as $k => $v):?>
            <div class="listTasks">
                <h3 class=""><?php echo $k .' - '. __($this->Time->format('l', $k)); ?></h3>
                <ul class="unstyled">
                    <?php foreach($v as $item):?>
                        <li  class=" <?php if($item['Task']['done']):?> complete <?php endif; ?> <?php if($item['Task']['priority']):?> important <?php endif; ?>">
                            <span class="time"><?php if($item['Task']['time']):?><?php echo $this->Time->format('H:i', $item['Task']['time'],true);?><?php endif; ?></span>
                            <span class="timeEnd"><?php if($item['Task']['timeend']):?><?php echo $this->Time->format('H:i', $item['Task']['timeend'],true);?><?php endif; ?></span>
                            <span class=" editable  <?php if($item['Task']['done']):?> complete <?php endif; ?> "><?php echo $item['Task']['title']; ?></span>
                            
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>
  