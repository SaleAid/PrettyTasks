<?php
$this->start ( 'toHead' );
?>
<?php

echo $this->Html->css ( 'fullcalendar/fullcalendar.css' );
?>
<?php

echo $this->Html->css ( 'fullcalendar/fullcalendar.print.css', null, array ('media' => 'print' ) );
?>


<style type='text/css'>
#calendar {
	width: 900px;
	margin: 0 auto;
	height: 80%;
}
.calDone{
	text-decoration: line-through;
}
</style>
<?php
$this->end ();
?>
<?php

$this->start ( 'toFooter' );
?>
<?php

echo $this->Html->script ( 'fullcalendar/fullcalendar.min.js' );
?>
<script type='text/javascript'>

	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var events = [];

		var js = $.getJSON('/Tasks/index.json', function(data) {
			//console.log(data.result.success);
			if (data.result.success){
				
				$.each(data.result.data.arrTaskOnDays.Today, function(key, value) {
					var dataToShow = {
						title: value.Task.title,
						start: new Date(value.Task.date +" "+value.Task.time),
						allDay: !value.Task.time,
						id: +value.Task.id,
						done: +value.Task.done
					};
					if (!value.Task.time){
						dataToShow.start = new Date(value.Task.date);
					}
					
				    //console.log(value.Task.title);
				    //console.log(dataToShow);
				    if (!+value.Task.done){
				    	events.push(dataToShow);
				    }
				});
				//console.log(events);
				//console.log(js);
				//console.log(events);
				$('#calendar').fullCalendar({
					header: {
						left: 'prev, next, today',
						center: 'title',
						right: 'month, agendaWeek, agendaDay'
					},
					editable: false,
					events: events,
					timeFormat: 'HH:mm',
					defaultView: 'agendaWeek',
					defaultEventMinutes: 60,
					firstDay:1,
					height: window.innerHeight*0.9,
					eventClick: function(calEvent, jsEvent, view) {
						calEvent.done = !calEvent.done;
						if (calEvent.done){
							calEvent.color = '#aaffaa';
							calEvent.className='calDone';
						}else{
							calEvent.color = '';
							calEvent.className='';							
						}
				        $('#calendar').fullCalendar('updateEvent', calEvent);
				        $('#calendar').fullCalendar( 'removeEventSource', calEvent );
				        srvSetDone(calEvent.id, +calEvent.done);
				        
					
					}
				});
			}	
		
		
		});

		
	});

/*
	[
	{
		title: 'All Day Event',
		start: new Date(y, m, 1)
	},
	{
		title: 'Long Event',
		start: new Date(y, m, d-5),
		end: new Date(y, m, d-2)
	},
	{
		id: 999,
		title: 'Repeating Event',
		start: new Date(y, m, d-3, 16, 0),
		allDay: false
	},
	{
		id: 999,
		title: 'Repeating Event',
		start: new Date(y, m, d+4, 16, 0),
		allDay: false
	},
	{
		title: 'Meeting',
		start: new Date(y, m, d, 10, 30),
		allDay: false
	},
	{
		title: 'Lunch',
		start: new Date(y, m, d, 12, 0),
		end: new Date(y, m, d, 14, 0),
		allDay: false
	},
	{
		title: 'Birthday Party',
		start: new Date(y, m, d+1, 19, 0),
		end: new Date(y, m, d+1, 22, 30),
		allDay: false
	},
	{
		title: 'Click for Google',
		start: new Date(y, m, 28),
		end: new Date(y, m, 29),
		url: 'http://google.com/'
	}
]
*/

</script>
<?php
$this->end ();
?>
<div id='calendar'></div>
