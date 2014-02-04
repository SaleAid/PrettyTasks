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
		currentList:'',
		currentPage:1,
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

			$(document).on("change", "#taskslist li input[type='checkbox'] ",function(event, ui) {
				_private.changeCheckbox1(event, ui);
			});
			
			$(document).on("tap", "#noteslist li ",function(event, ui) {
				_private.loadListItem(event);
			});
			
			
			$(document).on('click', "a[class|='menu-list']", function(event){
				var name = event.target.className.split(' ')[0];
				name = name.replace('menu-list-', '');
				mobile.showList(name);
				$("#left-panel-tasks").panel("close");
				
			});
			
			$(document).on('click', "a[id='loadMore']", function(event){
				var name = _private.currentList;
				_private.currentPage++;
				var page = _private.currentPage;
				mobile.showList(name, page);
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
		    		$.mobile.loading( 'show', {html: "<span><center><img src='img/ajax-loader-m.gif' /></center><h1>Loading...</h1></span>"});
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
			var checkbox = ($(event.target).parent().parent()).find("input[type='checkbox']");
			var done = $(checkbox).is(":checked") ? 1 : 0;
			var id = $(checkbox).attr('data-id');
			mobile.srvSetDone(id, done);
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
		loadListItem: function(event){
			var id  = ($(event.target)).attr('id').replace('note-', '');;
			console.log(id);
			
			$.ajax({
				url : "/en/notes/getNote.json",
				type : "POST",
				data : {
					id 		: id,
					view	: true
				}
			}).done(function(response) {
				if (response.success){
					
					($(event.target)).html(nl2br($('<div/>').text(response.data.title).html()));
					($(event.target)).attr('style', 'white-space:normal; height: auto;');
					_private.refreshNotesList();
	                if (typeof _gaq != "undefined"){
	                    _gaq.push(["_trackEvent", "Mobile", 'getNote']);
	                }
				}else{
					mobile.createPageMessage('Cannot load note');
				}
				$.mobile.loading('hide');
			});
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
					mobile.createPageMessage('No tasks are on this list');
				}
				$.mobile.loading('hide');
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Mobile", 'getlists']);
                }
			});
		},
		listForTag : function(name, page) {
			this.showInput(true);
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
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Mobile", 'getTasksByTag']);
                }
			});
		},
		listForDate : function(date) {
			if (date === undefined) {
				date = _private.today;
			}
			this.showInput(true);
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
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Mobile", 'getTasksForDay']);
                }
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
			newItem.appendTo('#taskslist div.ui-controlgroup-controls');//.ui-controlgroup-controls


		},
		createLinkLoadMore: function(){
			mobile.removeLinkLoadMore();
			var newItem = $('<div style="text-align:center; padding-top: 20px;" id="loadMoreDiv"><a href="#" id="loadMore">Load more...</a></div>');
			newItem.insertAfter('#taskslist div.ui-controlgroup-controls');
		},
		removeLinkLoadMore: function(){
			if ($('#loadMoreDiv')){
				$('#loadMoreDiv').remove();
			}
		},
		createNoteListItem: function(Note){
			var newItem = $('<li class="ui-li ui-li-static ui-btn-up-c" id="note-' + Note.id + '">' + $('<div/>').text(Note.title).html() + '</li>');
			newItem.appendTo('#noteslist');
		},
		createPageMessage : function(message) {
			$('#taskslist li .ui-first-child ').removeClass('ui-first-child');
			$('#taskslist li .ui-last-child ').removeClass('ui-last-child');
			var newItem = $('<li id="li-message">	<label>	' + message + '</label></li>');
			newItem.appendTo('#taskslist div.ui-controlgroup-controls ');
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
	                if (typeof _gaq != "undefined"){
	                    _gaq.push(["_trackEvent", "Mobile", 'getNotes']);
	                }
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
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Mobile", 'addNewTask']);
                }
			});
		},
		srvSetDone : function(id, done) {
			$.ajax({
				url : "/en/tasks/setDone.json",
				type : "POST",
				data : {
					id : id,
					done : done
				}
			}).done(function(response) {
				mobile.scrSetDone(response.data.id, response.data.done);
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Mobile", 'setDone']);
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
			$("#taskslist div.ui-controlgroup-controls ").children().remove();
			this.removeLinkLoadMore();
		},
		showList: function(name, page){
			if (name === undefined) {
				name = _private.defaultList;
			}
			if (page === undefined) {
				page = 1;
			}
			_private.currentList =  name;
			_private.currentPage = page;
			this.showInput(false);
			if (page==1){
				mobile.clearTaskList();
			}
			$.ajax({
				url : "/en/tasks/getTasksByType.json",
				type : "POST",
				data : {
					type : name,
					page : page 
				}
			}).done(function(response) {
					$.each(response.data.list, function(index, Task) {
						mobile.createTaskListItem(Task);
					});
					_private.refreshTasksList();
					if (page==1){
						mobile.createLinkLoadMore();
					}
					if (response.data.list.length <10){
						mobile.removeLinkLoadMore();
					}
					
					$.mobile.loading('hide');
	                if (typeof _gaq != "undefined"){
	                    _gaq.push(["_trackEvent", "Mobile", 'getTasksByType']);
	                }
			});
		},
		showMessage: function(message){
			var $this = $( this ),
			  theme = "a";
			  $.mobile.loading( 'show', {
				  text: message,
				  textVisible: true,
				  theme: theme,
				  textonly: true
			  });
			  setTimeout('$.mobile.loading( "hide" )', 1000 );
		},
		showInput: function(show){
			if (show === undefined) {
				show = true;
			}
			if(show){
				$('#addTaskForm').show( 500 );	
			}else{
				$('#addTaskForm').hide("slow");	
			}
		}
	};

}());

function nl2br (str, is_xhtml) {
	  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
	  return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}
