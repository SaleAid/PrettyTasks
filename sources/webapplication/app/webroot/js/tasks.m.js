//-------------------------------------
function superAjax(url, data) {
	var result = null;
	$.ajax({
		url : url,
		type : 'POST',
		data : data,
		success : function(data) {
			responseHandler(data.result);
		},
		error : function(xhr, ajaxOptions, thrownError) {
			if (xhr.status != '200') {
				reload();
			}
		}
	});
}

function userEvent(action, data) {
	switch (action) {
	case 'create':
		taskCreate(data.title, data.date);
		break;
	case 'setDone':
		taskSetDone(data.id, data.done);
		break;
	}
}

function responseHandler(data) {
	switch (data.action) {
	case 'create':
		onCreate(data);
		break;
	case 'setDone':
		onSetDone(data);
		break;
	}
}

function showMessage(message){
	// Remove loading message.
	// hideMsg();

	// show error message
	$.mobile.showPageLoadingMsg( $.mobile.pageLoadErrorMessageTheme, message, true );

	// hide after delay
	setTimeout( $.mobile.hidePageLoadingMsg, 1500 );
	
}

// ----------------setDone-------
function taskSetDone(id, done) {
	scrSetDone(id, done);
	srvSetDone(id, done);
}
function onSetDone(data) {
	var message = ' is successfully opened';
	if(+data.data.Task.done){
		message = ' is successfully completed'; 
	}
	showMessage("Task " + data.data.Task.title + message);
	// showMessage(""+data.message.message);
}
function srvSetDone(id, done) {
	superAjax('/tasks/setDone.json', {
		id : id,
		done : done
	});
}
function scrSetDone(id, done) {
	if (+done) {
		// console.log("Yes-label[for='checkbox-" + id + "']");
		$("label[for='checkbox-" + id + "']").addClass('complete');
	} else {
		// console.log("NO-label[for='checkbox-" + id + "']");
		$("label[for='checkbox-" + id + "']").removeClass('complete');
	}
}

// ----------------create --------
function taskCreate(title, date){
    srvCreate(title, date);
}
function onCreate(data){
    if(data.success){
        scrCreate(data);   
    }
    showMessage(""+data.message.message);
}
function srvCreate(title, date){
    superAjax('/tasks/addNewTask.json',{title: title, date: date });
}
function scrCreate(data){
	console.log(data);
    date = data.data.Task.date;
    if(data.data.Task.future){
        date = 'future';    
    }
    AddTask(data.data)
    // $("ul[date='"+date+"']").append(AddTask(data.data));
}
function AddTask(data){
    var taskHTML = '<input type="checkbox" data-id="'+data.Task.id+'" name="checkbox-'+data.Task.id+'" id="checkbox-'+data.Task.id+'" class="custom" />'+
    '<label for="checkbox-'+data.Task.id+'"  >'+data.Task.title+'</label>'; //TODO check title
    var Container = $("#incomplete-"+data.Task.date);
    Container.append(taskHTML);
    Container.trigger('create');
}

// Add event handlers
$(document).ready(function() {
	// Handle user click on checkbox
	$("input[type='checkbox']").live("change", function(event, ui) {
		var done = $(this).is(":checked") ? 1 : 0;
		var id = $(this).attr('data-id');
		userEvent('setDone', {
			id : id,
			done : done 
		});
	});
	// Handle user click on checkbox
	$(".span3").bind('keypress', function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
            var title = $(this).val();
            var date = $(this).attr('date');
            userEvent('create', {title: title, date: date });
            $(this).val(null);
        }
        
	});
});
