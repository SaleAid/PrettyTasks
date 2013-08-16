//1
function toListValidationErrorAll(errors){
    var listError = '';
    $.each(errors, function(index, value) {
        if($.isArray(value)){
            $.each(value, function(index, val) {
                listError = listError +'<br/>'+ val;
            });
        }
    });
    return listError;
}

function getTaskForEdit(id){
    return getTaskFromPage(id);
}

function getTaskFromPage(id){
    var title = $('#'+id).children('.editable').text();
    if ( ! title ){
        title = $('#'+id).children('.editable').find('input').val();
    }
    var data = {
        title:    title,
        priority: $('#'+id).hasClass('important') ? 1: 0,
        done:     $('#'+id).children('.done').is(":checked"),
        date:     $('#'+id).attr('date'),
        time:     $('#'+id).children('.time').text(),
        timeEnd:  $('#'+id).children('.timeEnd').text(),   
        comment:  $('#'+id).children('.commentTask').text(),
        continued: +$('#'+id).data('continued'),
        repeated: +$('#'+id).data('repeated')    
    };
    return data;
}

function getEditElement(name){
    var element = '';
    switch(name){
        case 'title':
            element = $('#eTitle');
        break;
        case 'date':
            element = $('#eDate');
        break;
        case 'time':
            element = $('#eTime');
        break;
        case 'timeend':
            element = $('#eTimeEnd');
        break;
        case 'comment':
            element = $('#eComment');
        break;
    }
    return element;
}

function getCommentDayElement(name){
    var element = '';
    switch(name){
        case 'comment':
            element = $('#eCommentDay');
        break;
    }
    return element;
}

function mesg (message, type){
	$.jGrowl.defaults.pool = 1;
    $.jGrowl(message, { 
                    glue: 'before',
                    position: 'custom',
                    theme: type,
                    speed: 'fast',
                    life: '3000',
					animateOpen: { 
						height: "show"
					},
					animateClose: { 
						height: "hide"
					}
     });
}

function checkStatus(){
    $.ajax({
        type: "POST",
        data: {date: GLOBAL_CONFIG.date, hash:""},
        url: "/tasks/checkstatus.json",
        success: function (data) {
            if(!data.success){
                mesg(data.message.message, data.message.type);
            }else{
                switch(data.cause){
                    case 'changeDay':
                        mesg(data.message.message, data.message.type);
                        var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
                        //setTimeout(userEvent('Day',{date: today, refresh: true}), 5000);
                        window.location.hash = 'day-'+today;
                        setTimeout(reload(), 5000);
                        break;
               }
               showErrorConnection(false);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            if(xhr.status == '404' || xhr.status == 0){
                showErrorConnection(true);
            }else{
                //console.log(xhr);
                reload();
            }
       }
    });
}

function checkLogin(){
    $.ajax({
        type: "POST",
        url: "/checkLogin",
        success: function (status) {
                if(!status){
                   showErrorConnection(true);
                }else{
                   showErrorConnection(false);
                }
        },
        error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status == '404' || xhr.status == 0){
                    showErrorConnection(true);
                }else{
                    //console.log(xhr);
                    //reload();
                }
       }
    });
}

function displayLoadAjax(count){
    if(!+count){
        $('.ajaxLoader').addClass('hide');
    }else{
        $('.ajaxLoader').removeClass('hide');
    }
}

