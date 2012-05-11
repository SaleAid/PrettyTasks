
function getTaskForEdit(id){
    return getTaskFromPage(id);
}

function getTaskFromPage(id){
    var data = {
        title:   $('#'+id).children('.editable').text(),
        done:    $('#'+id).children('.done').is(":checked"),
        date:    $('#'+id).attr('date'),
        time:    $('#'+id).children('.time').text(),
        comment: 'comment'   
    };
    return data;
}

function mesg (message){
    $.jGrowl.defaults.pool = 2;
    $.jGrowl(message.message, { 
                    glue: 'before',
                    position: 'custom',
                    theme: message.type,
                    speed: 'slow',
                    life: '1000',
					animateOpen: { 
						height: "show"
					},
					animateClose: { 
						height: "hide"
					}
     });
}

function checkLogin(){
    $.ajax({
        type: "POST",
        url: "/users/checkLogin",
        success: function (status) {
                if(!status){
                   reload();
                }
        },
        error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status != '200'){
                    reload();
                }
       }
    });
}
//-------------------------------------
function superAjax(url, data){
     var result = null;
     $.ajax({
            url:url,
            type:'POST',
            data: data,
            success: function(data) {
                responseHandler(data.result);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status != '200'){
                    reload();
                }
            }
     });
}

function userEvent(action, data){
    switch(action){
        case 'create':
            taskCreate(data.title, data.date);
        break;
        case 'setTitle':
            taskSetTitle(data.id, data.title);
        break;
        case 'setDone':
            taskSetDone(data.id, data.done);
        break;
        case 'delete':
            taskDelete(data.id);
        break;
        case 'dragOnDay':
            taskDragOnDay(data.id, data.date, data.time);
        break;
        case 'changeOrders':
            taskChangeOrders(data.id, data.position);
        break; 
        case 'edit':
            taskEdit(data.id, data.title, data.done, data.date, data.time, data.comment);
        break;
        case 'addDay':
            taskAddDay(data.date);
        break;          
        case 'deleteDay':
            taskDeleteDay(data.date);
        break;      
    }
}

function responseHandler(data){
    switch(data.action){
        case 'create':
             onCreate(data);
        break;
        case 'setTitle':
            onSetTitle(data);
        break;
        case 'setDone':
            onSetDone(data);
        break;
        case 'delete':
            onDelete(data);
        break;
        case 'dragOnDay':
            onDragOnDay(data);
        break;
        case 'changeOrders':
            onChangeOrders(data);
        break;
        case 'edit':
            onEdit(data);
        break;
        case 'addDay':
            onAddDay(data);
        break;
        case 'deleteDay':
            onDeleteDay(data);
        break;
    }
}
//---------------deleteDay------
function taskDeleteDay(date){

    scrDeleteDay(date);
    srvDeleteDay(date);    
}
function scrDeleteDay(date){
    //var tabid = $('#main ul.nav-tabs a[date="'+date+'"]').parent();
    $("#" + date).remove();
    $('#main ul.nav-tabs a[date="'+date+'"]').parent().remove();
    var now = new Date();
    activeTab($.datepicker.formatDate( "yy-mm-dd", now));
     
}
function srvDeleteDay(date){
    superAjax('/tasks/deleteDay.json',{date: date});
}

function onDeleteDay(data){
    mesg(data.message);
}

//---------------addDay---------
function taskAddDay(date){

    if(scrAddDay(date)){
        srvAddDay(date);    
    }
}

function scrAddDay(date){
    var flag = true;
    $("#main ul:first li").each(function(){
        if($(this).children('a').attr('date') == date){
            flag = false;
        }
    });
    if(!flag){
        activeTab(date);
        return false;    
    }
    var newTabContent = '<div class="tab-pane" id="'+date+'"> \
                    <div class="row"> \
                        <div class="span10"> \
                            <div class="well form-inline"> \
                                <input type="text" class=" createTask input-xxlarge" placeholder=" +Добавить задание…"/> \
                            </div> \
                            <hr /> \
                            <ul class="sortable connectedSortable ui-helper-reset" date="'+date+'"> \
                                <p class="loadContent" align=center> Loading content ...</p> \
                            </ul> \
                        </div> \
                    </div> \
                </div>';
                
    $('.tab-content').append(newTabContent);
    $('#main ul.nav-tabs').append('<li class="drop"><a href="#'+date+'" data-toggle="tab" date="'+date+'">'+date+'<span class="close">×</span></a></li>');
    initTab('#main a[data-toggle="tab"]');
    activeTab(date);
    
    return true;
}
function activeTab(date){
    $('div.active').removeClass('active').removeClass('in');
    $('li.active').removeClass('active');
    $('#main ul.nav-tabs a[date="'+date+'"]').tab('show');
}

