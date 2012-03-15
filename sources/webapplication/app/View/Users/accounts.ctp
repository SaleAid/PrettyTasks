 	<h2><?php echo __('Связанные учетные записи');?></h2>
            
	       <table class="table table-striped" >
            <tr>
    			<th><?php echo $this->Paginator->sort('uid');?></th>
    			<th><?php echo $this->Paginator->sort(__('Провайдер'));?></th>
    			<th><?php echo $this->Paginator->sort(__('Дата связывания'));?></th>
    			<th><?php echo $this->Paginator->sort('Аккаунт');?></th>
    			<th class="actions"><?php echo __('Действия');?></th>
	       </tr>
	   <?php
	       foreach ($accounts as $item): ?>
	   <tr>   
    		<td><?php echo h($item['Account']['uid']); ?>&nbsp;</td>
    		<td><?php echo h($item['Account']['provider']); ?>&nbsp;</td>
    		<td><?php echo h($item['Account']['created']); ?>&nbsp;</td>
    		<td><?php echo h($item['Account']['identity']); ?>&nbsp;</td>
    		<td class="actions"></td>
	   </tr>
    <?php endforeach; ?>
	</table>