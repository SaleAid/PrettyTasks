var templates = (templates === null || templates === undefined)?{}:templates;
templates.notes = (templates.notes === null || templates.notes === undefined)?{}:templates.notes;
templates.notes.modal_edit_note = '\
    <div id="edit-note" class="modal hide fade <% if (typeof(view) != "undefined") { %> view-note <% } %>" data-id="<%= id %>">\
        <div class="modal-header">\
            <a class="close" data-dismiss="modal" aria-hidden="true">×</a>\
            <ul class="buttons-top">\
                <% if (typeof(view) != "undefined") { %>\
                    <li><a class="note-edit-form" href="#"><i class="icon-edit"></i></a></li>\
                    <li><a class="note-remove-form" href="#"><i class="icon-trash"></i></a></li>\
                <%} else if (typeof(id) != "undefined") { %>\
                    <li><a class="note-remove-form" href="#"><i class="icon-trash"></i></a></li>\
                <% } %>\
            </ul>\
            <h3>\
            <% if (typeof(view) != "undefined") { %>\
                '+ __d('notes', 'Просмотр заметки')+'\
            <%} else if (typeof(id) != "undefined") { %>\
                '+ __d('notes', 'Редактирование заметки')+'\
            <% } else { %>\
                '+ __d('notes', 'Создать заметку')+'\
            <% } %>\
            </h3>\
        </div>\
        <div class="modal-body">\
            <textarea  <% if (typeof(view) != "undefined") { %> readonly  <% } %> class="text-note" id="text-note" rows="3" tabindex ="1"><%= title %></textarea>\
        </div>\
        <div class="modal-footer">\
            <% if (typeof(created) != "undefined") { %>\
                <div class="create-modified">\
                    <span class="muted">'+ __d('notes', 'Создан')+': <%= created %>   </span>\
                    <span class="muted">'+ __d('notes', 'Изменен')+': <%= modified %></span>\
                </div>\
            <% } %>\
            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true" tabindex ="3">'+ __d('notes', 'Закрыть')+'</a>\
            <% if (typeof(view) == "undefined") { %>\
                <button id="save-note" class="btn btn-success" tabindex ="2">'+ __d('notes', 'Сохранить')+'</button>\
            <% } %>\
        </div>\
    </div>\
';