function srvAddDay(date){
    superAjax('/tasks/getTasksForDay.json',{date: date});
}

function onAddDay(data){
    var list = $("ul[date='"+data.data.date+"']");
    list.children('.loadContent').remove();
    $.each(data.data.list,function(index, value) {
        list.append(AddTask(value));
        initDelete( "li[id='"+value.Task.id+"'] .deleteTask");
        initEditAble("li[id='"+value.Task.id+"'] .editable");
        initDone("li[id='"+value.Task.id+"'] .done");
        initEditTask("li[id='"+value.Task.id+"'] .editTask");
    });
    initCreateTask($("ul[date='"+data.data.date+"']").parent().find(".createTask"));
    initDrop($("li a[date='"+data.data.date+"']").parent());
    initSortable("ul[date='"+data.data.date+"'].sortable");
    
    initTabDelte("li a[date='"+data.data.date+"'] .close");
    
}

// --------------setDate--------

function scrDate(id, date){
    var task = $("li[id='"+id+"']");
    if(date){
        task.attr('date',date);    
    }else{
        task.attr('date','');
    }
}

//----------------setTime-------
function scrTime(id, time){
    var task = $("li[id='"+id+"']");
    if(time){
        task.find('.time').text(time);    
    }else{
      $(task.find('.time').text(''));
    }
}

//----------------edit----------
function taskEdit(id, title, done, date, time, comment){

    scrEdit(id, title, done, date, time, comment);
    srvEdit(id, title, done, date, time, comment);
}
function onEdit(data){
    if(data.success){
        $('#editTask').modal('hide');
        scrSetTitle(data.data.Task.id, data.data.Task.title, data.data.Task.priority);
    }
    mesg(data.message);
}
function srvEdit(id, title, done, date, time, comment){
    superAjax('/tasks/editTask.json',{id: id, title: title, done: done, date: date, time: time, comment: comment});
}

function scrEdit(id, title, done, date, time, comment){
    scrDragWithTime(id, date, time);
    scrDate(id,date);
    scrSetDone(id,done);
    scrSetTitle(id, title, 0);
    scrTime(id, time);
}


function scrDragWithTime(id, date, time){
        var task = $("li[id='"+id+"']");
        if(!date){
            var list = $("ul[date='future']");
        }else{
            var list = $("ul[date='"+date+"']");    
        }
        var timeList = list.find('li.setTime');
        var newPositionID;
        var preTime;
        var curTime;
        var change = $.trim(task.find('.time').text())!= time || task.attr('date') != date;
        if(change){
            if(time){
                timeList.each(function() { 
                    curTime =$.trim($(this).find('.time').text())
                    if(time > curTime && curTime.length > 0){
                        if(newPositionID){
                            if(preTime <= curTime){
                                newPositionID = $(this).attr('id');
                                preTime = curTime;    
                            } 
                        }else{
                            preTime = curTime;
                            newPositionID = $(this).attr('id');    
                        }
                    }
                });
                if(newPositionID == id){
                    newPositionID ='';
                }
           }
           console.log(newPositionID);
           task.hide( "slow", function() {
                if(newPositionID){
                    $(this).insertAfter($("li[id='"+newPositionID+"']")).show('slow');
                    $(this).addClass('setTime');
                }else{
                    if(change){
                        if(list.children().length){
                            if(task.attr('date') != date){
                                $(this).prependTo(list).show('slow');        
                            }else{
                                $(this).show('slow')
                            }
                                
                        }else{
                            $(this).appendTo(list).show('slow');
                        }
                    }else{
                        $(this).show('slow');
                    }                    
                }
                if(time){
                    $(this).addClass('setTime');
                }else{
                    $(this).removeClass('setTime');
                }
                $(this).attr('date', date);
                $(this).css({'opacity':'1'});
            });
        }
}


//----------------changeOrder---
function taskChangeOrders(id, position){
    scrChangeOrders(id, position);
    srvChangeOrders(id, position);
}
function onChangeOrders(data){
    mesg(data.message);
}
function srvChangeOrders(id, position){
    superAjax('/tasks/changeOrders.json',{id: id, position: position});
}
function scrChangeOrders(id, position){
    $("li[id='"+id+"']").css("color","");
}

//----------------dragOnDay-----
function taskDragOnDay(id, date, time){
    scrDragOnDay(id, date, time);
    srvDragOnDay(id, date, time);
}
function onDragOnDay(data){
    mesg(data.message);
}
function srvDragOnDay(id, date, time){
    if(date == 'future'){
        date = '';
    }
    superAjax('/tasks/dragOnDay.json',{id: id,date: date, time:time});
}
function scrDragOnDay(id, date, time){
    scrDragWithTime(id, date, time);
}

