<!DOCTYPE html>
<html>
<head>

  <title>Prettytasks Mobile page</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  


  
  <?php echo $this->Html->css('/js/jquery.1.3.1/jquery.mobile-1.3.1.min'); ?> 
  <?php echo $this->Html->script('https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.1.min.js'); ?>
  <?php echo $this->Html->script('m2/tasks'); ?> 
  <?php echo $this->Html->script('jquery.1.3.1/jquery.mobile-1.3.1.min'); ?> 
  <style type="text/css" rel="stylesheet">
	.ui-panel-inner {
	    position: absolute;
	    top: 1px;
	    left: 0;
	    right: 0;
	    bottom: 0px;
	    overflow-y: scroll;
	    -webkit-overflow-scrolling: touch;
	}
	.ui-checkbox-off{
		text-decoration: none;
	}
	.ui-checkbox-on{
		text-decoration: line-through;
		color: #aaa;
	}
  </style>

</head>
<body> 

<!-- Start of first page -->
<div data-role="page" id="page-tasks" >

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-tasks" data-position="left" data-display="overlay" data-theme="e">
		<ul  data-role="listview"  data-divider-theme="e" data-count-theme="e">
			<li data-role="list-divider">Lists</li>
			<li><a href="#" class="menu-planned">Planned</a></li>
			<li><a href="#" class="menu-overdue">Overdue</a></li>
			<li><a href="#" class="menu-completed">Completed</a></li>
			<li><a href="#" class="menu-future">Future</a></li>
			<li><a href="#" class="menu-deleted">Deleted</a></li>
			<li data-role="list-divider">Days</li>
			<li><a href="#">New day</a></li>
			<li><a href="#">Today</a></li>
			<li><a href="#">Tomorrow</a></li>
			<li><a href="#">Day 3</a></li>
			<li><a href="#">Day 4</a></li>
			<li><a href="#">Day 5</a></li>
			<li><a href="#">Day 6</a></li>
			<li><a href="#">Day 7</a></li>
		</ul>
		
	</div><!-- /left panel -->
	
	<!-- right panel (actions) -->
	<div data-role="panel" id="right-panel-tasks" data-position="right" data-display="overlay" data-theme="e">
	
		<ul data-divider-theme="e" data-count-theme="e" id="tasks-actions" >
			<h3>Actions</h3>
			<li><a href="#" data-role="button" data-icon="check" data-iconpos="right" id="action-done">Complete</a></li>
			<li><a href="#" data-role="button" data-icon="forward" data-iconpos="right">Postpone</a></li>
			<li><a href="#" data-role="button" data-icon="edit" data-iconpos="right" id="action-edit">Edit</a></li>
			<li><a href="#" data-role="button" data-icon="delete" data-iconpos="right" id="action-delete">Delete</a></li>
		</ul>
		
	</div><!-- /right panel (actions) -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#" class="ui-btn-active" data-transition="flip">Tasks</a></li>
				<li><a href="#left-panel" data-transition="flip">Agenda</a></li>
				<li><a href="#page-lists" data-transition="flip">Lists</a></li>
				<li><a href="#page-notes" data-transition="flip">Notes</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content" >	
		<!-- Place your content below-->
		<form onsubmit="return false;">
			<input type="text" name="addnew" id="addnew" value="" placeholder="Type to add new task for today" autocomplete="off"/>
		</form>
		
		<ul id="taskslist" data-role="controlgroup">
		<!-- 
			<li>
				<label>
					<input type="checkbox" name="checkbox-0 ">Check me<img src="/img/tools.png" style="float:right"/>
				</label>
			</li>
		 -->
		</ul>
		




<!-- Place your content above-->	
	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="e">
		<h6>PrettyTasks 2012-2013 &copy;</h6>
	</div><!-- /footer -->
</div><!-- /page -->


