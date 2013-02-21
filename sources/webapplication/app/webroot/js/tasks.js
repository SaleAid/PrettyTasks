//1
function toListValidationErrorAll(errors){
    var listError = '';
        $.each(errors,function(index, value) {
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
        comment:  $('#'+id).children('.commentTask').text()   
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
                        setTimeout(reload, 5000);
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
            taskChangeOrders(data.id, data.position);
        break; 
        case 'edit':
            taskEdit(data.id, data.title, data.priority, data.done, data.date, data.time, data.timeEnd, data.comment);
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
    if(!data){return;}
    $.each( data, function(index, value) {
            $listUl.append('<li><span class="tags label label-important" data-tag="'+value+'">&#x23;'+value+'></span></li>');
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
    if(!data.tasks){return;}
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
        return _.template($("#task_tag").html(), {
                                  id: task.id,
                                  date: date, 
                                  liClass: liClass,
                                  time: time,
                                  timeend: timeend,
                                  checked: done,
                                  title: title,
                                  comment: comment,
                                  comment_status: comment_status
        });
}
function onGetListByTag(data){
    $('#list .row').show();
    if(!data.success){
        $('#list .row').hide();
        //mesg(data.message.message, data.message.type);
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
     switch(data.type){
        case 'future':
            futureTasks(data.data);
        break;
        case 'expired':
            expiredTasks(data.data);
        break;
        case 'completed':
            completedTasks(data.data);
        break;           
        case 'deleted':
            deletedTasks(data.data);
        break;   
     }
}
function onGetTasksByType(data){
    if(data.success){
        scrGetTasksByType(data);
    }else{
        mesg(data.message.message, data.message.type);
    }
}
function futureTasks(data){
    var listUl = $('#future ul[date="future"]');
    listUl.empty();
    $.each(data,function(index, value) {
        if(+value.list.length){
            day_tmp = _.template($("#day_h3_label").html(), {date: index, weekDayStyle: value.weekDayStyle, weekDay: value.weekDay} );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            //initDayClick(day.children('span:first'));
            listUl.append(day);   
        }
        $.each(value.list,function(index, value) {
            listUl.append( AddTask(value) );
            initDelete(listUl.find("li[id='"+value.Task.id+"'] .deleteTask"));
            //initDone(listUl.find("li[id='"+value.Task.id+"'] .done"));
            listUl.find(" li[id='"+value.Task.id+"'] .editTask").addClass('hide');
        });
    });
    if(!+listUl.children('li').length){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
}
function expiredTasks(data){
    var listUl = $('#expired ul[date="expired"]');
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
    $.each(data,function(index, value) {
        if(+value.list.length){
            day_tmp = _.template($("#day_h3_label").html(), {date: index, weekDayStyle: value.weekDayStyle, weekDay: value.weekDay} );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            //initDayClick(day.children('span:first'));
            listUl.append(day);   
        }
        $.each(value.list,function(index, value) {
            listUl.append( AddTask(value) );
            initDelete(listUl.find("li[id='"+value.Task.id+"'] .deleteTask"));
            //initDone(listUl.find("li[id='"+value.Task.id+"'] .done"));
            listUl.find(" li[id='"+value.Task.id+"'] .editTask").addClass('hide');
        });
    });
}
function completedTasks(data){
    var listUl = $('#completed ul[date="completed"]');
    var task, priority, time, timeend;
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
    }
    $.each(data,function(index, value) {
        if(+value.list.length){
            day_tmp = _.template($("#day_h3_label").html(), {date: index, weekDayStyle: value.weekDayStyle, weekDay: value.weekDay} );
            day = $(day_tmp);
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            //initDayClick(day.children('span:first'));
            listUl.append(day);   
        }
        $.each(value.list,function(index, value) {
            priority = +value.Task.priority ? 'important' : '';
            time = value.Task.time ?  value.Task.time.slice(0,-3) : '';
            timeend = value.Task.timeend ?  value.Task.timeend.slice(0,-3) : ''; 
            
            task = '<li class="'+priority+'"> '+
            '<span class="time">'+time+'</span> '+
            '<span class="timeEnd">'+timeend+'</span> '+
            '<span class="title">'+wrapTags(value.Task.title, value.Task.tags)+'</span> '+
            '</li> ';
            listUl.append( task );
            
        });
    });
}

function deletedTasks(data){
    var listUl = $('#deleted ul[date="deleted"]');
    var task, priority, time, timeend;
    listUl.empty();
    if($.isEmptyObject(data)){
        listUl.siblings('.emptyList').removeClass('hide');
        $('.delete_all').attr('disabled', 'disabled');
    }else{
        listUl.siblings('.emptyList').addClass('hide');
        $('.delete_all').removeAttr('disabled');
    }
    $.each(data,function(index, value) {
        if(+value.list.length){
            day_tmp = _.template($("#day_h3_label").html(), {date: index, weekDayStyle: value.weekDayStyle, weekDay: value.weekDay} );
            day = $(day_tmp);
            if(!index){
                day.removeAttr('title');
                day.find('.dash').remove();    
            }
            day.tooltip({placement:'left',delay: { show: 500, hide: 100 }});
            //initDayClick(day.children('span:first'));
            listUl.append(day);   
        }
        $.each(value.list,function(index, value) {
            listUl.append( AddTask(value) );
            initDelete(listUl.find("li[id='"+value.Task.id+"'] .deleteTask"));
            //initEditAble("li[id='"+value.Task.id+"'] .editable");
            listUl.find(" li[id='"+value.Task.id+"'] .editTask").addClass('hide');
            listUl.find(" li[id='"+value.Task.id+"'] .done").addClass('hide');
        });
    });
}

//----------------------------------

function srcCountTasks(date, drop){
    var listTasks = [];
    if(date == ''){
        date ='planned';
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
    var list = $("ul[date='"+data.data.date+"']");
    var nameDay = $.datepicker.formatDate('DD', new Date (data.data.date));
    list.empty();
    list.siblings('.emptyList ').remove();
    ///list.children('.loadContent').remove();
    var emptyList = _.template($("#empty_list_day_tasks").html(), {type: data.data.weekDayStyle});
    if($.isEmptyObject(data.data.list)){
        emptyList = $(emptyList).removeClass('hide');
    }
    list.after(emptyList);
    list.siblings('.filter').find('span.all').text(data.data.listCount.all);
    list.siblings('.filter').find('span.inProcess').text(data.data.listCount.all - data.data.listCount.done);
    list.siblings('.filter').find('span.completed').text(data.data.listCount.done);
    list.parent().find('.weekday').text(" - "+nameDay);
    list.parent().find('.weekday').addClass(data.data.weekDayStyle);
    initPrintClick(list.parent().find('.print'));
    if(!$.isEmptyObject(data.data.day) && +data.data.day[data.data.date][0].Day.rating){
        $(".ratingDay input[date='"+data.data.date+"']").attr('checked','checked');
    }
    $.each(data.data.list,function(index, value) {
        list.append(AddTask(value));
        initDelete( "li[id='"+value.Task.id+"'] .deleteTask");
        initEditAble("li[id='"+value.Task.id+"'] .editable");
        //initDone("li[id='"+value.Task.id+"'] .done");
        //initEditTask("li[id='"+value.Task.id+"'] .editTask");
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
function taskEdit(id, title, priority, done, date, time, timeEnd, comment){
    //scrEdit(id, title, priority, done, date, time, timeEnd, comment);
    if(+done && !date){
         date = GLOBAL_CONFIG.date;
    }
    srvEdit(id, title, priority, done, date, time, timeEnd, comment);
}
function onEdit(data){
    if(data.success){
        $('#editTask').modal('hide');
        scrEdit(data.data.Task.id, data.data.Task.title, data.data.Task.tags, data.data.Task.priority, data.data.Task.done, data.data.Task.date, data.data.Task.time, data.data.Task.timeend, data.data.Task.comment);
    }else {
        mesg(data.message.message, data.message.type);
        scrErrorEdit(data.errors);    
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

function srvEdit(id, title, priority, done, date, time, timeEnd, comment){
    superAjax('/tasks/editTask.json',{id: id, title: title, priority: priority, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment});
}

function scrEdit(id, title, tags, priority, done, date, time, timeEnd, comment){
    var task = $("li[id='"+id+"'].currentTask");
    var currentTaskDate = task.attr('date');
    var currentTaskTime = task.find('.time').text();
    if(time == null){
        time = '';
    }

    //console.log(currentTaskTime);
    if (date == currentTaskDate && time == currentTaskTime){
        task.removeClass('currentTask');
    }else{
       scrDragWithTime(id, date, time); 
    }
    
    scrDate(id,date);
    scrSetDone(id,done);
    scrSetTitle(id, title, tags, priority);
    scrTime(id, time, timeEnd);
    scrCommentTask(id, comment);
}

function toSeconds(t) {
    var bits = t.split(':');
    return bits[0]*3600 + bits[1]*60;
}

function _refreshDays(date){
    refreshDays.push(date);
    refreshDays = _.uniq(refreshDays);
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
        var timeList = list.find('li.setTime');
        var newPositionID;
        //var change = $.trim(task.find('.time').text())!= time;
       // if(change){
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
                        //if( !(currentTaskDate == date && !time)){
                            $(this).prependTo(list);
                        //}else{
                        //    $(this).appendTo(list);
                        //}
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
                    srcCountTasks(date, true);
                }else{
                    srcCountTasks(date, true);
                }
        });
  //  }
}

//----------------changeOrder---
function taskChangeOrders(id, position){
    scrChangeOrders(id, position);
    srvChangeOrders(id, position);
}
function onChangeOrders(data){
    if(!data.success){
        mesg(data.message.message, data.message.type);    
    }
}
function srvChangeOrders(id, position){
    superAjax('/tasks/changeOrders.json',{id: id, position: position});
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
        mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.errors), data.message.type);    
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
    var date = $("li[id='"+id+"']").attr('date');
    $("li[id='"+id+"']").remove();
    srcCountTasks(date);
}

//----------------setDone-------
function taskSetDone(id, done){
	scrSetDone(id, done);
    srvSetDone(id, done);
}
function onSetDone(data){
    var task = data.data.Task;
	//scrSetDone(data.data.Task.id, data.data.Task.done);
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
    var date = $("li[id='"+id+"']").attr('date');
    if(+done){
        doneEl.attr('checked', 'checked');
        $("li[id='"+id+"']").addClass('complete')
    }else{
        $("li[id='"+id+"']").removeClass('complete');
        doneEl.removeAttr('checked');
    }
    $("li[id='"+id+"']").parent().siblings('.filter').children('a.active').trigger('click');
    srcCountTasks(date);
}

//----------------setTitle------
function taskSetTitle(id, title){
    srvSetTitle(id, title);
}
function onSetTitle(data){
    
	scrSetTitle(data.data.Task.id, data.data.Task.title, data.data.Task.tags, data.data.Task.priority);
    if(data.data.Task.time && $("li[id='"+data.data.Task.id+"']").find('.time').text() != data.data.Task.time.slice(0,-3)){
        //$("ul[date='"+data.data.Task.date+"']").find("li[id='"+data.data.Task.id+"']").addClass('currentTask');
        scrDragWithTime(data.data.Task.id, data.data.Task.date, data.data.Task.time);
        $("li[id='"+data.data.Task.id+"']").find('.time').text(data.data.Task.time.slice(0,-3));
    }
    $("li[id='"+data.data.Task.id+"'].currentTask").removeClass('currentTask');
    $("li[id='"+data.data.Task.id+"'].need-remove").remove();
    
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
    if($task.find('.tag-date').length > 0) {
        _refreshDays($task.attr('date'));
        if(_.indexOf(tags, $task.parent().data('tag')) == -1){
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
        mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.errors), data.message.type);   
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
    	mesg(data.message.message+'<hr/>'+toListValidationErrorAll(data.errors), data.message.type);   
    }
}
function srvCreate(title, date){
    superAjax('/tasks/addNewTask.json',{title: title, date: date });
}
function scrCreate(data){
    date = data.data.Task.date;
    if(data.data.list){
            $("ul[data-tag='"+data.data.list+"']").prepend(addTagToList(data.data.Task));
            _refreshDays('planned');
            date = 'list';
    } else if(data.data.Task.future){
        date = 'planned';
        data.data.Task.date = '';
        $("ul[date='"+date+"']").prepend(AddTask(data.data));
    } else {
        $("ul[date='"+date+"']").append(AddTask(data.data));    
    }
    
    initDelete("li[id='"+data.data.Task.id+"'] .deleteTask");
    initEditAble("li[id='"+data.data.Task.id+"'] .editable");
    //initDone("li[id='"+data.data.Task.id+"'] .done");
    //initEditTask("li[id='"+data.data.Task.id+"'] .editTask");
    $("li[id='"+data.data.Task.id+"']").parent().siblings('.filter').children('a.active').trigger('click');
    if(data.data.Task.time){
        $("li[id='"+data.data.Task.id+"']").addClass('currentTask');
        $("li[id='"+data.data.Task.id+"']").find('.time').text(null);
        scrDragWithTime(data.data.Task.id, data.data.Task.date, data.data.Task.time);
        $("li[id='"+data.data.Task.id+"']").find('.time').text(data.data.Task.time.slice(0,-3));
    }
    srcCountTasks(date); 	
}
function AddTask(data){
    var important ='';
	var setTime ='';
    var complete ='';
    var checked = '';
    var time = '<span class="time"></span>';
    var timeEnd = '<span class="timeEnd"></span>';
    var comment = '';
    if (+data.Task.priority){
		important = 'important';
	}
    if (+data.Task.done){
		complete = ' complete';
        checked = ' checked';
	}
    if (data.Task.time){
		setTime = ' setTime';
        time = '<span class="time">'+data.Task.time.slice(0,-3)+'</span>';
        if(data.Task.timeend){
            timeEnd = '<span class="timeEnd">'+data.Task.timeend.slice(0,-3)+'</span>'; 
        }
    }
    if( ! data.Task.comment ){
        comment = 'hide';
    }
    var title = wrapTags(data.Task.title, data.Task.tags);
    taskHtml = '<li id ="'+data.Task.id+'" class="'+setTime+' '+complete+' '+important+'" date="'+data.Task.date+'">'+ 
                            time+
                            timeEnd+
                            '<span class="move"><i class="icon-move"></i></span>'+
                            '<input type="checkbox" class="done" '+checked+'/>'+
                            '<span class="editable ">'+title+'</span>'+
                            '<span class="commentTask">'+convertToHtml(data.Task.comment)+'</span>'+
                            '<span class="comment-task-icon"><i class="icon-file '+comment+'"></i></span>'+
                            '<span class="editTask"><i class="icon-pencil"></i></a></span>'+
                            '<span class="deleteTask"><i class=" icon-ban-circle"></i></span>'+
                '</li>';
    return taskHtml;
}
//-------------------------------------

function initEditAble(element){
    
         $(element).editable(function(value, settings) {
                $(this).parent().addClass('currentTask');
                var id = $(this).parent().attr('id');   
                userEvent('setTitle', {id: id, title: value });
                return convertToHtml(value);
         }
         ,{
            indicator : "<img src='img/indicator.gif'>",
            placeholder : "",
            style  : "inherit",
            data: function(value, settings) {
                var retval = convertToText(value);
                return retval;
            },
            event : "edit"
        });
        $(element).on("click", function(e) {
            if (e.target !== this) {
               return; 
            }
            $(this).trigger("edit");
        });       

}

function initTags(){
    $(document).on('click', '.tags', function(e) {
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
              confirm: "<a href='#'><i class='icon-ok-sign'></i></a>",
              cancel: "<a href='#'><i class='icon-remove-sign '></i></a>",
              separator: " ",
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
            $('#eTime').val(task.time);
            if(task.time){
                $('#eTimeEnd').timepicker('option', 'minTime', task.time, 'maxTime', '23:59').removeAttr('disabled');
            }else{
                $('#eTimeEnd').attr("disabled","disabled");
            }
            $('#eTimeEnd').val(task.timeEnd);
            $("#eDate").val(task.date);
            if (!task.date){
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

function initCommentTag(element){
    $(document).on("click", element, function(){
        var tag = $(this).parent().siblings('ul:first').data('tag');
        userEvent('getCommentTag', {tag: tag});
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
    $(element).on('click', function(e){
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
    });//.disableSelection();
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
                		ui.item.parent().attr('date') == 'deleted' 
                		//|| ui.item.hasClass('setTime') 
                    ){
                    mesg(GLOBAL_CONFIG.moveForbiddenMessage, 'success');
                    $(this).css("color","");
                    return false;  
                }
                if (ui.item.hasClass('setTime') ){
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
                var position = ui.item.index()+1;
                userEvent('changeOrders', {id: id, position: position});
            },
          stop: function(e, ui) {
                isDragging = false;
                if(dropped){
                    dropped = false;
                    return true;
                }
        },
        
    });//.disableSelection();
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
    //filter ='completed';
    if(filter){
	$('.tab-content').find('#'+tab_id)
			 .find('.filter a[data="'+filter+'"]')
			 .trigger('click');
    }
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
        $.cookie('filter', type, { expires: 7 });
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
  var ms = localTime.getTime() + (localTime.getTimezoneOffset() * 60000) + TimezoneOffset * 3600000; 
  var time = new Date(ms);  
  var hour = time.getHours();  
  var minute = time.getMinutes(); 
  var second = time.getSeconds(); 
  var temp = "" + ((hour < 10) ? "0" : "") + hour; 
  temp += ((minute < 10) ? ":0" : ":") + minute; 
  //temp += ((second < 10) ? ":0" : ":") + second; 
  document.getElementById('clock').innerHTML = temp; 
  setTimeout("InitClock()",1000); 
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
//-----------------------------------------------------------------------
var dropped = false;
var countAJAX = 0;
var connError = false;
var pressCtrl = false;
var isDragging = false;
var refreshDays = [];

$(function(){
     
   // $(document).keydown(function (e) {
//        if(e.ctrlKey && isDragging){
//            pressCtrl = true;
//            $('.move').addClass('cp');
//        }
//    });
//    
//    $(document).keyup(function (e) {
//        if(pressCtrl){
//            pressCtrl = false;
//            $('.move').removeClass('cp');
//        }
//    });
               
               
               
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
                }else if(hash == "future" || hash == "expired" || hash == "completed" || hash == "deleted"){
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
            var date = $.trim($( "#eDate" ).val());
            var time = $.trim($('#eTime').val());
            var timeEnd = $.trim($('#eTimeEnd').val());
            var comment = $.trim($('#eComment').val());
            userEvent('edit',{id: id,title: title, priority: priority, done: done, date: date, time: time, timeEnd: timeEnd, comment: comment });
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