//----------------delete--------
function taskDelete(id){
    scrDelete(id);
    srvDelete(id);
}
function onDelete(data){
    mesg(data.message);
}
function srvDelete(id){
    superAjax('/tasks/deleteTask.json',{id: id});
}
function scrDelete(id){
    $("li[id='"+id+"']").remove();;
}

//----------------setDone-------
function taskSetDone(id, done){
    srvSetDone(id, done);
}
function onSetDone(data){
    scrSetDone(data.data.Task.id, data.data.Task.done);
    mesg(data.message);
}
function srvSetDone(id, done){
    superAjax('/tasks/setDone.json',{id:id, done: done});
}
function scrSetDone(id, done){
    var titleEl = $("li[id='"+id+"']").find('.editable');
    var doneEl = $("li[id='"+id+"']").find('.done');
    if(+done){
        titleEl.addClass('complete');
        doneEl.attr('checked', 'checked');
         $("li[id='"+id+"']").addClass('complete')
    }else{
        titleEl.removeClass('complete');
        $("li[id='"+id+"']").removeClass('complete');
        doneEl.removeAttr('checked');
    }
}

//----------------setTitle------
function taskSetTitle(id, title){
    srvSetTitle(id, title);
}
function onSetTitle(data){
    scrSetTitle(data.data.Task.id, data.data.Task.title, data.data.Task.priority);
    mesg(data.message);
}
function srvSetTitle(id, title){
    superAjax('/tasks/setTitle.json',{id: id, title: title});
}
function scrSetTitle(id, title_text, priority){
    var title = $("li[id='"+id+"']").find('.editable');
    title.text(title_text);   
    if(priority == 1){
        title.addClass('important');
    }else{
        $("li[id='"+id+"']").removeClass('important');
    }
}

//----------------create -------- 
function taskCreate(title, date){
    srvCreate(title, date);
}
function onCreate(data){
    if(data.success){
        scrCreate(data);   
    }
    mesg(data.message);
}
function srvCreate(title, date){
    superAjax('/tasks/addNewTask.json',{title: title, date: date });
}
function scrCreate(data){
    date = data.data.Task.date;
    if(data.data.Task.future){
        date = 'future';    
    }
    $("ul[date='"+date+"']").append(AddTask(data.data));
    initDelete("li[id='"+data.data.Task.id+"'] .deleteTask");
    initEditAble("li[id='"+data.data.Task.id+"'] .editable");
    initDone("li[id='"+data.data.Task.id+"'] .done");
    initEditTask("li[id='"+data.data.Task.id+"'] .editTask");    	
    
}
function AddTask(data){
    var important ='';
	var setTime ='';
    var time = '<span class="time"></span>';
    if (+data.Task.priority){
		important = 'important';
	}
    if (data.Task.time){
		setTime = 'setTime ';
        time = '<span class="time">'+data.Task.time.slice(0,-3)+'</span>'; 
	}
    taskHtml = '<li id ="'+data.Task.id+'" class="ui-state-default '+setTime+'" date="'+data.Task.date+'"> \n'+ 
                            time+'\n'+
                            '<span><i class="icon-move"></i></span> \n'+
                            '<input type="checkbox" class="done" value="1"/> \n' +
                            '<span class="editable input-xxlarge '+important+'">'+data.Task.title+'</span> \n'+
                            '<span class="editTask"><i class="icon-pencil"></i></a></span> \n'+
                            '<span class="deleteTask"><i class=" icon-ban-circle"></i></span> \n'+
                '</li>';
    return taskHtml;
}
//-------------------------------------

function initEditAble(element){
         $(element).editable(function(value, settings) { 
                    var id = $(this).parent().attr('id');   
                    userEvent('setTitle', {id: id, title: value });
                    return value;
             }
             ,{
                //cssclass : 'inlineform',
                //width: 616,
                //height: 19,
                indicator : "<img src='img/indicator.gif'>",
                placeholder : "",
                tooltip : "Щелкните чтоб отредактировать этот текст",
                style  : "inherit"
        });
}
function initDelete(element){
    $(element).inlineConfirmation({
              //reverse: true,
              confirm: "<a href='#'><i class='icon-ok-sign'></i></a>",
              cancel: "<a href='#'><i class='icon-remove-sign '></i></a>",
              separator: "| ",
              expiresIn: 3,
              bindsOnEvent: "click",
              confirmCallback: function(el) {
                 el.parent().fadeIn();
                 var id = el.parent().attr('id');
                 userEvent('delete', {id: id});
              },
              cancelCallback: function(el) {
                 //mesg('Отмена удаления .');
              },
    });
}

function initDone(element){
    $(element).on("click", function(){
        var id = $(this).parent().attr('id');
        var done = $(this).is(":checked")? 1 : 0;
        userEvent('setDone', {id: id, done: done});
    });
}

