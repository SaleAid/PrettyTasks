$(document).ready(function() {
	mobile.init();
});

var mobile = (function() {
	var _private = {
		today : null,
		defaultList: 'planned',
		currDate:null,
		tasksAreLoaded: false,
		notesAreLoaded: false,
		tagsAreLoaded: false,
		initEvents : function() {

			$.mobile.page.prototype.options.addBackBtn = true;
			$.mobile.page.prototype.options.backBtnText = "previous";
			

			$("#addnew").bind('keypress', function(e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) {
					var title = $(this).val();
					$(this).val(null);
					mobile.add2Server(title, _private.currDate);
					return false;
				}

			});

			$(document).on("swipeleft swiperight", "#page-tasks", function(e) {
				if ($.mobile.activePage.jqmData("panel") !== "open") {
					if (e.type === "swiperight") {
						$("#left-panel-tasks").panel("open");
					}
					if (e.type === "swipeleft") {
						$("#right-panel-tasks").panel("open");
					}
				}
			});

			$(document).on("taphold", "#taskslist li ", function(event, ui) {
				_private.changeCheckbox1(event, ui);
			});

			$(document).on('click', '.ui-icon-checkbox-on, .ui-icon-checkbox-off', function(event, ui) {
				//console.log('tap');
				_private.changeCheckbox1(event, ui);//todo2
			});
			
			$(document).on('click', '*', function(event, ui) {
				//console.log('click');
				//console.log(event);
			});
			
			$(document).on('tap', '*', function(event, ui) {
				//console.log('tap');
				//console.log(event);
			});

			$(document).on("vmouseup", "#taskslist li", function() {
				event.preventDefault();
				return false;
			});
			
			$(document).on('click', "a[class|='menu-list']", function(event){
				var name = event.target.className.split(' ')[0];
				name = name.replace('menu-list-', '');
				mobile.showList(name);
				$("#left-panel-tasks").panel("close");
			});
			
			$(document).on('click', "a[class|='tag-list']", function(event){
				var name = event.target.className.split(' ')[0];
				name = name.replace('tag-list-', '');
				_private.currDate = name;
				mobile.listForTag(name);
				$("#right-panel-tasks").panel("close");
			});
			
			$(document).on('click', "a[class|='menu-day']", function(event){
				var name = event.target.className.split(' ')[0];
				date = name.replace('menu-day-', '');
				if (date=='today'){
					date = _private.today;
				}
				if (date=='tomorrow'){
					//TODO
					//date = _private.today;
				}
				_private.currDate = date;
				mobile.listForDate(date);
				$("#left-panel-tasks").panel("close");
			});

			$("#right-panel-tasks").on("panelclose", function(event, ui) {

			});

			$("#right-panel-tasks").on("panelopen", function(event, ui) {
	    		if (_private.tagsAreLoaded) return;
	    		mobile.listOfTags();
	    		_private.tagsAreLoaded = true;
			});

			$("body").removeClass('hidden');
			
		    $.ajaxSetup({ 
		        beforeSend: function(xhr, settings) {  
		            var csrfToken = $("meta[name='csrf-token']").attr('content');
		            if (csrfToken) { 
		                xhr.setRequestHeader("X-CSRFToken", csrfToken ); 
		            } 
		        } 
		    }); 
		    
		    $(document).on({
		    	 ajaxStart: function() { 
		    		 $.mobile.loading( 'show', {html: "<span><center><img src='img/ajax-loader-content.gif' /></center><h1>Loading...</h1></span>"});
		    	 },
		    	 ajaxStop: function() {

		    	 } 
		    	});
		    $(document).on( "pagechange", function( event ) { 
		    	if ($.mobile.activePage.attr('id')=='page-notes'){
					if (_private.notesAreLoaded) return;
		    		mobile.listNotes();
		    	}
		    	if ($.mobile.activePage.attr('id')=='page-tasks'){
		    		if (_private.tasksAreLoaded) return;
		    		mobile.listForDate();
		    		_private.tasksAreLoaded = true;
		    	}
		    });

		},
		initVariables : function() {
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth() + 1;
			var yyyy = today.getFullYear();
			if (dd < 10) {
				dd = '0' + dd;
			}
			if (mm < 10) {
				mm = '0' + mm;
			}
			_private.today = yyyy + "-" + mm + "-" + dd;
			_private.currDate = _private.today; 
			$( "#left-panel-tasks" ).panel( "option", "positionFixed", true );
		},
		changeCheckbox1 : function(event, ui) {
			$("#taskslist li input[type='checkbox'] ").removeClass('pt-marked');
			var checkbox = ($(event.target).parent().parent().parent()).find("input[type='checkbox']");
			$(checkbox).addClass('pt-marked');
			var done = $(checkbox).is(":checked") ? 1 : 0;
			var id = $(checkbox).attr('data-id');
			mobile.srvSetDone(id, done);
			mobile.scrSetDone(id, done);
			event.preventDefault();
			return false;
		},
		changeCheckbox2 : function(event, ui) {
			console.log('taphold');
			$("#taskslist li input[type='checkbox'] ").removeClass('pt-marked');
			var checkbox = ($(event.target).parent().parent().parent()).find("input[type='checkbox']");
			$(checkbox).addClass('pt-marked');
			var done = $(checkbox).is(":checked") ? 0 : 1;
			var id = $(checkbox).attr('data-id');
			mobile.srvSetDone(id, done);
			mobile.scrSetDone(id, done);
			event.preventDefault();
			return false;
		},
		refreshTasksList: function(){
			$('#taskslist li .ui-first-child ').removeClass('ui-first-child');
			$('#taskslist li .ui-last-child ').removeClass('ui-last-child');
			$('#taskslist').trigger("create");
			$("#taskslist li:first-child").find('label').addClass('ui-first-child');
			$("#taskslist li:last-child").find('label').addClass('ui-last-child');
			$("#left-panel").panel("open");
		},
		refreshNotesList: function(){
			$('#noteslist li  ').removeClass('ui-first-child');
			$('#noteslist li  ').removeClass('ui-last-child');
			$('#noteslist').trigger("create");
			$("#noteslist li:first-child").addClass('ui-first-child');
			$("#noteslist li:last-child").addClass('ui-last-child');
		}

	};

	return {
		init : function() {
			_private.initEvents();
			_private.initVariables();
    		if (!_private.tasksAreLoaded) {
    			mobile.listForDate();
    			_private.tasksAreLoaded = true;
    		}
		},
		listOfTags : function() {
			$.ajax({
				url : "/en/lists/getlists.json",
				type : "POST"
			}).done(function(response) {
				if (response.data.length>0){
					$.each(response.data, function(index, Tag) {
						if (!Tag.archive){
							mobile.createTagListItem(Tag);
						}
					});
					$( "#tags-list" ).listview( "refresh" );
				}else{
					//mobile.createPageMessage('No tasks are on this list');
				}
				$.mobile.loading('hide');
				
			});
		},
		listForTag : function(name) {
			mobile.clearTaskList();
			$('#addnew').attr('placeholder', 'Type to add new task for ' + name + ' list');
			$.ajax({
				url : "/en/lists/getTasksByTag.json",
				type : "POST",
				data : {
					tag : name
				}
			}).done(function(response) {
				if (response.data.tasks.length>0){
					$.each(response.data.tasks, function(index, Task) {
						mobile.createTaskListItem(Task);
					});
					_private.refreshTasksList();
				}else{
					mobile.createPageMessage('No tasks for this day');
				}
				$.mobile.loading('hide');
				
			});
		},
		listForDate : function(date) {
			if (date === undefined) {
				date = _private.today;
			}
			mobile.clearTaskList();
			$('#addnew').attr('placeholder', 'Type to add new task for ' + date);
			$.ajax({
				url : "/en/tasks/getTasksForDay.json",
				type : "POST",
				data : {
					date : date
				}
			}).done(function(response) {
				if (response.data.list.length>0){
					$.each(response.data.list, function(index, Task) {
						mobile.createTaskListItem(Task);
					});
					_private.refreshTasksList();
				}else{
					mobile.createPageMessage('No tasks for this day');
				}
				$.mobile.loading('hide');
					
				
			});
			

		},
		createTagListItem : function(Tag) {
			var newItem = $('<li><a href="#" data-id="' + Tag.name + '" class="tag-list-' + Tag.name + '">'+ $('<div/>').html(Tag.name).text() +'</a></li>');
			newItem.appendTo('#tags-list');//.ui-controlgroup-controls
		},
		createTaskListItem : function(Task) {

			var checked = Task.done == 1;
			var checkedStr = checked ? 'checked="checked"' : '';
			var className = '';
			if (+Task.priority){
				className = ' class = " important " ';
			}
			var newItem = $('<li><label '+className+'>	<input type="checkbox" name="checkbox-' + Task.id + '" data-id="' + Task.id + '" ' + checkedStr + '>'
					+ $('<div/>').html(Task.title).text() + '</label></li>');
			newItem.appendTo('#taskslist .ui-controlgroup-controls');


		},
		createNoteListItem: function(Note){

			var newItem = $('<li class="ui-li ui-li-static ui-btn-up-c">' + $('<div/>').text(Note.title).html() + '</li>');
			newItem.appendTo('#noteslist');


		},
		createPageMessage : function(message) {
			$('#taskslist li .ui-first-child ').removeClass('ui-first-child');
			$('#taskslist li .ui-last-child ').removeClass('ui-last-child');
			var newItem = $('<li id="li-message">	<label>	' + message + '</label></li>');
			newItem.appendTo('#taskslist .ui-controlgroup-controls');
			$('#taskslist').trigger("create");
			$("#taskslist li:first-child").find('label').addClass('ui-first-child');
			$("#taskslist li:last-child").find('label').addClass('ui-last-child');

		},
		listNotes : function(something) {
			$("#noteslist").children().remove();
			$.ajax({
				url : "/en/notes/getNotes.json",
				type : "POST",
				data : {
					page: 0, count: 25
				}
			}).done(function(response) {
					if (response.data.list.length>0){
						$.each(response.data.list, function(index, Note) {
							mobile.createNoteListItem(Note);
						});
						_private.refreshNotesList();
						_private.notesAreLoaded = true;
					}else{
						//mobile.createPageMessage('No tasks for this day');
					}
					$.mobile.loading('hide');
					
				});
		},
		add2Server : function(title, date) {
			if (date === undefined) {
				date = _private.today;
			}
			$.ajax({
				url : "/en/tasks/addNewTask.json",
				type : "POST",
				data : {
					title : title,
					date : date
				}
			}).done(function(response) {
				$('#li-message').remove();
				mobile.createTaskListItem(response.data);
				_private.refreshTasksList();
				$("#addnew").focus();
				$("#addnew").trigger('change');
				mobile.showMessage('Task has been added');
			});
		},
		srvSetDone : function(id, done) {
			$.ajax({
				url : "/ru/tasks/setDone.json",
				type : "POST",
				data : {
					id : id,
					done : done
				}
			}).done(function(data) {
				if (console && console.log) {
					console.log(data);
				}
			});
		},
		scrSetDone : function(id, done) {
			if (+done) {
				mobile.showMessage('Task has been closed');
			} else {
				mobile.showMessage('Task has been opened');
			}
		},
		clearTaskList: function(){
			$("#taskslist .ui-controlgroup-controls").children().remove();
		},
		showList: function(name){
			if (name === undefined) {
				name = _private.defaultList;
			}
			mobile.clearTaskList();
			$.ajax({
				url : "/en/tasks/getTasksByType.json",
				type : "POST",
				data : {
					type : name
				}
			}).done(function(response) {
					$.each(response.data.list, function(index, Task) {
						mobile.createTaskListItem(Task);
					});
					_private.refreshTasksList();
					$.mobile.loading('hide');
			});
		},
		showMessage: function(message){
			$.mobile.showPageLoadingMsg( $.mobile.pageLoadErrorMessageTheme, message, true );
			setTimeout( $.mobile.hidePageLoadingMsg, 1000 );
		}
	};

}());
