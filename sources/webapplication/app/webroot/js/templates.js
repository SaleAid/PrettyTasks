var templates = {};
templates.day_h3_label = '\
        <h3 class="day label label-info margin-bottom10" rel="tooltip" date="<%= date %>" title="' + __d('tasks', 'Кликните для перехода на') + '&nbsp;<%= date %>">\
           <span class="dayDate"><%= title %></span><span class="dash"> - </span><span class="<%= weekDayStyle %>"><%= weekDay %></span>\
        </h3>';
         
templates.ajax_loader_content = '';
        
templates.day_tab_content = '\
    <div class="tab-pane" id="<%= date %>">\
    <div class="row">\
            <div class="listTask">\
            <div class="margin-bottom10">\
            <img src="/img/print.'+GLOBAL_CONFIG.version+'.png" alt="Print" class="print" width = "16" height = "16">\
            <img src="/img/reload.'+GLOBAL_CONFIG.version+'.png" alt="Reload" class="reload" width = "19" height = "19">\
            <h3 class="head-list-info">\
            <% if(date == "planned") { %>\
                '+ __d('tasks', 'Планируемые')+'\
            <% }else{ %>\
                <%= date %>\
            <% } %>\
            <span class="weekday"></span></h3>\
            </div>\
            <div class="well form-inline">\
                <div class="input-append">\
                    <input type="text" size="16" class="input-xxlarge createTask" placeholder="'+ __d('tasks', '+Добавить задание…')+'"/>\
                    <button class="btn createTaskButton">'+__d('tasks', 'Добавить')+'</button>\
                </div>\
                </div>\
                <div class="filter">\
                <span>'+ __d('tasks', 'Фильтр')+':&nbsp; </span>\
                <a href=""  class="active" data="all">'+ __d('tasks', 'Все')+'</a>\
                    <span class="all badge badge-info">\
                        0\
                    </span>,\
                    &nbsp;\
                    <a href=""  data="inProcess">'+ __d('tasks', 'В Процессе')+'</a>\
                    <span class="inProcess badge badge-warning"> \
                        0\
                    </span>,\
                    &nbsp;\
                    <a href=""  data="completed">'+ __d('tasks', 'Выполненные')+'</a>\
                    <span class="completed badge badge-success"> \
                        0\
                    </span>\
                </div>\
                <% if(date != "planned") { %>\
                <div class="days">\
                    <a href="" data="commentDay">'+ __d('tasks', 'Комментарий')+'</a>\
                    <div class="dropdown mood-button">\
                    <a class="btn dropdown-toggle day-rating btn-mood" date="<%= date %>" data-toggle="dropdown">' + __d('tasks', 'Нормальный день') + '\
                    <span class="caret"></span>\
                    </a>\
                    <ul class="dropdown-menu pull-right">\
                        <li><a class="rating-mood" mood="-3" href="#">' + __d('tasks', 'Черный день') + '</a></li>\
                        <li><a class="rating-mood" mood="-2" href="#">' + __d('tasks', 'Ужасный день') + '</a></li>\
                        <li><a class="rating-mood" mood="-1" href="#">' + __d('tasks', 'Плохой день') + '</a></li>\
                        <li><a class="rating-mood" mood="0"  href="#">' + __d('tasks', 'Нормальный день') + '</a></li>\
                        <li><a class="rating-mood" mood="1"  href="#">' + __d('tasks', 'Неплохой день') + '</a></li>\
                        <li><a class="rating-mood" mood="2"  href="#">' + __d('tasks', 'Успешный день') + '</a></li>\
                        <li><a class="rating-mood" mood="3"  href="#">' + __d('tasks', 'Отличный день') + '</a></li>\
                    </ul>\
                    </div>\
                </div>\
                <% } %>\
                <div class="clear"></div>\
                <ul class="sortable connectedSortable ui-helper-reset filtered dthl" date="<%= date %>" data-refresh="0">\
                '+templates.ajax_loader_content+'\
                </ul>\
            </div>\
        </div>\
    </div>';
    
templates.empty_list_day_tasks = '\
    <% if ( type == "past") { %>\
        <div class ="alert alert-info emptyList hide ex_past">\
            ' + __d('messages', 'Нам жаль, что у вас не было планов в эти дни. Планируй на будущее и иди к успеху с нами!') + '\
        </div>\
    <% } else { %>\
        <div class ="alert alert-info emptyList hide ex_future">\
            ' + __d('messages', 'Здесь нет ни одной задачи! Запланируй себе задачи и иди к успеху с нами!') + '\
        </div>\
    <% } %>';
    
templates.task_tag = '\
    <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>" data-repeated="<%= repeated %>" >\
        <span class="time"><%= time %></span>\
        <span class="timeEnd"><%= timeend %></span>\
        <span class="move"><i class="icon-move"></i></span>\
        <input type="checkbox" class="done" value="1" <%= checked %>/>\
        <span class="editable"><%= title %></span><span class="tag-date badge badge-info" date="<%= date %>">\
        <% if(date){%>\
            <%= date %>\
        <% } else { %>\
            '+ __d('tasks', 'Планируемые')+'\
        <% } %>\
        </span><span class="commentTask"><%= comment %></span>\
        <span class="comment-task-icon"><i class="icon-file <%= comment_status %>"></i></span>\
        <span class="editTask"><i class="icon-pencil"></i></span>\
        <span class="delete-wr"><span class="deleteTask"><i class=" icon-trash"></i></span></span>\
    </li>\
    ';
    
templates.add_task = '\
    <li id ="<%= id %>" class="<%= liClass %>" date="<%= date %>" data-continued="<%= continued %>" data-repeated="<%= repeated %>" >\
        <span class="time"><%= time %></span>\
        <span class="timeEnd"><%= timeend %></span>\
        <span class="move"><i class="icon-move"></i></span>\
        <input type="checkbox" class="done" value="1" <%= checked %>/>\
        <span class="editable"><%= title %></span>\
        <span class="commentTask"><%= comment %></span>\
        <span class="comment-task-icon <%= comment_status[1] %>"><i class="icon-file <%= comment_status[0] %>"></i></span>\
        <span class="editTask"><i class="icon-pencil"></i></span>\
        <span class="delete-wr"><span class="deleteTask"><i class=" icon-trash"></i></span></span>\
    </li>\
    ';
templates.empty_list_filterProgress = '\
    <div class ="alert alert-info emptyList filterProgress">\
        ' + __d('messages', 'Здесь нет ни одной задачи! Ты крутой! Стремись почаще видеть эту надпись. Чем чаще ты ее видешь, тем успешнее ты. Она магическая. Заходи к нам. Это принесет тебе счастье.') + '\
    </div>\
    ';
templates.empty_list_filterCompleted = '\
    <div class ="alert alert-info emptyList filterCompleted">\
    ' + __d('messages', 'Здесь нет ни одной задачи! Поторопись! Сделай свои дела и отдыхай. Забудь обо всем и сосредоточься на предыдущей вкладке. Выполни все свои задачи. Это принесет тебе счастье.') + '\
    </div>\
    ';  
