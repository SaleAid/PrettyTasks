<?php $this->start ( 'toHead' );?>
<?php echo $this->Html->css('journal.'.Configure::read('App.version'));?>
<?php $this->end ();?>
<div class="row">
    <div class="jl-content">
        <?php foreach($result['data'] as $day):?>
            <div class="jl-day">
                <span class="jl-title">
                    <?php 
                        echo $this->Html->link($day['Day']['date'] .' - '. __($this->Time->format('l', $day['Day']['date'])), array( 
                            'controller' => 'tasks',  
                            'action' => 'index',
                        	'#' => 'day-'.$day['Day']['date']
                        )); 
                    ?>
                    <?php if($day['Day']['rating']): ?>&nbsp;&nbsp;
                        <?php echo $this->Html->image("gday.". Configure::read('App.version') .".png", array('class' => 'g-day', 'width' => 32, 'height' => 32)); ?>
                    <?php endif; ?>
                </span>
                <p><?php echo h($day['Day']['comment']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
