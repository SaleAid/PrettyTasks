<p>Today digest eng</p>

<p>Доброе утро, <?php echo $user['User']['full_name']; ?>!</p>

<p>На сегодня у вас запланировано <?php echo $data['tasks']['today']['count']; ?> <?php echo __dn('mail', 'задач', 'задачи', $data['tasks']['today']['count']); ?>, из них <?php echo $data['tasks']['today']['count_priority'] ?> важная.</p> 

<ul>
    <?php foreach($data['tasks']['today']['list'] as $task): ?>
    <li style="<?php if($task['Task']['priority']) :?> font-weight: bold; <?php endif;?>"><?php echo $task['Task']['title'];?></li>
    <?php endforeach; ?>
</ul>

<p>
    Вчера <?php if (isset($data['days']['yesterday']) && $data['days']['yesterday'][0]['Day']['rating'] ) :?> у вас был удачный день, <?php endif; ?> 
    <?php if ( isset($data['tasks']['yesterday']) && $data['tasks']['yesterday']['count']): ?>
        <?php if ( !($data['tasks']['yesterday']['count_not_done'])): ?>
            вы выполнили все задачи.
        </p>
        <?php else : ?>
            вы выполнили <?php echo $data['tasks']['yesterday']['count_done']; ?> <?php echo __dn('mail', 'задачу', 'задачи', $data['tasks']['yesterday']['count']); ?> из <?php echo $data['tasks']['yesterday']['count']; ?>.
        </p>
        <p>Задачи:</p>
        <ul>
            <?php foreach($data['tasks']['yesterday']['list'] as $task): ?>
            <li><?php echo $task['Task']['title'];?></li>
            <?php endforeach; ?>
        </ul>    
        вы найдете в списке 
        <?php echo $this->Html->link('просроченных задач', array('controller' => 'tasks', 'action' => 'index','#' => 'day-expired', 'full_base' => true)); ?>
        
        <?php endif; ?> 
    <?php else : ?>
        <?php if (isset($data['days']['yesterday']) && $data['days']['yesterday'][0]['Day']['rating'] ) :?> и <?php endif; ?>  не было запланировано ни одной задачи.
    <?php endif; ?>

<?php if (isset($data['days']['yesterday']) && $data['days']['yesterday'][0]['Day']['comment'] ) :?>
<p>Вы описали вчерашний день как:</p>
<pre style="background: #B1B1B1; font-size: 12px; border: 1px solid black; padding: 2px;">
    <?php echo $data['days']['yesterday'][0]['Day']['comment']?>
</pre>
<?php endif; ?>