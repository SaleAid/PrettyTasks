
function getTaskForEdit(id){
    return getTaskFromPage(id);
}
function getTaskFromPage(id){
    var data = {
        title:   $('#'+id).children('.editable').text(),
        done:    $('#'+id).children('.done').is(":checked"),
        date:    $('#'+id).attr('date'),
        time:    $('#'+id).children('.time').text(),
        timeEnd: $('#'+id).children('.timeEnd').text(),   
        comment: $('#'+id).children('.comment').text(),   
    };
    return data;
}


function mesg (message){
    $.jGrowl.defaults.pool = 1;
    $.jGrowl(message.message, { 
                    glue: 'before',
                    position: 'custom',
                    theme: message.type,
                    speed: 'fast',
                    life: '250',
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
                    reload();//TODO: Handle this in other way
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
            taskEdit(data.id, data.title, data.done, data.date, data.time, data.timeEnd, data.comment);
        break;
        case 'addDay':
            taskAddDay(data.date);
        break;          
        case 'deleteDay':
            taskDeleteDay(data.date);
        break;      
        case 'setRatingDay':
            taskRatingDay(data.date, data.rating);
        break;
        case 'getCommentDay':
            taskGetCommentDay(data.date);
        break;
        case 'setCommentDay':
            taskSetCommentDay(data.date, data.comment);
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
        case 'setRatingDay':
            onRatingDay(data);
        break;
        case 'getCommentDay':
            onGetCommentDay(data);
        break;
        case 'setCommentDay':
            onSetCommentDay(data);
        break;
    }
}

//---------------setCommnetDay-----
function taskSetCommentDay(date, comment){
    srvSetCommentDay(date, comment);    
}

function srvSetCommentDay(date, comment){
    superAjax('/days/setComment.json',{date: date, comment: comment});
}

function scrSetCommentDay(data){
    $('#commentDay').removeAttr('date');
    $('#eCommentDay').text(null);
    $('#commentDay').modal('hide');
}
function onSetCommentDay(data){
    mesg(data.message);
    if(data.success){
        scrSetCommentDay(data);
    }
}
//---------------getCommnetDay-----
function taskGetCommentDay(date){
    srvGetCommentDay(date);    
}

function srvGetCommentDay(date){
    superAjax('/days/getComment.json',{date: date});
}

function scrGetCommentDay(data){
    $('#commentDay').attr('date', data.date);
    $('#eCommentDay').val(data.comment);
    $('#commentDay').modal('show');
        
}
function onGetCommentDay(data){
    mesg(data.message);
    scrGetCommentDay(data.data);
}
//---------------setRatingDay------
function taskRatingDay(date, rating){
    scrRatingDay(date, rating);
    srvRatingDay(date, rating);    
}
function scrRatingDay(date, rating){
    var ratingEl = $(".ratingDay[id='"+date+"']");
    if(+rating){
        ratingEl.attr('checked', 'checked');
    }else{
        ratingEl.removeAttr('checked');
    }
}
function srvRatingDay(date, rating){
    superAjax('/days/setRating.json',{date: date, rating: rating});
}

function onRatingDay(data){
    mesg(data.message);
}


//---------------deleteDay------
function taskDeleteDay(date){

    scrDeleteDay(date);
    srvDeleteDay(date);    
}
function scrDeleteDay(date){
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
    var newTabContent = '<div class="tab-pane" id="'+date+'"> '+
                    '<div class="row"> '+ 
                        '<div class="listTask"> '+
                            '<h3 class="label label-info margin-bottom10">'+date+'<img class="print" src="./img/print.png"/></h3> '+
                            '<div class="well form-inline"> '+
                                '<div class="input-append"> '+
                                    '<input type="text" size="16" class="input-xxlarge createTask" placeholder=" +Добавить задание…"/> '+
                                    '<span class="add-on">?</span> '+
                                '</div> '+
                                '<button class="btn createTaskButton"> Добавить </button> '+
                            '</div> '+
                            '<div class="filter"> '+
                                '<span>Фильтр: </span> '+ 
                                '<a href="" class="active" data="all">Все</a>,&nbsp; '+ 
                                '<a href="" data="inProcess">В Процессе</a>,&nbsp; '+ 
                                '<a href="" data="completed">Выполненные</a> '+
                            '</div> '+
                            '<div class="days"> '+
                                '<a href="" data="commentDay">Комментарий</a> '+
                                '<label class="checkbox ratingDay"> '+
                                    '<input type="checkbox" date="'+date+'"/> Удачный день '+
                                '</label> '+
                            '</div> '+
                            '<div class="clear"></div> '+
                            '<ul class="sortable connectedSortable ui-helper-reset" date="'+date+'"> '+
                                '<p class="loadContent" align=center> Loading content ...</p> '+
                            '</ul> '+
                        '</div> '+
                    '</div> '+
                '</div> ';
                
    $('.tab-content').append(newTabContent);
    $('#main ul.nav-tabs').append('<li class="drop"><a href="#'+date+'" data-toggle="tab" date="'+date+'">'+date+'<span class="close">×</span></a></li>');
    initTab('#main ul.nav-tabs a[date="'+date+'"]');
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
    if(!$.isEmptyObject(data.data.day) && +data.data.day[data.data.date][0].Day.rating){
        $(".ratingDay input[date='"+data.data.date+"']").attr('checked','checked');
    }
    $.each(data.data.list,function(index, value) {
        list.append(AddTask(value));
        initDelete( "li[id='"+value.Task.id+"'] .deleteTask");
        initEditAble("li[id='"+value.Task.id+"'] .editable");
        initDone("li[id='"+value.Task.id+"'] .done");
        initEditTask("li[id='"+value.Task.id+"'] .editTask");
    });
    initCreateTask($("ul[date='"+data.data.date+"']").parent().find(".createTask"));
    initCreateTaskButton($("ul[date='"+data.data.date+"']").parent().parent().find(".createTaskButton"));
    initDrop($("li a[date='"+data.data.date+"']").parent());
    initSortable("ul[date='"+data.data.date+"'].sortable");
    initRatingDay(".ratingDay input[date='"+data.data.date+"']");
    initTabDelte("li a[date='"+data.data.date+"'] .close");
    initFilter(list.siblings('.filter').children('a'));
    initCommentDay($("ul[date='"+data.data.date+"']").siblings('.days').children('a[data="commentDay"]'));

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
function scrTime(id, time, timeEnd){
    var task = $("li[id='"+id+"']");
    if(time){
        task.find('.time').text(time);
        task.find('.timeEnd').text(timeEnd);    
    }else{
      $(task.find('.time').text(''));
      $(task.find('.timeEnd').text(''));
    }
}

//----------------setPriority-------
function scrPriority(id, priority){
    var task = $("li[id='"+id+"']");
    if(+priority){
        task.addClass('impotant');
    }else{
        task.removeClass('impotant');
    }
}



//----------------edit----------
function taskEdit(id, title, done, date, time, timeEnd, comment){

    scrEdit(id, title, done, date, time, timeEnd, comment);
    srvEdit(id, title, done, date, time, timeEnd, comment);
}
function onEdit(data){
    if(data.success){
        $('#editTask').modal('hide');
        scrSetTitle(data.data.Task.id, data.data.Task.title, data.data.Task.priority);
    }
    mesg(data.message);
}
function srvEdit(id, title, done, date, time, timeEnd, comment){
    superAjax('/tasks/editTask.json',{id: id, title: title, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment});
}

function scrEdit(id, title, done, date, time, timeEnd, comment){
    scrDragWithTime(id, date, time);
    scrDate(id,date);
    scrSetDone(id,done);
    scrSetTitle(id, title, 0);
    scrTime(id, time, timeEnd);
 
}


function scrDragWithTime(id, date, time){
        var task = $("li[id='"+id+"'].currentTask");
        var taskRemote =  $("li[id='"+id+"']:not(.currentTask)");
        taskRemote.remove();
        task.removeClass('currentTask');
        if(!date){
            var list = $("ul[date='planned']");
        }else{
            var list = $("ul[date='"+date+"']");    
        }
        var timeList = list.find('li.setTime');
        var newPositionID;
        var prePositionID;
        var position;
        var preTime;
        var curTime;
        var change = $.trim(task.find('.time').text())!= time || task.attr('date') != date;
        if(change){
            if(time){
                var listitems = list.children('li.setTime').get();
                listitems.sort(function(a, b) {
                    var compA = $(a).find('.time').text().toUpperCase();
                    var compB = $(b).find('.time').text().toUpperCase();
                    return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) { 
                    console.log(itm);
                    if(time > $(itm).find('.time').text()){
                        newPositionID = $(itm).attr('id');
                    }
                });
           }
           task.hide( "slow", function() {
                if(newPositionID != id && +newPositionID){
                    $(this).insertAfter( list.children('#'+newPositionID)).show('slow');    
                }else if(!+newPositionID){
                    if(change){
                        if(list.children().length){
                            if(task.attr('date') != date || time){
                                $(this).prependTo(list).show('slow');
                            }else{
                                $(this).show('slow');
                            }        
                        }else{
                            $(this).appendTo(list).show('slow');
                        }
                    } 
                }else{
                    $(this).show('slow');
                }                    
                if(time){
                    $(this).addClass('setTime');
                }else{
                    $(this).removeClass('setTime');
                }
                $(this).attr('date', date);
                $(this).css({'opacity':'1'});
                $(this).children('.editTask').removeClass('hide');
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
    if(date == 'planned'){
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
	scrSetDone(id, done);
    srvSetDone(id, done);
}
function onSetDone(data){
	//scrSetDone(data.data.Task.id, data.data.Task.done);
    mesg(data.message);
}
function srvSetDone(id, done){
    superAjax('/tasks/setDone.json',{id:id, done: done});
}
function scrSetDone(id, done){
    var titleEl = $("li[id='"+id+"']").find('.editable');
    var doneEl = $("li[id='"+id+"']").find('.done');
    if(+done){
        //titleEl.addClass('complete');
        doneEl.attr('checked', 'checked');
         $("li[id='"+id+"']").addClass('complete')
    }else{
        //titleEl.removeClass('complete');
        $("li[id='"+id+"']").removeClass('complete');
        doneEl.removeAttr('checked');
    }
    $("li[id='"+id+"']").parent().siblings('.filter').children('a.active').trigger('click');
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
        $("li[id='"+id+"']").addClass('important');
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
        date = 'planned';
        data.data.Task.date = '';    
    }
    $("ul[date='"+date+"']").append(AddTask(data.data));
    initDelete("li[id='"+data.data.Task.id+"'] .deleteTask");
    initEditAble("li[id='"+data.data.Task.id+"'] .editable");
    initDone("li[id='"+data.data.Task.id+"'] .done");
    initEditTask("li[id='"+data.data.Task.id+"'] .editTask");
    $("li[id='"+data.data.Task.id+"']").parent().siblings('.filter').children('a.active').trigger('click');    	
}
function AddTask(data){
    var important ='';
	var setTime ='';
    var complete ='';
    var checked = '';
    var time = '<span class="time"></span>';
    var timeEnd = '<span class="timeEnd"></span>';
    if (+data.Task.priority){
		important = 'important';
	}
    if (+data.Task.done){
		complete = ' complete';
        checked = ' checked';
	}
    if (data.Task.time){
		setTime = 'setTime ';
        time = '<span class="time">'+data.Task.time.slice(0,-3)+'</span>';
        if(data.Task.timeend){
            timeEnd = '<span class="timeEnd">'+data.Task.timeend.slice(0,-3)+'</span>'; 
        }
    }
    taskHtml = '<li id ="'+data.Task.id+'" class="'+setTime+' '+complete+' '+important+'" date="'+data.Task.date+'"> \n'+ 
                            time+'\n'+
                            timeEnd+'\n'+
                            '<span><i class="icon-move"></i></span> \n'+
                            '<input type="checkbox" class="done" '+checked+'/> \n' +
                            '<span class="editable ">'+data.Task.title+'</span> \n'+
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

function initRatingDay(element){
    $(element).on("click", function(){
       
        var date = $(this).attr('date');
        var rating = $(this).is(":checked")? 1 : 0;
        userEvent('setRatingDay', {date: date, rating: rating});
    });
}

function initEditTask(element){
     $(element).on("click", function(){
            var task = getTaskForEdit($(this).parent().attr('id'));
            $(this).parent().addClass('currentTask');
            $('#editTask').attr('task_id', $(this).parent().attr('id'));
            $('#editTask').find('#eTitle').val(task.title);
            $('#editTask').find('#eComment').val(task.comment);
            if(task.done){
                $('#editTask').find('#eDone').attr('checked','checked');
            }else {
                $('#editTask').find('#eDone').removeAttr('checked');
            }
            $('#eTime').val(task.time);
            if(task.time){
                $('#eTimeEnd').timepicker('option', 'minTime', task.time, 'maxTime', '23:59').removeAttr('disabled');
            }else{
                $('#eTimeEnd').attr("disabled","disabled");
            }
            $('#eTimeEnd').val(task.timeEnd);
            $( "#eDate" ).val(task.date);
            if(!task.date){
                $( "#eDate" ).attr('placeholder', '---FUTURE---');
            }
            $('#editTask').modal('show');
    });
}

function initCommentDay(element){
    $(element).on("click", function(){
        var date = $(this).parent().siblings('ul:first').attr('date');
        userEvent('getCommentDay', {date: date});
        return false;
    });
}

function initCreateTask(element){
    $(element).on('keypress', function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
            var title = $(this).val();
            var date = $(this).parent().parent().siblings("ul").attr('date');
            if(date == 'planned'){
                date = '';
            }
            userEvent('create', {title: title, date: date });
            $(this).val(null);
        }
    });
}
function initCreateTaskButton(element){
    $(element).on('click', function(e){
        var title = $(this).parent().find('.createTask').val();
        var date = $(this).parent().siblings("ul").attr('date');
        if(date == 'planned'){
            date = '';
        }
        userEvent('create', {title: title, date: date });
        $(this).parent().find('.createTask').val(null);
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
                if(date == ui.draggable.attr( "date" )){
                    mesg({type:'success', message:'Перемещение запрещено. '});
                    return false;   
                }
                ui.draggable.addClass('currentTask');
                userEvent('dragOnDay', {id: id, date: date, time:time});
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
                if(dropped){
                    $(this).sortable('cancel');
                    dropped = false;
                    return true;
                }
                if(ui.item.parent().attr('date') == 'expired' || ui.item.hasClass('setTime')){
                    mesg({type:'success', message:'Перемещение запрещено. '});
                    $(this).css("color","");
                    return false;  
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
            window.location.hash= 'day-'+e.target.hash.slice(1);
    })
}

function initTabDelte(element){
    $(element).on('click', function() {
        var date = $(this).parent().attr('date');
        userEvent('deleteDay', {date:date});
    });
}

function initFilter(element){
    $(element).on('click', function() {
        var listTasks = $(this).parent().siblings('ul:first'); 
        var type =$(this).attr('data');
        listTasks.children('li').removeClass('hide');
        $(this).siblings('a').removeClass('active');
        switch(type){
            case 'all':
                $(this).addClass('active');
            break;
            case 'inProcess':
                listTasks.children('li.complete').addClass('hide');
                $(this).addClass('active');
            break;
            case 'completed':
                listTasks.children('li:not(.complete)').addClass('hide');
                $(this).addClass('active');
            break;
        }
        return false;
    });
}

function reload(){
    location.reload();
}
//-----------------------------------------------------------------------
var dropped = false;
$(function(){

     

     $('.print').click(function(){
        window.print();
        return false;
     });
     
     $(window).hashchange( function(e){
        if(window.location.hash != "") { 
            var date = new Date(window.location.hash);
            var hash = window.location.hash.slice(5);
            var activeTab =  $('#main li.active a').attr('date');
            if(hash == activeTab) {return;}
            if(date != 'Invalid Date' && hash != "planned"){
                hash = $.datepicker.formatDate('yy-mm-dd', date);
                userEvent('addDay',{date: hash});
            }else{
                $('#main a[href="#'+hash+'"]').tab('show');    
            }
         } 
    })
  
    $(window).hashchange();
     
     
     $.datepicker.setDefaults(
        $.extend($.datepicker.regional["ru"])
     );

    setInterval(function() {
        checkLogin();
    }, 120000);
    $('.help').tooltip({placement:'left',delay: { show: 500, hide: 100 }});
    $('#addDay').tooltip({placement:'bottom',delay: { show: 500, hide: 100 }});
    $('#completed h3').tooltip({placement:'left',delay: { show: 500, hide: 100 }});
    
    initTab('#main a[data-toggle="tab"]');
    initCreateTask(".createTask");
    initCreateTaskButton(".createTaskButton");
    initEditAble(".editable");
    initDelete(".deleteTask");
    initDone(".done");
    initRatingDay(".ratingDay input"); 
    initEditTask(".editTask");   
    initDrop("ul:first li.drop");
    initSortable(".sortable");
    initTabDelte('li a[data-toggle="tab"] .close');
    initFilter('.filter a');
    initCommentDay('.days a[data="commentDay"]');
    
    
    // edit task, modal window      
    $('#eTime').timepicker({
                    timeFormat: 'HH:mm',
                    maxTime: '23:59',
                    interval: 15,
                    startHour: 6,
                    change: function(time) {
                        $('#eTimeEnd').timepicker('option', 'minTime', time, 'maxTime', '23:59').removeAttr('disabled');
                    },
                    
    });
    
    $('#eTimeEnd').timepicker({
                    timeFormat: 'HH:mm',
                    maxTime: '23:59',
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
            var timeEnd = $.trim($('#eTimeEnd').val());
            var comment = $('#eComment').val();
            userEvent('edit',{id: id,title: title, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment });
    });
    
    $("#eCommentDaySave").click(function(){
            var date = $('#commentDay').attr('date');
            var comment = $('#eCommentDay').val();
            userEvent('setCommentDay',{date: date, comment: comment });
    });
    
    $('.day').click(function(){
        var date = $(this).text();
        userEvent('addDay',{date: date});
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
    
    $('.addDay').click(function(){
        $(this).find('li').removeClass('active'); 
    });

                   
}); 	