<!-- Start of second page -->
<div data-role="page"  id="page-notes">

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-notes" data-position="left" data-display="push" data-theme="e">

        <h3>Left Panel: Overlay</h3>
        <p>This panel is positioned on the left with the overlay display mode. The panel markup is <em>after</em> the header, content and footer in the source order.</p>
        <p>To close, click off the panel, swipe left or right, hit the Esc key, or use the button below:</p>
        <a href="#demo-links" data-rel="close" data-role="button" data-theme="a" data-icon="delete" data-inline="true">Close panel</a>

	</div><!-- /left panel -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#page-tasks" data-transition="flip">Tasks</a></li>
				<li><a href="#" data-transition="flip">Agenda</a></li>
				<li><a href="#page-lists" data-transition="flip">Lists</a></li>
				<li><a href="#page-notes" class="ui-btn-active" data-transition="flip">Notes</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
		<form onsubmit="return false;">
			<input type="text" name="addnew" id="addnew" value="" placeholder="Type to add new note">
		</form>
		<ul data-role="listview"  data-inset="true">
		<li>I'm first in the source order so I'm shown as the page.</li>
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		<li>I'm first in the source order so I'm shown as the page.</li>		
		</ul>
		
		

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="e">
		<h6>PrettyTasks 2012-2013 &copy;</h6>
	</div><!-- /footer -->
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page"  id="page-lists">

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-lists" data-position="left" data-display="push" data-theme="e">

        <h3>Left Panel: Overlay</h3>
        <p>This panel is positioned on the left with the overlay display mode. The panel markup is <em>after</em> the header, content and footer in the source order.</p>
        <p>To close, click off the panel, swipe left or right, hit the Esc key, or use the button below:</p>
        <a href="#demo-links" data-rel="close" data-role="button" data-theme="a" data-icon="delete" data-inline="true">Close panel</a>

	</div><!-- /left panel -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#page-tasks" data-transition="flip">Tasks</a></li>
				<li><a href="#" data-transition="flip">Agenda</a></li>
				<li><a href="#page-lists" class="ui-btn-active" data-transition="flip">Lists</a></li>
				<li><a href="#page-notes" data-transition="flip" >Notes</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
		<ul data-role="listview">
			<li><a href="#page-list-view" data-transition="flip">List 1</a></li>
			<li><a href="#">List 2</a></li>
			<li><a href="#">List 3</a></li>
			<li><a href="#">List 4</a></li>
			<li><a href="#">List 5</a></li>
			<li><a href="#">List 6</a></li>
			<li><a href="#">List 7</a></li>
			<li><a href="#">List 8</a></li>
		</ul>
		
		

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="e">
		<h6>PrettyTasks 2012-2013 &copy;</h6>
	</div><!-- /footer -->
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page"  id="page-list-view">

	<!-- left panel  -->
	<div data-role="panel" id="left-panel-lists" data-position="left" data-display="push" data-theme="e">

        <h3>Left Panel: Overlay</h3>
        <p>This panel is positioned on the left with the overlay display mode. The panel markup is <em>after</em> the header, content and footer in the source order.</p>
        <p>To close, click off the panel, swipe left or right, hit the Esc key, or use the button below:</p>
        <a href="#demo-links" data-rel="close" data-role="button" data-theme="a" data-icon="delete" data-inline="true">Close panel</a>

	</div><!-- /left panel -->

	<div data-role="header" data-position="fixed" data-theme="e">
		<div data-role="navbar">
			<ul>
				<li><a href="#page-tasks" data-transition="flip">Tasks</a></li>
				<li><a href="#" data-transition="flip">Agenda</a></li>
				<li><a href="#page-lists" class="ui-btn-active" data-transition="flip">Lists</a></li>
				<li><a href="#page-notes" data-transition="flip" >Notes</a></li>
			</ul>
		</div><!-- /navbar -->
	</div><!-- /header -->

	<div data-role="content">	
		<h1>List1</h1>

		<form onsubmit="return false;">
			<input type="text" name="addnew" id="addnew" value="" placeholder="Type to add new task for this list">
		</form>
		
		<ul id="taskslist" data-role="controlgroup">
			<li>
				<label>
					<input type="checkbox" name="checkbox-0 ">Check me
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="checkbox-1 ">Check me
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="checkbox-2 ">Check me
				</label>
			</li>
			
		</ul>
		
		

	</div><!-- /content -->

	<div data-role="footer" data-position="fixed" data-theme="e">
		<h6>PrettyTasks 2012-2013 &copy;</h6>
	</div><!-- /footer -->
</div><!-- /page -->




</body>
</html>
