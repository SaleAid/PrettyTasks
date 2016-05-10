var templates = (templates === null || templates === undefined)?{}:templates;
templates.notes = (templates.notes === null || templates.notes === undefined)?{}:templates.notes;
templates.notes.preview = '\
  <li class="note-box" data-id="<%= id %>">\
    <div class="note">\
        <div class="title-note" ><%= title %></div>\
    </div>\
    <div class="modified"><%= modified %></div>\
    <ul class="buttons">\
        <li><a class="note-fav <%= fav %>" href="#"><i class="icon-star"></i></a></li>\
        <li><a class="note-view" href="#"><i class="icon-zoom-in "></i></a></li>\
        <li><a class="note-edit" href="#"><i class="icon-edit"></i></a></li>\
        <li><a class="note-remove" href="#"><i class="icon-trash"></i></a></li>\
    </ul>\
  </li>\
';