function initAjax(){
    $.ajaxSetup({ 
        beforeSend: function(xhr, settings) {  
            var csrfToken = $("meta[name='csrf-token']").attr('content');
            if (csrfToken) { 
                xhr.setRequestHeader("X-CSRFToken", csrfToken ); 
            } 
        } 
    }); 
}
//-------------------------------------
function superAjax(url, data){
     var result = null;
     countAJAX++;
     displayLoadAjax(countAJAX);
     $.ajax({
            url: '/'+GLOBAL_CONFIG.lang+url,
            type: 'POST',
            data: data,
            success: function(data, textStatus, jqXHR) {
                responseHandler(data);
                countAJAX--;
                displayLoadAjax(countAJAX); 
                if (typeof _gaq != "undefined"){
                    _gaq.push(["_trackEvent", "Tasks", url]);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                if(xhr.status == '404' || xhr.status == 0){
                    showErrorConnection(true);
                }else{
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
        case 'clone':
            taskClone(data.id, data.date);
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
            taskChangeOrders(data.list, data.id, data.position);
        break; 
        case 'edit':
            taskEdit(data.id, data.title, data.priority, data.continued, data.done, data.date, data.time, data.timeEnd, data.comment);
        break;
        case 'addDay':
            taskAddDay(data.date, data.refresh);
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
        case 'getCommentTag':
            taskGetCommentTag(data.tag);
        break;
        case 'setCommentTag':
            taskSetCommentTag(data.tag, data.comment);
        break;
        case 'getTasksByType':
            taskGetTasksByType(data.type);
        break;
        case 'deleteAll':
            taskDeleteAll(data.confirm);
        break;
        case 'getListByTag':
            taskGetListByTag(data.tag);
        break;
        case 'getLists':
            taskGetLists();
        break;
        case 'repeated':
            taskRepeated(data.id, data.recur);
        break;
        case 'createList':
            taskCreateList(data.tag);
        break;
                    
    }
}

function responseHandler(data){
    switch(data.action){
        case 'create':
             onCreate(data);
        break;
        case 'clone':
             onClone(data);
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
        case 'getCommentTag':
            onGetCommentTag(data);
        break;
        case 'setCommentTag':
            onSetCommentTag(data);
        break;
        case 'getTasksByType':
            onGetTasksByType(data);
        break;
        case 'deleteAll':
            onDeleteAll(data);
        break;
        case 'getListByTag':
            onGetListByTag(data);
        break;
        case 'getLists':
            onGetLists(data);
        break;
        case 'repeated':
            onRepeated(data);
        break;
        case 'createList':
            onCreateList(data);
        break;
    }

}

//----------------create list -------- 
function taskCreateList(tag){
    srvCreateList(tag);
}
function onCreateList(data){
    if(data.success){
        scrCreateList(data);
    }else{
    	mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.message.errors), data.message.type);   
    }
}
function srvCreateList(tag){
    superAjax('/lists/add.json',{tag: tag});
}
function scrCreateList(data){
    if(!data.data.tag){return;}
    $list = $('#lists');
    $list.find('.emptyList').addClass('hide');
    $listUl = $list.find('ul[date="lists"]');
    $listUl.append('<li><span class="tags-list label label-info" data-tag="'+data.data.tag+'">&#x23;'+data.data.tag+'</span></li>');
}

//-------------------------------------

//---------------repeated-------------
function taskRepeated(id, recur){
    srvRepeated(id, recur);
}

function srvRepeated(id, recur){
    superAjax('/tasks/repeated.json', {id: id, recur: recur});
}

function scrRepeated(data){
    
}

function onRepeated(data){
    if(data.success){
        $('#repeatTask').modal('hide');
        //scrEdit(data.data.Task.id, data.data.Task.title, data.data.Task.tags, data.data.Task.priority, data.data.Task.continued, data.data.Task.done, data.data.Task.date, data.data.Task.time, data.data.Task.timeend, data.data.Task.comment);
    }else {
        mesg(data.message.message, data.message.type);
        //scrErrorEdit(data.errors);    
    }
}

//---------------getLists-------------
function taskGetLists(){
    $('#lists').find('ul[date="lists"]').empty().append(_.template($("#ajax_loader_content").html()));
    srvGetLists();
}

function srvGetLists(){
    superAjax('/lists/getlists.json');
}

function scrGetLists(data){
    $list = $('#lists');
    $listUl = $list.find('ul[date="lists"]');
    $listUl.empty();
    if($.isEmptyObject(data)){
        $list.find('.emptyList').removeClass('hide');
        return;
    }
    $.each( data, function(index, value) {
            $listUl.append('<li><span class="tags-list label label-info" data-tag="'+value.name+'">&#x23;'+value.name+'</span></li>');
    });
}

function onGetLists(data){
    $('#lists .row').show();
    if(!data.success){
        $('#lists .row').hide();
        mesg(data.message.message, data.message.type); 
    }else{
        $('#lists .row').find('ul[date="lists"]').hide('blind', 100, function(){
            $(this).empty();
            scrGetLists(data.data);
            $(this).show('fade', 200);
        });
    }
}

//---------------getListByTag---------
function taskGetListByTag(tag){
    if(tag){
        $('#list').find('ul[date="list"]').empty().append(_.template($("#ajax_loader_content").html()));
        srvGetListByTag(tag);    
    } else {
        taskGetLists();
    }
    
}

function srvGetListByTag(tag){
    superAjax('/lists/getTasksByTag.json',{tag: tag});
}

function scrGetListByTag(data){
    $list = $('#list');
    $list.find('.tag-name').text(data.tag);
    $listUl = $list.find('ul[date="list"]');
    $listUl.attr('data-tag', data.tag);
    $listUl.data('tag', data.tag);
    window.location.hash= 'list-'+data.tag;
    var alltasks = 0;
    var donetasks = 0;
    if($.isEmptyObject(data.tasks)){
        $list.find('.emptyList ').removeClass('hide');
        return;
    }
    $.each( data.tasks, function(index, task) {
            alltasks++;
            if (+task.done){
                donetasks++;
            }
            tmp_task = addTagToList(task);
            $listUl.append(tmp_task);
            initDelete($listUl.find("li[id='"+task.id+"'] .deleteTask"));
            initEditAble($listUl.find("li[id='"+task.id+"'] .editable"));   
    });
    $listUl.siblings('.filter').find('span.all').text(alltasks);
    $listUl.siblings('.filter').find('span.inProcess').text(alltasks - donetasks);
    $listUl.siblings('.filter').find('span.completed').text(donetasks);
    
}

function addTagToList(task){
        liClass = '';
        done = '';
        time = '';
        timeend = '';
        comment_status ='';
        date = '';
        comment = task.comment;
        repeated = 0;
        continued = 0;
        if(task.time != null){
            time = task.time.slice(0,-3);
            liClass += ' setTime'
        }
        if(task.timeend != null){
            timeend = task.timeend.slice(0,-3);
        }
        if (+task.done){
            liClass +=' complete';
            done = 'checked';
        }
        if (+task.priority){
            liClass +=' important';    
        }
        if (!task.comment || task.comment == null){
            comment_status =' hide';
            comment = '';    
        }
        if (task.date != null){
            date = task.date;    
        }
        if (task.repeated){
            repeated = 1;    
        }
        if(task.hasOwnProperty('continued')){
            continued = task.continued;
        }
        
        title = wrapTags(task.title, task.tags);
        return _.template($("#task_tag").html(), {
                                  id: task.id,
                                  date: date, 
                                  liClass: liClass,
                                  time: time,
                                  timeend: timeend,
                                  checked: done,
                                  title: title,
                                  comment: comment,
                                  comment_status: comment_status,
                                  continued : +continued,
                                  repeated : +repeated
                                  
        });
}
function onGetListByTag(data){
    $('#list .row').show();
    if(!data.success){
        $('#list .row').hide();
        window.location.hash= 'lists';
        $('.lists').addClass('active');
        userEvent('getLists');
        activeTab('lists');
    }else{
        $('#list .row').find('ul[date="list"]').hide('blind', 100, function(){
            $(this).empty();
            scrGetListByTag(data.data);
            $(this).show('fade', 200);
        });
    }
}

//---------------------------------

//---------------deleteAll---------
function taskDeleteAll(confirm){
    srvDeleteAll(confirm);    
}

function srvDeleteAll(confirm){
    superAjax('/tasks/deleteAll.json',{confirm: confirm});
}

function scrDeleteAll(){
    $('#deleted ul[date="deleted"]').empty().siblings('.emptyList').removeClass('hide');
    $('.delete_all').attr('disabled', 'disabled');
}
function onDeleteAll(data){
    if(!data.success){
        mesg(data.message.message, data.message.type); 
    }else{
        scrDeleteAll();
    }
}

//---------------------------------

//---------------getTasksByType----
function taskGetTasksByType(type){
    srvGetTasksByType(type);    
}

function srvGetTasksByType(type){
    superAjax('/tasks/getTasksByType.json',{type: type});
}

function scrGetTasksByType(data){
     var type = data.data.name;
     var list = data.data.list;
     switch(type){
        case 'future':
            futureTasks(list);
        break;
        case 'expired':
            expiredTasks(list);
        break;
        case 'completed':
            completedTasks(list);
        break;           
        case 'deleted':
            deletedTasks(list);
        break;
        case 'continued':
            continuedTasks(list);
        break;
     }
}
function onGetTasksByType(data){
    if(data.success){
        scrGetTasksByType(data);
    }else{
//        console.log(data);
        mesg(data.message.message, data.message.type);
    }
}

function addTaskNew(task){
        liClass = '';
        done = '';
        time = '';
        timeend = '';
        comment_status ='';
        date = '';
        comment = task.comment;
        if(task.time != null){
            time = task.time.slice(0,-3);
            liClass += ' setTime'
        }
        if(task.timeend != null){
            timeend = task.timeend.slice(0,-3);
        }
        if (+task.done){
            liClass +=' complete';
            done = 'checked';
        }
        if (+task.priority){
            liClass +=' important';    
        }
        if (!task.comment || task.comment == null){
            comment_status =' hide';
            comment = '';    
        }
        if (task.date != null){
            date = task.date;    
        }
        title = wrapTags(task.title, task.tags);
        return _.template($("#add_task").html(), {
                                  id: task.id,
                                  date: date, 
                                  liClass: liClass,
                                  time: time,
                                  timeend: timeend,
                                  checked: done,
                                  title: title,
                                  comment: comment,
                                  comment_status: comment_status,
                                  continued: 0,
                                  repeated: 0
                                  
        });
}

function continuedTasks(data){
    var listUl = $('#continued ul[date="continued"]');
    var prevDate = 0;
    var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
    var weekDayStyle;
    listUl.empty();
    $.each(data, function(index, task) {
        if(today == task.date){
            weekDayStyle = ''; 
        } else if(today > task.date){
            weekDayStyle = 'past';
        } else {
            weekDayStyle = 'future';
        }
        if( prevDate == 0 || task.date > prevDate ){
            day_tmp = _.template(
                    $("#day_h3_label").html(), {
                        date: task.date, 
                        weekDayStyle: weekDayStyle, 
                        weekDay: $.datepicker.formatDate('DD', new Date (task.date))
                    } 
            );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            listUl.append(day);
        }
        prevDate = task.date
        
        listUl.append( addTaskNew(task) );
        initDelete(listUl.find("li[id='"+task.id+"'] .deleteTask"));
        //initEditAble(listUl.find("li[id='"+task.id+"'] .editable"));
        
    });
    if(!+listUl.children('li').length){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
}

function futureTasks(data){
    var listUl = $('#future ul[date="future"]');
    var prevDate = 0;
    var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
    var weekDayStyle;
    listUl.empty();
    $.each(data,function(index, task) {
        if(today == task.date){
            weekDayStyle = ''; 
        } else if(today > task.date){
            weekDayStyle = 'past';
        } else {
            weekDayStyle = 'future';
        }
        
        if( prevDate == 0 || task.date > prevDate ){
            day_tmp = _.template(
                    $("#day_h3_label").html(), {
                        date: task.date, 
                        weekDayStyle: weekDayStyle, 
                        weekDay: $.datepicker.formatDate('DD', new Date (task.date))
                    } 
            );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            listUl.append(day);
        }
        prevDate = task.date
        listUl.append( addTaskNew(task) );
        initDelete(listUl.find("li[id='"+task.id+"'] .deleteTask"));
        initEditAble(listUl.find("li[id='"+task.id+"'] .editable"));
        listUl.find(" li[id='"+task.id+"'] .editTask").addClass('hide');
        
    });
    if(!+listUl.children('li').length){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
}
function expiredTasks(data){
    var listUl = $('#expired ul[date="expired"]');
    var prevDate = 0;
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
    $.each(data, function(index, task) {
        if( prevDate == 0 || task.date < prevDate ){
            day_tmp = _.template(
                    $("#day_h3_label").html(), {
                        date: task.date, 
                        weekDayStyle: 'past', 
                        weekDay: $.datepicker.formatDate('DD', new Date (task.date))
                    } 
            );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            listUl.append(day);
        }
        prevDate = task.date;
        
        listUl.append( addTaskNew(task) );
        initDelete(listUl.find("li[id='"+task.id+"'] .deleteTask"));
        //initEditAble(listUl.find("li[id='"+task.id+"'] .editable"));
        listUl.find(" li[id='"+task.id+"'] .editTask").addClass('hide');
        
    });
}
function completedTasks(data){
    var listUl = $('#completed ul[date="completed"]');
    var task, priority, time, timeend, weekDayStyle;
    var prevDate = 0;
    var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
    $.each(data,function(index, task) {
        if(today == task.date){
            weekDayStyle = ''; 
        } else if(today > task.date){
            weekDayStyle = 'past';
        } else {
            weekDayStyle = 'future';
        }
        
        if( prevDate == 0 || task.date < prevDate ){
            day_tmp = _.template(
                    $("#day_h3_label").html(), {
                        date: task.date, 
                        weekDayStyle: weekDayStyle, 
                        weekDay: $.datepicker.formatDate('DD', new Date (task.date))
                    } 
            );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            listUl.append(day);
        }
        prevDate = task.date;
        
        priority = +task.priority ? 'important' : '';
        time = task.time ? task.time.slice(0,-3) : '';
        timeend = task.timeend ? task.timeend.slice(0,-3) : ''; 
        
        taskHtml = '<li class="'+priority+'"> '+
        '<span class="time">'+time+'</span> '+
        '<span class="timeEnd">'+timeend+'</span> '+
        '<span class="title">'+wrapTags(task.title, task.tags)+'</span> '+
        '</li> ';
        listUl.append( taskHtml );
    });
}

function deletedTasks(data){
    var listUl = $('#deleted ul[date="deleted"]');
    var task, priority, time, timeend;
    var prevDate = 0;
    var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
    var weekDayStyle;
    
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
        $('.delete_all').attr('disabled', 'disabled');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
        $('.delete_all').removeAttr('disabled');
    }
    $.each(data,function(index, task) {
        weekday = $.datepicker.formatDate('DD', new Date (task.date));
        if(task.date == null){
           task.date = GLOBAL_CONFIG.planned;
           weekDayStyle = 'future'; 
           weekday = '';
        } else if(today == task.date){
            weekDayStyle = ''; 
        } else if(today > task.date){
            weekDayStyle = 'past';
        } else {
            weekDayStyle = 'future';
        }
        
        if( prevDate == 0 || task.date < prevDate || (task.date == GLOBAL_CONFIG.planned && prevDate != GLOBAL_CONFIG.planned) ){
            day_tmp = _.template(
                    $("#day_h3_label").html(), {
                        date: task.date, 
                        weekDayStyle: weekDayStyle, 
                        weekDay: weekday
                    } 
            );
            day = $(day_tmp);
            if(task.date == GLOBAL_CONFIG.planned){
                day.removeAttr('title');
                day.find('.dash').remove();    
            }
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            listUl.append(day);
        }
        prevDate = task.date;
        
        listUl.append( addTaskNew(task) );
        initDelete(listUl.find("li[id='"+task.id+"'] .deleteTask"));
        listUl.find(" li[id='"+task.id+"'] .editTask").addClass('hide');
        listUl.find(" li[id='"+task.id+"'] .done").addClass('hide');
    });
}

//----------------------------------

function srcCountTasks(date, drop){
    var listTasks = [];
    if(date == ''){
        date = 'planned';
    }
    if(drop){
        listTasks.push($("ul[date='"+date+"']"));   
    }else{
        listTasks = $("ul.filtered > li[date='"+date+"']").parent();    
    }
    $.each(listTasks, function(index, value) {
        var all = $(value).children('li').length;
        var done = $(value).children('li.complete').length;
        $(value).siblings('.filter').find('span.all').text(all);
        $(value).siblings('.filter').find('span.inProcess').text(all - done);
        $(value).siblings('.filter').find('span.completed').text(done);
        if(!+all){
            $(value).siblings('.emptyList').removeClass('hide');
        }else{
            $(value).siblings('.emptyList').addClass('hide');
        }
    });
}

//---------------setCommnetTag-----
function taskSetCommentTag(tag, comment){
    srvSetCommentTag(tag, comment);    
}

function srvSetCommentTag(tag, comment){
    superAjax('/lists/setCommentTag.json',{tag: tag, comment: comment});
}

function scrSetCommentTag(tag){
	$('#commentDay').data('tag', null).attr('data-tag', null);
	
    $('#eCommentDay').text(null);
    $('#commentDay').modal('hide');
    
}
function onSetCommentTag(data){
    
    if(data.success){
        scrSetCommentTag(data);
    }else{
        mesg(data.message.message, data.message.type);
        scrErrorSetCommentDay(data.errors);
    }
}
//---------------getCommnetTag-----
function taskGetCommentTag(tag){
    srvGetCommentTag(tag);    
}

function srvGetCommentTag(tag){
    superAjax('/lists/getCommentTag.json',{tag: tag});
}

function scrGetCommentTag(data){
	$('#commentDay').data('tag', data.tag).attr('data-tag', data.tag);
	$('#eCommentDay').val(data.comment);
    $('#commentDay').modal('show');
    
        
}
function onGetCommentTag(data){
	if(!data.success){
        mesg(data.message.message, data.message.type); 
    }
    
    scrGetCommentTag(data.data);
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
    
    if(data.success){
        scrSetCommentDay(data);
    }else{
        mesg(data.message.message, data.message.type);
        scrErrorSetCommentDay(data.errors);
    }
}
function arrErrorToList(errors){
    var str = '';
    //var str = '<ul>';
    if(!+errors.length){return;}
    $.each(errors, function(index, value) {
        str += value;
    });
    //str += '</ul>';
    return str;
}

function scrErrorSetCommentDay(data){
    $('.errorEdit').removeClass('errorEdit')
                   .removeAttr('rel')
                   .removeAttr('title')
                   .removeAttr('data-original-title')
                   .off('tooltip');
    if(data !== undefined){
        $.each(data,function(index, value) {
            getCommentDayElement(index)
                        .addClass('errorEdit')
                        .attr('rel', 'tooltip')
                        .attr('data-original-title', arrErrorToList(value))//value[0])
                        .tooltip({placement:'right',
                                  delay: { show: 500, hide: 100 },
                                  //trigger: 'focus',
                                  template: '<div class="tooltip errorTooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                                  });
        });
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
    if(!data.success){
        mesg(data.message.message, data.message.type); 
    }
    
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
    if(!data.success){
        mesg(data.message.message, data.message.type);
    }
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
    if(!data.success){
        mesg(data.message.message, data.message.type); 
    }
    $('#wrapper-content').css('min-height', $('.listDay').height() + 30 );
    changeHeightListDays();
}

//---------------addDay---------
function taskAddDay(date, refresh){

    if(scrAddDay(date, refresh)){
        srvAddDay(date);    
    }
}

function scrAddDay(date, refresh){
    var flag = true;
    if(refresh){
        return true;
    }
    $("#main ul:first li").each(function(){
        if($(this).children('a').attr('date') == date){
            flag = false;
        }
    });
    if(!flag){
        activeTab(date);
        return false;    
    }
    var newTabContent = _.template($("#day_tab_content_template").html(), {date: date} );            
    $('.tab-content').append(newTabContent); 
    var today = new Date();
    var yesterday = new Date();
    yesterday.setDate(today.getDate()-1);
    yesterday = $.datepicker.formatDate('yy-mm-dd', yesterday);
    today = $.datepicker.formatDate('yy-mm-dd', today);
    
    if(yesterday == date) {
           var newDay = '<li class="drop userDay"><a href="#'+date+'" data-toggle="tab" date="'+date+'">'+GLOBAL_CONFIG.yesterday+'<span class="close">×</span></a></li>';
           beforeDay = $('.listDay li a[date='+today+']').parent();
           $(newDay).insertBefore( beforeDay );
    } else {
        var listUserDay = $('#main ul.nav-tabs').children('li.userDay').get();
        var afterDay = null;
        var newDay = '<li class="drop userDay"><a href="#'+date+'" data-toggle="tab" date="'+date+'">'+date+'<span class="close">×</span></a></li>';
        listUserDay.sort(function(a, b) {
            var compA = $(a).find('a').attr('date');
            var compB = $(b).find('a').attr('date');
            return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
        });
        $.each(listUserDay, function(idx, itm) { 
            if(date > $(itm).find('a').attr('date')){
                afterDay = $(itm);
            }
        });
        if(afterDay){
            $(newDay).insertAfter( afterDay );                
        }else{
            $(newDay).insertAfter( $("#main ul.nav-tabs li:not('.userDay'):last") );   
        }    
    }
    initTab('#main ul.nav-tabs a[date="'+date+'"]');
    activeTab(date);
    
    return true;
}
function activeTab(date){
    $('div.active').removeClass('active').removeClass('in');
    $('.listDay li.active').removeClass('active');
    $('#main ul.nav-tabs a[date="'+date+'"]').tab('show');
}

function srvAddDay(date){
    superAjax('/tasks/getTasksForDay.json',{date: date});
}

function onAddDay(data){
    var list = $("ul[date='" + data.data.name + "']");
    var weekday = $.datepicker.formatDate('DD', new Date (data.data.name));
    var today = $.datepicker.formatDate('yy-mm-dd', new Date ());
    var weekDayStyle;
    var cAll = cDone = 0;
    
    if(data.data.name == 'planned'){
       weekDayStyle = 'future'; 
       weekday = '';
    } else if(today == data.data.name){
        weekDayStyle = ''; 
    } else if(today > data.data.name){
        weekDayStyle = 'past';
    } else {
        weekDayStyle = 'future';
    }
    
    list.empty();
    list.siblings('.emptyList ').remove();
    var emptyList = _.template($("#empty_list_day_tasks").html(), {type: weekDayStyle});
    if($.isEmptyObject(data.data.list)){
        emptyList = $(emptyList).removeClass('hide');
    }
    list.after(emptyList);
    
    if(!$.isEmptyObject(data.data.day) && +data.data.day.rating){
        $(".ratingDay input[date='"+data.data.name+"']").attr('checked','checked');
    }
     
    $.each(data.data.list, function(index, task) {
        cAll++;
        if(+task.done){
            cDone++;
        }
        list.append(AddTask(task));
        initDelete( "li[id='"+task.id+"'] .deleteTask");
        initEditAble("li[id='"+task.id+"'] .editable");
    });

    initDrop($("li a[date='"+data.data.name+"']").parent());
    initSortable("ul[date='"+data.data.name+"'].sortable");
    initRatingDay(".ratingDay input[date='"+data.data.name+"']");
    initTabDelte("li a[date='"+data.data.name+"'] .close");
    initFilter(list.siblings('.filter').children('a'));
    initCommentDay($("ul[date='"+data.data.name+"']").siblings('.days').children('a[data="commentDay"]'));
    
    //count 
    list.siblings('.filter').find('span.all').text(cAll);
    list.siblings('.filter').find('span.inProcess').text(cAll - cDone);
    list.siblings('.filter').find('span.completed').text(cDone);
    list.parent().find('.weekday').text(" - " + weekday);
    list.parent().find('.weekday').addClass(weekDayStyle);
    initPrintClick(list.parent().find('.print'));
    setFiler(data.data.name);
    $('#wrapper-content').css('min-height', $('.listDay').height() + 30 );
    changeHeightListDays();

}

// --------------setDate--------

function scrDate(id, date){
    var task = $("li[id='"+id+"'].currentTask");
    if(date){
        task.attr('date',date);    
    }else{
        task.attr('date','');
    }
}

//----------------setTime-------
function scrTime(id, time, timeEnd){
    var task = $("li[id='"+id+"'].currentTask");
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
    var task = $("li[id='"+id+"'].currentTask");
    if(+priority){
        task.addClass('impotant');
    }else{
        task.removeClass('impotant');
    }
}

//----------------setCommentTask-------
function scrCommentTask(id, comment){
    $("li[id='"+id+"']").find('.commentTask').text(comment);
    if( comment ){
        $("li[id='"+id+"']").find('.comment-task-icon i').removeClass('hide');
    }else{
        if( ! $("li[id='"+id+"']").find('.comment-task-icon i').hasClass('hide') ){
            $("li[id='"+id+"']").find('.comment-task-icon i').addClass('hide');
        }
    }
}


//----------------edit----------
function taskEdit(id, title, priority, continued, done, date, time, timeEnd, comment){
    if(+done && !date){
         date = GLOBAL_CONFIG.date;
    }
    srvEdit(id, title, priority, continued, done, date, time, timeEnd, comment);
}
function onEdit(data){
    if(data.success){
        $('#editTask').modal('hide');
        scrEdit(data.data.id, data.data.title, data.data.tags, data.data.priority, data.data.continued, data.data.done, data.data.date, data.data.time, data.data.timeend, data.data.comment);
    }else {
        mesg(data.message.message, data.message.type);
        scrErrorEdit(data.message.errors);    
    }
    
}
function scrErrorEdit(data){
    $('.errorEdit').removeClass('errorEdit')
                   .removeAttr('rel')
                   .removeAttr('title')
                   .removeAttr('data-original-title')
                   .off('tooltip');
    if(data !== undefined){
        $.each(data,function(index, value) {
            getEditElement(index)
                        .addClass('errorEdit')
                        .attr('rel', 'tooltip')
                        .attr('data-original-title', arrErrorToList(value))//value[0])
                        .tooltip({placement:'right',
                                  delay: { show: 500, hide: 100 },
                                  //trigger: 'focus',
                                  template: '<div class="tooltip errorTooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                                  });
        });
    }
    
}

function srvEdit(id, title, priority, continued, done, date, time, timeEnd, comment){
    superAjax('/tasks/editTask.json',{id: id, title: title, priority: priority, continued: continued, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment});
}

function scrEdit(id, title, tags, priority, continued, done, date, time, timeEnd, comment){
    var task = $("li[id='"+id+"'].currentTask");
    task.data('continued', continued).attr('data-continued', continued);
    var currentTaskDate = task.attr('date');
    var currentTaskTime = task.find('.time').text();
    if(time == null){
        time = '';
    }
    
    scrDate(id,date);
    scrSetDone(id,done);
    scrSetTitle(id, title, tags, priority);
    scrTime(id, time, timeEnd);
    scrCommentTask(id, comment);
    
    if (date == currentTaskDate && time == currentTaskTime){
        task.removeClass('currentTask');
    }else{
       scrDragWithTime(id, date, time); 
    }
    
    if(+task.parent().data('refresh')){
       _refreshDays(date);
    }
    
}

function toSeconds(t) {
    var bits = t.split(':');
    return bits[0]*3600 + bits[1]*60;
}

function _refreshDays(date){
    if(date){
        refreshDays.push(date);
        refreshDays = _.uniq(refreshDays);    
    }
}

function scrDragWithTime(id, date, time){
        var before = false;
        var task = $("li[id='"+id+"'].currentTask");
        var currentTaskDate = task.attr('date');
        var taskRemote =  $("li[id='"+id+"']:not(.currentTask)");
        taskRemote.remove();
        task.removeClass('currentTask');
        if(task.find('.tag-date').length > 0) {
            var date_text = date;
            task.attr('date', date);
            if(!date){
                date_text = GLOBAL_CONFIG.planned;
                date ='planned';
            }
            task.find('.tag-date').text(date_text);
            _refreshDays(date);
            _refreshDays(currentTaskDate);
            return;
        }
        if(!date){
            var list = $("ul[date='planned']");
            time = null;
            scrTime(id, time)
        }else{
            var list = $("ul[date='"+date+"']");    
        }
        if(list.length > 0) {
            var timeList = list.find('li.setTime');
            var newPositionID;
            if(time){
                var listitems = list.children('li.setTime').get();
                listitems.sort(function(a, b) {
                    var compA = toSeconds($(a).find('.time').text());
                    var compB = toSeconds($(b).find('.time').text());
                    return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
                });
                $.each(listitems, function(idx, itm) { 
                    if(toSeconds(time) > toSeconds($(itm).find('.time').text())){
                        newPositionID = $(itm).attr('id');
                    }
                });
            	if(!newPositionID && listitems.length){
                    newPositionID = $(listitems[0]).attr('id');
                    before = true;
                }
           }
           task.hide('show', function() {
                if(newPositionID != id && newPositionID){
                    if(before){
                        $(this).insertBefore( list.children('#'+newPositionID)).show();
                    }else{
                        $(this).insertAfter( list.children('#'+newPositionID)).show();
                    }
                        
                }else if(!newPositionID){
                    if(list.children().length){
                        $(this).prependTo(list);
                    }else{
                        $(this).appendTo(list);
                    }
                }                    
                if(time){
                    $(this).addClass('setTime');
                }else{
                    $(this).removeClass('setTime');
                }
                $(this).attr('date', date);
                $(this).css({'opacity':'1'});
                $(this).css({'display':''});
                $(this).removeAttr('style');
                if($(this).children('.editTask').hasClass('hide')){
                    $(this).children('.editTask').removeClass('hide');
                    initEditAble($(this).children('.editable'));
                }
                if($(this).children('.done').hasClass('hide')){
                    $(this).children('.done').removeClass('hide');
                }
                
                if(currentTaskDate != date){
                    srcCountTasks(currentTaskDate, true);
                }
                srcCountTasks(date, true);
            });    
        } else {
            task.remove();
        }
        //srcCountTasks(date, true);
        
        
}

//----------------changeOrder---
function taskChangeOrders(list, id, position){
    scrChangeOrders(id, position);
    srvChangeOrders(list, id, position);
}
function onChangeOrders(data){
    if(!data.success){
        mesg(data.message.message, data.message.type);    
    }
}
function srvChangeOrders(list, id, position){
    superAjax('/tasks/changeOrders.json',{list:list, id: id, position: position});
}
function scrChangeOrders(id, position){
    $("li[id='"+id+"']").removeAttr('style');
}

//----------------dragOnDay-----
function taskDragOnDay(id, date, time){
    if(date == 'planned'){
        date = '';
    }
    scrDragOnDay(id, date, time);
    srvDragOnDay(id, date, time);
}
function onDragOnDay(data){
    if(!data.success){
        mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.message.errors), data.message.type);    
    }
}
function srvDragOnDay(id, date, time){

    superAjax('/tasks/dragOnDay.json',{id: id, date: date, time: time});
}
function scrDragOnDay(id, date, time){
    scrDragWithTime(id, date, time);
}

//----------------delete--------
function taskDelete(id){
    srvDelete(id);
    scrDelete(id);
}
function onDelete(data){
    if(!data.success){
        mesg(data.message.message, data.message.type);
    }    
        
}
function srvDelete(id){
    superAjax('/tasks/setDelete.json',{id: id});
}
function scrDelete(id){
    var $task = $("li[id='"+id+"'].currentTask");
    var date = $task.attr('date');
    //var date = $task.parent().attr('date');
    if(!$task.attr('date')){
            date = 'planned';
        }
    if(+$task.parent().data('refresh')){
       _refreshDays(date);
    }
    if($task.find('.tag-date').length > 0) {
        date = 'list';
    }
    
    $task.remove();
    srcCountTasks(date, true);
}

//----------------setDone-------
function taskSetDone(id, done){
	scrSetDone(id, done);
    srvSetDone(id, done);
}
function onSetDone(data){
    var task = data.data;
	if(!data.success){
        mesg(data.message.message, data.message.type);
        return;   
    }
    if(+task.done && +task.future){
         if (task.time == null){
            task.time =''; 
         }
         taskDragOnDay(task.id, GLOBAL_CONFIG.date, task.time);
    }else{
        $("li[id='"+task.id+"'].currentTask").removeClass('currentTask');
    }
}
function srvSetDone(id, done){
    superAjax('/tasks/setDone.json',{id:id, done: done});
}
function scrSetDone(id, done){
     $("li[id='"+id+"']").removeAttr('style');
    var titleEl = $("li[id='"+id+"']").find('.editable');
    var doneEl = $("li[id='"+id+"']").find('.done');
    //var date = $("li[id='"+id+"']").attr('date');
    var date = $("li[id='"+id+"'].currentTask").parent().attr('date');
    //console.log(date);
    
    if(+done){
        doneEl.attr('checked', 'checked');
        $("li[id='"+id+"']").addClass('complete')
    }else{
        $("li[id='"+id+"']").removeClass('complete');
        doneEl.removeAttr('checked');
    }
    $("li[id='"+id+"'].currentTask").parent().siblings('.filter').children('a.active').trigger('click');
    srcCountTasks(date, true);
}

//----------------setTitle------
function taskSetTitle(id, title){
    srvSetTitle(id, title);
}
function onSetTitle(data){
    scrSetTitle(data.data.id, data.data.title, data.data.tags, data.data.priority);
    if(data.data.time && $("li[id='"+data.data.id+"']").find('.time').text() != data.data.time.slice(0,-3)
    //&& $("li[id='"+data.data.id+"'].currentTask").parent().attr('date') != 'list'
    ){
        scrDragWithTime(data.data.id, data.data.date, data.data.time);
        $("li[id='"+data.data.id+"']").find('.time').text(data.data.time.slice(0,-3));
    }
    $("li[id='"+data.data.id+"'].currentTask").removeClass('currentTask');
    $("li[id='"+data.data.id+"'].need-remove").remove();
    
    if(!data.success){
        mesg(data.message.message, data.message.type);    
    }
}
function srvSetTitle(id, title){
    superAjax('/tasks/setTitle.json',{id: id, title: title});
}
function scrSetTitle(id, title_text, tags, priority){
    var $task = $("li[id='"+id+"'].currentTask");
    var title = $task.find('.editable');
    date = $task.attr('date');
    if(!$task.attr('date')){
        date = 'planned';
    }
    if(+$task.parent().data('refresh')){
       _refreshDays(date);
    }
    if($task.find('.tag-date').length > 0) {
        tagsArray = $.map(tags, function(k, v) {
            return [k];
        })
        if(_.indexOf(tagsArray, $task.parent().data('tag')) == -1){
            $task.addClass('need-remove');     
        }
    }
    title_text = wrapTags(title_text, tags);
    title.html(title_text);   
    if(priority == 1){
        $("li[id='"+id+"']").addClass('important');
    }else{
        $("li[id='"+id+"']").removeClass('important');
    }
}

function wrapTags( title, tags ){
    title = convertToHtml(title);
    if(tags){
        $.each(tags, function(index, value) {
            if( value ){
                value = convertToHtml(value);
                title = title.split('#'+value).join('<span class="tags label label-important" data-tag="'+value+'">&#x23;'+value+'</span>');    
            }
        });
    }
    return title;
}

//----------------clone --------
function taskClone(id, date){
    srvClone(id, date);
}
function onClone(data){
    if(data.success){
        scrCreate(data);
    }else{
        mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.message.errors), data.message.type);   
    }
}
function srvClone(id, date){
    if(date == 'planned'){
                date = '';
    }
    superAjax('/tasks/cloneTask.json',{id: id, date: date });
}
function scrClone(data){
    scrCreate(data);
}

//----------------create -------- 
function taskCreate(title, date){
    srvCreate(title, date);
}
function onCreate(data){
    if(data.success){
        scrCreate(data);
    }else{
    	mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.message.errors), data.message.type);   
    }
}
function srvCreate(title, date){
    superAjax('/tasks/addNewTask.json',{title: title, date: date });
}
function scrCreate(data){
    date = data.data.date;
    if(data.data.list){
            $("ul[data-tag='"+data.data.list+"']").append(addTagToList(data.data));
            _refreshDays('planned');
            date = 'list';
    } else if(data.data.future){
        date = 'planned';
        data.data.date = '';
        $("ul[date='"+date+"']").prepend(AddTask(data.data));
    } else {
        $("ul[date='"+date+"']").append(AddTask(data.data));    
    }
    
    initDelete("li[id='"+data.data.id+"'] .deleteTask");
    initEditAble("li[id='"+data.data.id+"'] .editable");
    $("li[id='"+data.data.id+"']").parent().siblings('.filter').children('a.active').trigger('click');
    if(data.data.time){
        $("li[id='"+data.data.id+"']").addClass('currentTask');
        $("li[id='"+data.data.id+"']").find('.time').text(null);
        scrDragWithTime(data.data.id, data.data.date, data.data.time);
        $("li[id='"+data.data.id+"']").find('.time').text(data.data.time.slice(0,-3));
    }
    srcCountTasks(date, true); 	
}
function AddTask(task){
    var important ='';
	var setTime ='';
    var complete ='';
    var checked = '';
    var time = '<span class="time"></span>';
    var timeEnd = '<span class="timeEnd"></span>';
    var comment = '';
    if (+task.priority){
		important = 'important';
	}
    if (+task.done){
		complete = ' complete';
        checked = ' checked';
	}
    if (task.time){
		setTime = ' setTime';
        time = '<span class="time">'+task.time.slice(0,-3)+'</span>';
        if(task.timeend){
            timeEnd = '<span class="timeEnd">'+task.timeend.slice(0,-3)+'</span>'; 
        }
    }
    if (!task.comment || task.comment == null){
            comment_status =' hide';
            task.comment = '';    
    }
    var date = task.date;
    if( task.date == null ){
        date = '';
    }
    var title = wrapTags(task.title, task.tags);
    taskHtml = '<li id ="'+task.id+'" class="'+setTime+' '+complete+' '+important+'" date="'+date+'">'+ 
                            time+
                            timeEnd+
                            '<span class="move"><i class="icon-move"></i></span>'+
                            '<input type="checkbox" class="done" '+checked+'/>'+
                            '<span class="editable ">'+title+'</span>'+
                            '<span class="commentTask">'+convertToHtml(task.comment)+'</span>'+
                            '<span class="comment-task-icon"><i class="icon-file '+comment_status+'"></i></span>'+
                            '<span class="editTask"><i class="icon-pencil"></i></a></span>'+
                            '<span class="deleteTask"><i class=" icon-trash"></i></span> \n'+
                '</li>';
    return taskHtml;
}
//-------------------------------------

function initEditAble(element){
    
         $(element).editable(function(value, settings) {
                $(this).parent().addClass('currentTask');
                var id = $(this).parent().attr('id'); 
                userEvent('setTitle', {id: id, title: value });
                $(element).siblings('.tag-date').show();
                return convertToHtml(value);
         }
         ,{
            indicator : "<img src='img/indicator.gif'>",
            placeholder : "",
            style  : "inherit",
            data: function(value, settings) {
                $(this).siblings('.tag-date').hide();
                var retval = convertToText(value);
                return retval;
            },
            event : "edit",
            onreset : function(value, settings){
                $(element).siblings('.tag-date').show();
            },
        })
        $(element).on("click", function(e) {
            if (e.target !== this) {
               return; 
            }
            $(this).trigger("edit");
        });
}

function initTags(){
    $(document).on('click', '.tags-list, .tags', function(e) {
        var tag = $(this).attr('data-tag');
        if(tag){
            window.location.hash= '#list-'+tag;    
        }
        $(this).toggleClass('label-success', 'label-important');
        return false;
    });
}

function initDelete(element){
    $(element).inlineConfirmation({
              //reverse: true,
              confirm: "<i class='icon-trash icon-white t-del'></i>",
              cancel: "",
              separator: "",
              expiresIn: 3,
              bindsOnEvent: "click",
              confirmCallback: function(el) {
                 el.parent().fadeIn();
                 el.parent().addClass('currentTask');
                 var id = el.parent().attr('id');
                 userEvent('delete', {id: id});
              },
              cancelCallback: function(el) {
                 //mesg('Отмена удаления .');
              },
    });
}

function initDone(element){
    //$(element).on("click", function(){
    $(document).on('click', element, function(e) {
        var id = $(this).parent().attr('id');
        var done = $(this).is(":checked")? 1 : 0;
        $(this).parent().addClass('currentTask');
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
     $(document).on("click", element, function(){
     //$(element).on("click", function(){
            $(this).parent().addClass('currentTask');
            var task = getTaskForEdit($(this).parent().attr('id'));
            var $priority = $('input:radio[name="priority"]');
            if(+task.priority){
                $priority.filter('[value="1"]').attr('checked', true);
            }else{
                $priority.filter('[value="0"]').attr('checked', true);
            }
            $('#editTask').attr('task_id', $(this).parent().attr('id'));
            $('#editTask').find('#eTitle').val(task.title);
            $('#editTask').find('#eComment').val(task.comment);
            if(task.done){
                $('#editTask').find('#eDone').attr('checked','checked');
            }else {
                $('#editTask').find('#eDone').removeAttr('checked');
            }
            if(task.continued){
                $('#editTask').find('#eContinued').attr('checked','checked');
            }else {
                $('#editTask').find('#eContinued').removeAttr('checked');
            }
            $('#eTime').val(task.time);
            if(task.time){
                $('#eTimeEnd').timepicker('option', 'minTime', task.time, 'maxTime', '23:59').removeAttr('disabled');
            }else{
                $('#eTimeEnd').attr("disabled","disabled");
            }
            $('#eTimeEnd').val(task.timeEnd);
            $("#eDate").val(task.date);
            if (!task.date){
                $('.continued-task').hide();
                $('.repeated-task').hide();
            } else {
                $('.continued-task').show();
                $('.repeated-task').show();
            }
            if (task.repeated){
                $('#editTask').find('#eRepeat').attr('checked','checked');
            }else {
                $('#editTask').find('#eRepeat').removeAttr('checked');
            }
            $('#editTask').modal('show');
    });
}

function initRepeatTask(){
     $('#eRepeat').on("click", function(){
    	 $('#repeatTask').modal('show');
     });
     var $repeatedTask = $('#repeatTask');
     var $until = $repeatedTask.find("input[name='until']");
     $until.change(function() {
    	 $(this).siblings("input[type='text']").focus();
    	 $.each($until, function(index, value){
    		 if(!$(value).is(':checked')) {
    			$(value).siblings("input[type='text']").val('');
		     }
    	 });
    	 
     });
     $repeatedTask.find('#date').datepicker({ 
         dateFormat: 'yy-mm-dd',
         showAnim: 'clip',
     });
     $('#freq').change(function() {
	    $repeatedTask.find('.days-weekly').hide();
        $("[class^=interval]").hide();
        switch($(this).val()){
            case 'dally':
                $(".interval-d").show();
            break;
            case 'weekly':
                $repeatedTask.find('.week input:checkbox').attr('checked', false);
                //$repeatedTask.find('.week input:checkbox:first').attr('checked', true);
                $repeatedTask.find('.days-weekly').show();
                $(".interval-w").show();
            break;
            case 'monthly':
                //$repeatedTask.find('.days-weekly').show();
                $(".interval-m").show();
            break;
            case 'yearly':
                $(".interval-y").show();
            break;
        }       
     });
     
     //create repeated 
     $("#saveRepeate").click(function(){
            var id = $('#editTask').attr('task_id');
            var recur = {};
            var byDays = [];
            recur.freq = $('#freq').val();
            recur.interval = $('#interval').val();
            recur.until = $("input[name=until]:checked").val();
            if (recur.until == 'after'){
                recur.count = $("input[name=until]:checked + #count").val();
            }
            if (recur.until == 'date'){
                recur.date = $("input[name=until]:checked + #date").val();
            }
            if(recur.freq == 'weekly'){
               $repeatedTask.find('.week input:checkbox:checked').each(function(){
                    byDays.push($(this).val());
                });
                if(byDays.length > 0){
                    recur.byDays = byDays;
                } 
            }
//            console.log(recur);
            userEvent('repeated',{id: id, recur: recur});
    }); 
}

function initCommentDay(element){
    $(element).on("click", function(){
        var date = $(this).parent().siblings('ul:first').attr('date');
        userEvent('getCommentDay', {date: date});
        return false;
    });
}

function initCommentTag(element){
    $(document).on("click", element, function(){
        var tag = $(this).parent().siblings('ul:first').data('tag');
        userEvent('getCommentTag', {tag: tag});
        return false;
    });
}


function initCreateTask(element){
    $(document).on("keypress", element, function(e){
    //$(element).on('keypress', function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
            var title = $(this).val();
            var date = $(this).parent().parent().siblings("ul").attr('date');
            if(date == 'planned'){
                date = '';
            }
            if(date == 'list'){
                date = $(this).parent().parent().siblings("ul").data('tag');
            }
            
            userEvent('create', {title: title, date: date });
            $(this).val(null);
            e.preventDefault();
            return false;
        }
    });
}

function initCreateTaskButton(element){
    $(document).on("click", element, function(e){
    //$(element).on('click', function(e){
        var title = $(this).parent().find('.createTask').val();
        var date = $(this).parent().parent().siblings("ul").attr('date');
        if(date == 'planned'){
            date = '';
        }
        if(date == 'list'){
                date = $(this).parent().parent().siblings("ul").data('tag');
        }
        userEvent('create', {title: title, date: date });
        $(this).parent().find('.createTask').val(null);
    });
}

function initCreateList(element){
    $(document).on("keypress", element, function(e){
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
            var tag = $(this).val();
            userEvent('createList', {tag: tag});
            $(this).val(null);
            e.preventDefault();
            return false;
        }
    });
}

function initCreateListButton(element){
    $(document).on("click", element, function(e){
        var tag = $(this).parent().find('.createList').val();
        userEvent('createList', {tag: tag});
        $(this).parent().find('.createList').val(null);
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
                var isACopy = event.ctrlKey == true;
    
                var id = ui.draggable.attr('id');
                var date = $(this).children( "a" ).attr( "date" )
                var time = $.trim(ui.draggable.children('.time').text());
                
                if((date == 'planned' && !ui.draggable.attr("date")) ){
                    mesg(GLOBAL_CONFIG.moveForbiddenMessage, 'success');
                    return false;   
                }
                if(ui.draggable.hasClass('complete') ){
                    mesg(GLOBAL_CONFIG.moveCompletedForbiddenMessage, 'success');
                    return false;   
                }
                //if(ui.draggable.children('.tag-date').length > 0 ){
//                   ui.draggable.children('.tag-date').remove(); 
//                }
                if(isACopy) {
                    userEvent('clone', {id: id, date: date});
                    //return false;
                }else{
                    ui.draggable.addClass('currentTask');
                    userEvent('dragOnDay', {id: id, date: date, time:time});    
                }
            } 
    });
}

function initSortable(element){
    $(element).sortable({
            tolerance:'pointer',
            cancel: '.ui-state-disabled',
            opacity: 0.6, 
            cursor: 'move', 
            placeholder: "ui-state-highlight",
            handle: 'span.move',
            start: function(e, ui){
                isDragging = true;
            },
            update : function(e, ui){
                if(dropped || e.ctrlKey){
                    $(this).removeAttr("style");
                    $(this).sortable('cancel');
                    dropped = false;
                    return true;
                }
                
                if( ui.item.parent().attr('date') == 'expired' || 
                		ui.item.parent().attr('date') == 'future' ||
                		ui.item.parent().attr('date') == 'deleted' ||
                        ui.item.parent().attr('date') == 'continued' 
                		//|| ui.item.parent().data('tag') 
                    ){
                    mesg(GLOBAL_CONFIG.moveForbiddenMessage, 'success');
                    $(this).css("color","");
                    return false;  
                }
                if (ui.item.hasClass('setTime') && !ui.item.parent().data('tag')){
                	var listitems = ui.item.parent().children('li.setTime').get();
                	var error = false;
                	$.each(listitems, function(idx, itm) { 
                            if(toSeconds($(itm).find('.time').text()) > toSeconds($(listitems[idx + 1]).find('.time').text())){
                            	error = true;
                        		return false;
                            }
                     });
                	if (error){
                		return false;
                	}
                }
                
                var id = ui.item.attr('id');
                var position = ui.item.index() + 1;
                var list = {name:'date'};
                
                if(ui.item.parent().data('tag')){
                    list = {name: 'tag', tag: ui.item.parent().data('tag')};
                    
                }
                
                userEvent('changeOrders', {list:list, id: id, position: position});
            },
          stop: function(e, ui) {
                isDragging = false;
                if(dropped){
                    dropped = false;
                    return true;
                }
        },
        
    });
}

function initTab(element){
    $(element).on('shown', function (e) {
    	var tab_id = $(this).attr('date');
        if(tab_id == 'list' || tab_id == 'lists'){
            //window.location.hash= 'list';
        }else{
            var index = _.indexOf(refreshDays, tab_id);
            if( index > -1){
                delete refreshDays[index];
                userEvent('addDay',{date: tab_id, refresh: true});
            }
            window.location.hash = 'day-'+tab_id;
            if(tab_id == 'future'){
                $('.nav.top li').removeClass('active');
                $('.agenda').addClass('active');
            }else{
                $('.nav.top li').removeClass('active');
                $('.tasks').addClass('active');    
            }
        }
    	setFiler(tab_id);
    });
}

function setFiler(tab_id){
    var filter = $.cookie('filter');
    if(!filter){
        filter = 'inProcess';
    }
	$('.tab-content').find('#'+tab_id)
			 .find('.filter a[data="'+filter+'"]')
			 .trigger('click');
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
        var allTasks = listTasks.children('li').length;
        listTasks.children('li').removeClass('hide');
        listTasks.find(".emptyList").addClass('hide');
        $(this).siblings('a').removeClass('active');
        $.cookie('filter', type, { expires: 7, path: '/' });
        switch(type){
            case 'all':
                $(this).addClass('active');
            break;
            case 'inProcess':
                listTasks.children('li.complete').addClass('hide');
                $(this).addClass('active');
                if(allTasks && !listTasks.children('li:not(.complete)').length){
                    if( !listTasks.find(".filterProgress").length ){
                        $(".ex_filterProgress").clone()
                                               .removeClass('ex_filterProgress')
                                               .removeClass('hide')
                                               .addClass('filterProgress')
                                               .appendTo(listTasks);
                    }else{
                       listTasks.find(".filterProgress").removeClass('hide'); 
                    }
                }
            break;
            case 'completed':
                listTasks.children('li:not(.complete)').addClass('hide');
                $(this).addClass('active');
                if(allTasks && !listTasks.children('li.complete').length){
                    if( !listTasks.find(".filterCompleted").length ){
                        $(".ex_filterCompleted").clone()
                                               .removeClass('ex_filterCompleted')
                                               .removeClass('hide')
                                               .addClass('filterCompleted')
                                               .appendTo(listTasks);
                    }else{
                       listTasks.find(".filterCompleted").removeClass('hide'); 
                    }
                }
            break;
        }
        return false;
    });
}
function initDayClick(element){
    //$(element).on('click', function() {
    $(document).on('click', element, function() {
        var date = $(this).attr('date');
        if(!date){
            date ='planned';
        }
        userEvent('addDay',{date: date});
    });
}

