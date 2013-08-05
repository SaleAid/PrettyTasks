$(document).ready(function() {
	mobile.init();
});

var mobile = (function() {
	var _private = {
		today : null,
		defaultList: 'planned',
		initEvents : function() {

			$.mobile.page.prototype.options.addBackBtn = true;
			$.mobile.page.prototype.options.backBtnText = "previous";

			$("#addnew").bind('keypress', function(e) {
				var code = (e.keyCode ? e.keyCode : e.which);
				if (code == 13) {
					var title = $(this).val();
					console.log(title);
					// var date = $(this).attr('date');
					// userEvent('create', {title: title, date: date });
					$(this).val(null);

					mobile.add2Server(title);
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
				console.log('tap');
				_private.changeCheckbox2(event, ui);
			});

			$(document).on("vmouseup", "#taskslist li", function() {
				event.preventDefault();
				return false;
			});
			
			$(document).on('click', "a[class|='menu']", function(event){
				var name = event.target.className.split(' ')[0];
				name = name.replace('menu-', '');
				mobile.showList(name);
			});

			$("#right-panel-tasks").on("panelclose", function(event, ui) {
				// $("#taskslist input[type='checkbox']:checked" ).prop(
				// "checked", false ).checkboxradio( "refresh" );
			});

			$("#right-panel-tasks").on("panelopen", function(event, ui) {
				console.log('open');
				prepareActionBarButtons();
				// $("#taskslist input[type='checkbox']:checked" ).prop(
				// "checked", false ).checkboxradio( "refresh" );
			});

			$("body").removeClass('hidden');
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
		},
		changeCheckbox1 : function(event, ui) {
			console.log('taphold');
			$("#taskslist li input[type='checkbox'] ").removeClass('pt-marked');
			var checkbox = ($(event.target).parent().parent().parent()).find("input[type='checkbox']");
			console.log(event.target);
			console.log(checkbox);
			$(checkbox).addClass('pt-marked');
			var done = $(checkbox).is(":checked") ? 1 : 0;
			var id = $(checkbox).attr('data-id');
			mobile.srvSetDone(id, done);

			// $("#right-panel-tasks" ).panel( "open" );
			// var done = $("#taskslist
			// input[type='checkbox'].pt-marked" ).prop( "checked");
			// console.log(done);
			mobile.scrSetDone(id, done);
			event.preventDefault();
			return false;
		},
		changeCheckbox2 : function(event, ui) {
			console.log('taphold');
			$("#taskslist li input[type='checkbox'] ").removeClass('pt-marked');
			var checkbox = ($(event.target).parent().parent().parent()).find("input[type='checkbox']");
			console.log(event.target);
			console.log(checkbox);
			$(checkbox).addClass('pt-marked');
			var done = $(checkbox).is(":checked") ? 0 : 1;
			var id = $(checkbox).attr('data-id');
			mobile.srvSetDone(id, done);

			// $("#right-panel-tasks" ).panel( "open" );
			// var done = $("#taskslist
			// input[type='checkbox'].pt-marked" ).prop( "checked");
			// console.log(done);
			mobile.scrSetDone(id, done);
			event.preventDefault();
			return false;
		}

	};

	return {
		init : function() {
			_private.initEvents();
			_private.initVariables();
			mobile.listForDate();// Load list for today
		},
		listForDate : function(date) {
			if (date === undefined) {
				date = _private.today;
			}
			$.ajax({
				url : "/ru/tasks/getTasksForDay.json",
				type : "POST",
				data : {
					date : date
				},
				beforeSend : function(xhr) {

				}
			}).done(function(response) {
				if (console && console.log) {
					console.log(response);
					$.each(response.data.list, function(index, value) {
						console.log(value);
						mobile.createListItem(value);
					});
				}
			});

		},
		createListItem : function(Task) {
			$('#taskslist li .ui-last-child ').removeClass('ui-first-child');
			$('#taskslist li .ui-last-child ').removeClass('ui-last-child');
			var checked = Task.done == 1;
			var checkedStr = checked ? 'checked="checked"' : '';
			var newItem = $('<li>	<label>	<input type="checkbox" name="checkbox-' + Task.id + '" data-id="' + Task.id + '" ' + checkedStr + '>'
					+ Task.title + '</label></li>');
			newItem.appendTo('#taskslist .ui-controlgroup-controls');
			$('#taskslist').trigger("create");
			$("#taskslist li:first-child").find('label').addClass('ui-first-child');
			$("#taskslist li:last-child").find('label').addClass('ui-last-child');
			$("#left-panel").panel("open");

		},
		add2Server : function(title, date) {
			if (date === undefined) {
				date = _private.today;
			}
			$.ajax({
				url : "/ru/tasks/addNewTask.json",
				type : "POST",
				data : {
					title : title,
					date : date
				},
				beforeSend : function(xhr) {

				}
			}).done(function(response) {
				if (console && console.log) {
					console.log(response);
					mobile.createListItem(response.data);
					$("#addnew").focus();
					$("#addnew").trigger('change');
				}
			});
		},
		srvSetDone : function(id, done) {
			$.ajax({
				url : "/ru/tasks/setDone.json",
				type : "POST",
				data : {
					id : id,
					done : done
				},
				beforeSend : function(xhr) {

				}
			}).done(function(data) {
				if (console && console.log) {
					console.log(data);
				}
			});
		},
		scrSetDone : function(id, done) {
			if (+done) {
				//$("#taskslist input[type='checkbox'].pt-marked" ).prop(
				//"checked", true ).checkboxradio( "refresh" );
				//$("#checkbox-" + id + ":parent label").parent().parent().addClass('complete');
			} else {
				// $("#taskslist input[type='checkbox'].pt-marked" ).prop(
				// "checked", false ).checkboxradio( "refresh" );
				//$("#checkbox-" + id + ":parent label").parent().parent().removeClass('complete');
			}
		},
		showList: function(name){
			console.log('showList: ' + name);
			if (name === undefined) {
				name = _private.defaultList;
			}
			$.ajax({
				url : "/ru/tasks/getTasksByType.json",
				type : "POST",
				data : {
					type : name
				},
				beforeSend : function(xhr) {

				}
			}).done(function(response) {
				if (console && console.log) {
					console.log(response);
					$.each(response.data.list, function(index, value) {
						console.log(value);
						mobile.createListItem(value);
					});
				}
			});
		}
	};

}());

// Need to rewrite
/*
 * $(document).ready( function() {
 * 
 * 
 * 
 * $("#right-panel-tasks #action-delete").on( "click", function(event, ui) {
 * $('#taskslist li .ui-last-child ').removeClass( 'ui-first-child');
 * $('#taskslist li .ui-last-child ').removeClass( 'ui-last-child');
 * $("#taskslist input[type='checkbox'].pt-marked") .parent().parent().remove();
 * $('#taskslist').trigger("create"); $("#taskslist
 * li:first-child").find('label').addClass( 'ui-first-child'); $("#taskslist
 * li:last-child").find('label').addClass( 'ui-last-child');
 * $("#right-panel-tasks").panel("close"); });
 * 
 * $("#right-panel-tasks #action-edit").on( "click", function(event, ui) {
 * console.log('Edit'); console.log($(document).find( '#taskslist li:last-child
 * label'));
 * 
 * });
 * 
 * $("#right-panel-tasks #action-done").on("click", function(event, ui) {
 * console.log('Done'); console.log(event);
 * 
 * prepareActionBarButtons(); });
 * 
 * function prepareActionBarButtons() { var done = $("#taskslist
 * input[type='checkbox'].pt-marked") .prop("checked"); if (+done) {
 * $("#right-panel-tasks #action-done .ui-btn-text").text( "Incomplete"); } else {
 * $("#right-panel-tasks #action-done .ui-btn-text").text( "Complete"); } } ;
 * 
 * });
 * 
 */
