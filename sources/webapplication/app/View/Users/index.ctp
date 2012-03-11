
<div class="span10">
    <div class="hero-unit">
        <h1>Hello, world!</h1>
        <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
    </div>
    <div class="row-fluid">
    <h2 class="label label-info"> Your list of active accounts: </h2>
        <div class="span4">
            <h2><?php  echo __('User');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First name'); ?></dt>
		<dd>
			<?php echo h($user['User']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
        </div>
        <div class="span6">
          
          	<h2><?php echo __('Accounts');?></h2>
            
	       <table class="table table-striped" >
            <tr>
    			<th><?php echo $this->Paginator->sort('id');?></th>
    			<th><?php echo $this->Paginator->sort('provider');?></th>
    			<th><?php echo $this->Paginator->sort('created');?></th>
    			<th><?php echo $this->Paginator->sort('active');?></th>
    			<th class="actions"><?php echo __('Actions');?></th>
	       </tr>
	   <?php
	       foreach ($user['Account'] as $item): ?>
	   <tr>   
    		<td><?php echo h($item['id']); ?>&nbsp;</td>
    		<td><?php echo h($item['provider']); ?>&nbsp;</td>
    		<td><?php echo h($item['created']); ?>&nbsp;</td>
    		<td><?php echo h($item['active']); ?>&nbsp;</td>
    		<td class="actions"></td>
	   </tr>
    <?php endforeach; ?>
	</table>
          
        </div><!--/span-->
    </div><!--/row-->
</div><!--/span-->