function InitClock() { 
  var TimezoneOffset = GLOBAL_CONFIG.timezone;
  var localTime = new Date();
  if(TimezoneOffset == ''){
        TimezoneOffset = localTime.getTimezoneOffset() * -60;
  } 
  var ms = localTime.getTime() + (localTime.getTimezoneOffset() * 60000) + TimezoneOffset * 1000; 
  var time = new Date(ms);  
  var hour = time.getHours();  
  var minute = time.getMinutes(); 
  var second = time.getSeconds(); 
  var temp = "" + ((hour < 10) ? "0" : "") + hour; 
  temp += ((minute < 10) ? ":0" : ":") + minute; 
  document.getElementById('clock').innerHTML = temp; 
  setTimeout("InitClock()", 1000); 
} 
function initDeleteAll(element){
    $(element).on('click', function(){
        var answer = confirm(GLOBAL_CONFIG.deleteAll);
        if(answer){
            var date = $(this).text();
            userEvent('deleteAll', {confirm: answer});    
        }
    });
}

function reload(){
    location.reload();
}

function showErrorConnection(status){
    if(!status){
        setTimeout(checkStatus, +GLOBAL_CONFIG.intervalCheckStatus);
        $('.connError').addClass('hide');
        if(connError){
            reload();
        }
        
    }else{
        setTimeout(checkStatus, +GLOBAL_CONFIG.intervalCheckStatusError);
        $('.connError').removeClass('hide');
        connError = true;
    }
}

