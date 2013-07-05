var rToken = "";
var clientID = "";
var oAuthToken = "";
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!

var yyyy = today.getFullYear();
if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = yyyy+"-"+mm+"-"+dd;

function initTokens(){

}

function listForToday(){
$.ajax({
  url: "/ru/tasks/getTasksForDay.json",
  type: "POST",
  data: { date: today },
  beforeSend: function ( xhr ) {

  }
}).done(function ( response ) {
  if( console && console.log ) {
	  console.log(response);
    $.each(response.data.list, function(index, value) {
    	console.log(value);
		createListItem(value);
	});
  }
});
};
function add2Server(title){
$.ajax({
  url: "/ru/tasks/addNewTask.json",
  type: "POST",
  data: { title: title, date: today },
  beforeSend: function ( xhr ) {

  }
}).done(function ( response ) {
  if( console && console.log ) {
	console.log(response);
	createListItem(response.data);
	$("#addnew").focus();
	$("#addnew").trigger('change');
  }
});
};

function srvSetDone(id, done) {
	$.ajax({
		  url: "/ru/tasks/setDone.json",
		  type: "POST",
		  data: { id: id, done: done},
		  beforeSend: function ( xhr ) {

		  }
		}).done(function ( data ) {
		  if( console && console.log ) {
			console.log(data);
		  }
		});
}
$(document).ready(function(){
	
	// Handle user click on checkbox
	/*
	$("#taskslist li input[type='checkbox'] ").on("change", function(event, ui) {
		console.log('Done');
		var done = $(this).is(":checked") ? 1 : 0;
		var id = $(this).attr('data-id');
		
		srvSetDone(id, done);

	});
	*/
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
	$("body").removeClass('hidden');

});
