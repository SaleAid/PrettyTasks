<?php if($result['success']): ?>
<li id ="<?php echo $result['data']['Task']['id']; ?>" class="ui-state-default">
    <span> <i class="icon-move"> </i></span>
    <?php if(!$result['data']['Task']['future']): ?>
        <span class="time"> <i class="icon-time"> </i></span>
    <?php endif;?>
    <input type="checkbox" class="done" value="1"/>
    <div class="editable"><?php echo h($result['data']['Task']['title']); ?></div>
    <span class="editTask"> <i class="icon-pencil"> </i></a></span>
    <span class="deleteTask"> <i class=" icon-ban-circle"> </i></span>
</li>
<?php endif;?>