function isDate(value){
    var isDate = false;
    if(value.length){
        try{
            $.datepicker.parseDate('yy-mm-dd', value);
            isDate = true;
        }
        catch (e){}
    }
    return isDate;
}

function convertToHtml(str){
  //Encode Entities
  return $("<div/>").text(str).html();
}

function convertToText(str){
    //Dencode Entities
    return $("<div/>").html(str).text();
}
function changeHeightListDays(){
    if($(this).height()-50 < $('.listDay').height()){
        $('.listDay').removeClass('affix1');
    } else {
        $('.listDay').addClass('affix1');
    }
}
//-----------------------------------------------------------------------
var dropped = false;
var countAJAX = 0;
var connError = false;
var pressCtrl = false;
var isDragging = false;
var refreshDays = [];

$(function(){
    initAjax();
     $(window).hashchange( function(e){
        if(location.hash != "") { 
            var pattern_list=/^#list(s$|-.+)/;
            var list = pattern_list.test(location.hash);
            if (list){
                $('.nav.top li').removeClass('active');
                if (location.hash == "#lists" ){
                    $('.lists').addClass('active');
                    userEvent('getLists');
                    activeTab('lists');
                }else{
                    var tag = location.hash.slice(6);
                    userEvent('getListByTag', {tag: tag});
                    activeTab('list');    
                }
                
            } else{
                var hash = location.hash.slice(5);
                var aTab =  $('#main li.active a').attr('date');
                if(hash == aTab) {return;}
                if(isDate(hash)){
                    hash = $.datepicker.formatDate('yy-mm-dd',$.datepicker.parseDate('yy-mm-dd', hash));
                    userEvent('addDay',{date: hash});
                }else if( $.inArray(hash, ["expired", "completed", "deleted", "continued", "future"]) != -1 ){
                    userEvent('getTasksByType', {type: hash});
                    $('#main a[href="#'+hash+'"]').tab('show');
                }else if(hash == "planned"){
                     userEvent('addDay',{date: hash});
                }else{
                    var today = $.datepicker.formatDate('yy-mm-dd',new Date());
                    location.hash = 'day-'+today;
                    $('#main a[href="#'+today+'"]').tab('show');
                }
                if(hash == 'future'){
                    $('.nav.top li').removeClass('active');
                    $('.agenda').addClass('active');
                }else{
                    $('.nav.top li').removeClass('active');
                    $('.tasks').addClass('active');
                }    
            }
         } 
    });
    $(window).hashchange();


    $.datepicker.setDefaults(
        $.extend($.datepicker.regional[GLOBAL_CONFIG.dp_regional])
     );
//
    
    setTimeout(checkStatus, +GLOBAL_CONFIG.intervalCheckStatus);
    $('.help').tooltip({placement:'left',delay: { show: 500, hide: 100 }});
    $('#addDay').tooltip({placement:'bottom',delay: { show: 500, hide: 100 }});
    $('#completed h3').tooltip({placement:'left',delay: { show: 500, hide: 100 }});
    initTags();
    initTab('#main a[data-toggle="tab"]');
    initCreateTask(".createTask");
    initCreateTaskButton(".createTaskButton");
    initCreateList(".createList");
    initCreateListButton(".createListButton");
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
    initCommentTag('.days a[data="commentTag"]');
    initDayClick('.day');
    initDayClick('.tag-date');
    
    initPrintClick('.print');
    InitClock();
    initDeleteAll('.delete_all');
    setFiler($('.listDay .active').children('a').attr('date'));
    //initRepeatTask();

    
    
    
    $(".daysButton a").click(function(){
        var type = $(this).attr('date');
        userEvent('getTasksByType', {type: type});
        $(this).parent().parent().find('li').removeClass('active'); 
    });
    // edit task, modal window      
    $('#eTime').timepicker({
                    timeFormat: 'HH:mm',
                    maxTime: '23:59',
                    interval: 15,
                    startHour: 6,
                    zindex : 9999,
                    change: function(time) {
                        $('#eTimeEnd').timepicker('option', 'minTime', time, 'maxTime', '23:59').removeAttr('disabled');
                        $(this).removeClass('errorEdit');
                    }
    });
    
    $('#eTimeEnd').timepicker({
                    timeFormat: 'HH:mm',
                    maxTime: '23:59',
                    interval: 15,
                    zindex : 9999,
                    change: function(time) {
                        $(this).removeClass('errorEdit');
                    }
    });
    
    $( "#eDate" ).datepicker({ 
                    dateFormat: 'yy-mm-dd',
                    showAnim: 'clip',
                    //minDate: 0
    });
            
    $("#eSave").click(function(){
            var id = $('#editTask').attr('task_id');
            var title = $.trim($('#editTask').find('#eTitle').val());
            var priority = $.trim($('input:radio[name="priority"]:checked', '#editTask').val());
            var done = $.trim($('#editTask').find('#eDone').is(":checked")? 1: 0);
            var continued = $.trim($('#editTask').find('#eContinued').is(":checked")? 1: 0);
            var date = $.trim($( "#eDate" ).val());
            var time = $.trim($('#eTime').val());
            var timeEnd = $.trim($('#eTimeEnd').val());
            var comment = $.trim($('#eComment').val());
            userEvent('edit',{id: id,title: title, priority: priority, continued: continued, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment });
    });
    
    $("#eCommentDaySave").click(function(){
            var date = $('#commentDay').attr('date');
            var tag = $('#commentDay').data('tag');
            var comment = $('#eCommentDay').val();
            if(tag){
            	userEvent('setCommentTag',{tag: tag, comment: comment });
            } else {
            	userEvent('setCommentDay',{date: date, comment: comment });
            }
    });
    
    //modal close 
    $('#editTask').on('hidden', function () {
        scrErrorEdit();
    });
    
    $('#commentDay').on('hidden', function () {
        scrErrorSetCommentDay();
        $('#commentDay').removeAttr('date');
        $('#commentDay').data('tag', null).attr('data-tag', null);
    	
    });
    
    $('#commentDay textarea, #editTask input, #editTask textarea').change(function () {
        $(this).removeClass('errorEdit');
    });
    

    
  // add new day into tabs 
  
    $("#addDay").button().click(function(e) {
        var dp = $('#dp');
        dp.datepicker({
            dateFormat: 'yy-mm-dd',
            showAnim: 'clip',
            onSelect: function(date) {
                userEvent('addDay',{date: date});
            }
        });
        if (dp.datepicker('widget').is(':hidden')) {
            dp.datepicker("show");
        } else {
            dp.hide();
        }
        e.preventDefault();
    });//.disableSelection();
    
    $('.addDay').click(function(){
        $(this).find('li').removeClass('active'); 
    });
    
    window.onbeforeunload = function(e) {
        if(+countAJAX && !connError){
            e = e || window.event;
            if (e) {
                e.returnValue = GLOBAL_CONFIG.onbeforeunloadMessage;
            }
            return GLOBAL_CONFIG.onbeforeunloadMessage;
        }
    };
    
    //console.log($('.listDay').height());
    $('#wrapper-content').css('min-height', $('.listDay').height() + 30 );
    
    $(window).on("resize load", function () {
        changeHeightListDays();
    });
    
    // side bar
    //var $window = $(window)
//    $('.listDay').affix({
//      offset: {
//        top: function () { return $window.width() <= 980 ? 290 : 210 }
//      , bottom: 470
//      }
//    }) 

               
}); 	

//http://jscompress.com/