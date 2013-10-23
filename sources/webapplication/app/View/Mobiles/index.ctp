
<!-- Start of first page -->
<div data-role="page" id="page-tasks">

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-tasks" data-position="left"
		data-display="overlay" data-theme="e">
		<ul data-role="listview" data-divider-theme="e" data-count-theme="e">
			<li data-role="list-divider">Lists</li>
			<li><a href="#" class="menu-list-future">Agenda</a></li>
			<li><a href="#" class="menu-list-planned">Planned</a></li>
			<li><a href="#" class="menu-list-expired">Overdue</a></li>
			<li><a href="#" class="menu-list-completed">Completed</a></li>
			<li><a href="#" class="menu-list-deleted">Deleted</a></li>
			<li data-role="list-divider">Days</li>
			<!--<li><a href="#">New day</a></li>  -->
			<li><a href="#" class="menu-day-today">Today</a></li>
			<li><a href="#" class="menu-day-<?php echo $this->Time->format('Y-m-d', '+1 days', true, $timezone);?>">Tomorrow</a></li>
			<?php 
			    for($i=2; $i<7; $i++):
			?>
<li><a href="#" class="menu-day-<?php echo $this->Time->format('Y-m-d', "+$i days", true, $timezone);?>"><?php echo __($this->Time->format('l', "+$i days", true, $timezone));?></a></li>
			<?php 
			endfor;
			?>

		</ul>

	</div>
	<!-- /left panel -->

	<!-- right panel (actions) -->
	<div data-role="panel" id="right-panel-tasks" data-position="right"
		data-display="overlay" data-theme="e">

		<ul data-role="listview" data-divider-theme="e" data-count-theme="e" id="tags-list"></ul>

	</div>
	<!-- /right panel (actions) -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#" class="ui-btn-active" data-transition="flip">Tasks</a></li>
				<li><a href="#page-notes" data-transition="flip">Notes</a></li>
			</ul>
		</div>
		<!-- /navbar -->
	</div>
	<!-- /header -->

	<div data-role="content">
		<!-- Place your content below-->
		<form onsubmit="return false;">
			<input type="text" name="addnew" id="addnew" value=""
				placeholder="Type to add new task for today" autocomplete="off" />
		</form>

		<ul id="taskslist" data-role="controlgroup">
		<?php /*?>
			<!-- 
		<li>
			<label>
				<input type="checkbox" name="checkbox-0 ">Check me<img src="/img/tools.png" style="float:right"/>
			</label>
		</li>
	 -->
	 <?php */?>
		</ul>





		<!-- Place your content above-->
	</div>
	<!-- /content -->
	<div data-role="footer" data-position="fixed" data-theme="c">
        <?php echo $this->Html->link(
                            __('Go to full version'),
                            array('controller' => 'tasks', 'action' => 'index', '#' => 'day-'.$this->Time->format('Y-m-d', time())),
                            array('rel' => 'external')
        );?>
	</div><!-- /footer -->
</div>
<!-- /page -->


<!-- Start of second page -->
<div data-role="page" id="page-notes">

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-notes" data-position="left"
		data-display="push" data-theme="e">
	</div>
	<!-- /left panel -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#page-tasks" data-transition="flip">Tasks</a></li>
				<li><a href="#page-notes" class="ui-btn-active"
					data-transition="flip">Notes</a></li>
			</ul>
		</div>
		<!-- /navbar -->
	</div>
	<!-- /header -->

	<div data-role="content">
	<?php /*?>
		<form onsubmit="return false;">
			<input type="text" name="addnew" id="addnew" value=""
				placeholder="Type to add new note">
		</form>
	<?php */?>
		<ul data-role="listview" data-inset="true" id="noteslist"></ul>
	</div>
	<!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="e">
		<h6>PrettyTasks 2012-2013 &copy;</h6>
	</div>
	<!-- /footer -->
</div>
<!-- /page -->

	

