
<script id="modal-edit-note" type="text/template">
    <div id="edit-note" class="modal hide fade <% if (typeof(view) != "undefined") { %> view-note <% } %>" data-id="<%= id %>">
        <div class="modal-header">
            <a class="close" data-dismiss="modal" aria-hidden="true">×</a>
            <h3>
            <% if (typeof(view) != "undefined") { %>
                <?php echo __d('notes', 'View');?>
            <%} else if (typeof(id) != "undefined") { %>
                <?php echo __d('notes', 'Edit');?>
            <% } else { %>
                <?php echo __d('notes', 'Create');?>
            <% } %>
            </h3>
        </div>
        <div class="modal-body">
            <textarea  <% if (typeof(view) != "undefined") { %> readonly <% } %> class="text-note" id="text-note" rows="9" tabindex ="1"><%= title %></textarea>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true" tabindex ="3"><?php echo __d('tasks', 'Закрыть');?></a>
            <% if (typeof(view) == "undefined") { %>  
                <button id="save-note" class="btn btn-success" tabindex ="2"><?php echo __d('tasks', 'Сохранить');?></button>
            <% } %>
            
        </div>
    </div>
</script>

