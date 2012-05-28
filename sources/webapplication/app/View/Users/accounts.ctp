<?php 
$this->append('toHead');
echo $this->Html->css($this->Loginza->getCssUrl());
$this->end();
?>

<div class="well">
 	<h2><?php echo __('Связанные учетные записи');?></h2>
            
	       <table class="table table-striped" >
            <tr>
    			<th><?php echo __('Провайдер');?></th>
    			<th><?php echo __('Имя');?></th>
    			<th><?php echo __('Дата связывания');?></th>
    			
    			<th class="actions"><?php echo __('Действия');?></th>
	       </tr>
	   <?php
	       foreach ($accounts as $item): ?>
	   <tr>   
    		<td><?php echo $this->Loginza->logo($item['Account']['provider']); ?>&nbsp;</td>
    		<td><?php echo h($item['Account']['full_name']); ?>&nbsp;</td>
    		<td><?php echo h($item['Account']['created']); ?>&nbsp;</td>
    		<td class="actions"><?php echo $this->Form->postLink(__('Delete'), array('controller' => 'Accounts', 'action' => 'delete', $item['Account']['id']), null, __('Are you sure you want to delete this account')); ?></td>
	   </tr>
    <?php endforeach; ?>
	</table>
 </div>