function initEditTask(element){
     $(element).on("click", function(){
            var task = getTaskForEdit($(this).parent().attr('id'));
            $('#editTask').attr('task_id', $(this).parent().attr('id'));
            $('#editTask').find('#eTitle').val(task.title);
            if(task.done){
                $('#editTask').find('#eDone').attr('checked','checked');
            }else {
                $('#editTask').find('#eDone').removeAttr('checked');
            }
            $('#eTime').val(task.time);
            $( "#eDate" ).val(task.date);
            if(!task.date){
                $( "#eDate" ).attr('placeholder', '---FUTURE---');
            }
            $('#editTask').modal('show');
    });
}

function initCreateTask(element){
    $(element).on('keypress', function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
            var title = $(this).val();
            var date = $(this).parent().siblings("ul").attr('date');
            if(date == 'future'){
                date = '';
            }
            userEvent('create', {title: title, date: date });
            $(this).val(null);
        }
    });
}

function initDrop(element){
    var $tabs = $( "#main" ).tab();
    $(element, $tabs ).droppable({
             tolerance:'pointer', 
             accept: ".connectedSortable li",
             hoverClass: "hover", 
             drop: function( event, ui ) {
                dropped = true;
                var id = ui.draggable.attr('id');
                var date = $(this).find( "a" ).attr( "date" );
                var time = $.trim(ui.draggable.children('.time').text());
                userEvent('dragOnDay', {id: id, date: date, time:time});
                $(ui).parent().sortable('cancel');
            } 
    }).disableSelection();
}

function initSortable(element){
    $(element).sortable({
            tolerance:'pointer',
            cancel: '.ui-state-disabled',
            opacity: 0.6, 
            cursor: 'move', 
            placeholder: "ui-state-highlight",
            handle: 'span .icon-move',
            update : function(e, ui){
                if(ui.item.parent().attr('date') == 'expired'){
                    $(this).css("color","");
                    return false;  
                }
                if(ui.item.hasClass('setTime')){
                    $(this).css("color","");
                    return false;    
                }
                if(dropped){
                    dropped = false;
                    return true;
                }
                var id = ui.item.attr('id');
                var position = ui.item.index()+1;
                userEvent('changeOrders', {id: id, position: position});
            },
          stop: function(event, ui) {
                if(dropped){
                    dropped = false;
                    return true;
                }
        },
        
    }).disableSelection();
}
function initTab(element){
     $(element).on('shown', function (e) {
            window.location.hash=e.target.hash;
      })
}

function initTabDelte(element){
    $(element).on('click', function() {
        var date = $(this).parent().attr('date');
        userEvent('deleteDay', {date:date});
    });
}

function reload(){
    location.reload();
}

var dropped = false;
$(function(){

//-------------------------------- work tesk

       if(window.location.hash != "") { 
            $('#main a[href="'+window.location.hash+'"]').tab('show');
       } 
     $.datepicker.setDefaults(
        $.extend($.datepicker.regional["ru"])
     );

    setInterval(function() {
        checkLogin();
    }, 120000);
    initTab('#main a[data-toggle="tab"]');
    initCreateTask(".createTask");
    initCreateTask("#future input");
    initEditAble(".editable");
    initDelete(".deleteTask");
    initDone(".done"); 
    initEditTask(".editTask");   
    initDrop("ul:first li.drop");
    initSortable(".sortable");
    initTabDelte('li a[data-toggle="tab"] .close');
    // edit task, modal window      
    $('#eTime').timepicker({
                    timeFormat: 'HH:mm',
                    interval: 15,
    });
    
    $( "#eDate" ).datepicker({ 
                    dateFormat: 'yy-mm-dd',
                    showAnim: 'clip',
                    minDate: 0,
    });
            
    $("#eSave").click(function(){
            var id = $('#editTask').attr('task_id');
            var title = $.trim($('#editTask').find('#eTitle').val());
            var done = $.trim($('#editTask').find('#eDone').is(":checked")? 1: 0);
            var date = $.trim($( "#eDate" ).val());
            var time = $.trim($('#eTime').val());
            var comment = $('#eComment').val();
            userEvent('edit',{id: id,title: title, done: done, date: date, time: time, comment: comment });
    });
    
  // add new day into tabs
    $("#addDay").button().click(function(e) {
        var dp = $('#dp');
        dp.datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'clip',
            onSelect: function(date) {
                userEvent('addDay',{date: date});
            },
        });
        if (dp.datepicker('widget').is(':hidden')) {
            dp.datepicker("show");
        } else {
            dp.hide();
        }
        e.preventDefault();
    }).disableSelection();

                   
}); 	
  

  //end  http://lecterror.com/articles/view/cakephp-and-the-infamous-remember-me-cookie
