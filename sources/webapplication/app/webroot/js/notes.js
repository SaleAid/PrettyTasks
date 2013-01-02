// notes backbone
    $(function(){
   
   function mesg (message){
    $.jGrowl.defaults.pool = 1;
    $.jGrowl(message, { 
                    glue: 'before',
                    position: 'top-right',
                    theme: 'success',
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

   window.Note = Backbone.Model.extend({
    
        urlRoot: "/notes",
        // Default attributes for the note item.
        defaults: function() {
          return {
            note: '',
            modified: ''
          };
        },
        parse : function(response, xhr) {
            if(response.action ){ //&& (response.action == 'create')){
                return response.data; 
      		}
      		return response;
        },
        sync: function(method, model, options){
             return Backbone.sync(method, model, options);
        },
        
        initialize: function() {
          if (!this.get("note")) {
            this.set({"note": this.defaults.note});
          }
        },
        
        clear: function() {
          this.destroy();
        }

  });
  //------------------------------------------------------------------------------
  window.NotesList = Backbone.Collection.extend({

        model: Note,
        url: '/notes',
        parse: function(response) {
            return response.data;
        },
        // Notes are sorted by their original insertion order.
      //  comparator: function(note) {
//          return !note.get('modified');
//        }
  }); 
  //------------------------------------------------------------------------------
  
  window.Notes = new NotesList;
  
  window.NoteEdit = Backbone.View.extend({

        events: {
            'click .close-edit': 'close',
            "click #save-note": "updateNote"
        },

        initialize: function() {
            this.template = _.template($('#modal-edit-note').html());
        },

        render: function() {
            var note = "";
            if( this.model ){
                note = $("<div/>").text(this.model.get('note')).html();    
            }
            this.$el.html(this.template({note: note}));
            return this;
        },

        show: function() {
            $(document.body).append(this.render().el);
            this.$el.find('#text-note').focus();                
        },

        close: function() {
            this.remove();
        },
        
        updateNote: function(){
            $('.ajaxLoader').removeClass('hide');
            var value = $.trim(this.$el.find('#text-note').val());
            var that = this;
            //if( !value ) return;
            if( this.model ){
               var oldValue = this.model.get('note');
               if( value == oldValue) {
                    return;
               }
               this.model.save({note: value, action: 'changeNote'},  {
                success: function(model, response){
                    if( !response.success ){
                        //console.log(response);
                        //console.log(response.message.message);
                        mesg(response.message.message);
                        model.set({note: oldValue});
                        model.change();
                        return false;
                    }else {
                        that.close();
                    }
                }    
               });   
            } else {
                Notes.create({note: value});    
            }
        $('.ajaxLoader').addClass('hide');    
        }
    });
  
  window.NoteView = Backbone.View.extend({

       tagName:  "li",
      
       template: _.template($('#item-template').html()),
    
       events: {
         "click a.note-remove" : "clear",
         "click .note"     : "edit", 
       },
    
       initialize: function() {
         this.model.bind('change', this.render, this);
         this.model.bind('destroy', this.remove, this);
       },
    
       render: function() {
         this.$el.html(this.template({note: $("<div/>").text(this.model.get('note')).html(),
                                      modified: this.model.get('modified')  
                    }));
         this.input = this.$('.edit');
         return this;
       },
    
       edit: function() {
         var view = new NoteEdit({ model: this.model });
         view.show();
       },
    
       // Remove the item, destroy the model.
       clear: function() {
         var that = this;

         this.$el.fadeOut("slow", function(){
            that.model.clear();   
         });
         return false;
      }

 });
 
 // The Application
 // ---------------
 // Our overall **AppView** is the top-level piece of UI.
 window.AppView = Backbone.View.extend({

   el: $("#notes-list"),

   events: {
     "click #add-note": "createOnClick",
     "keypress #new-note":  "createOnEnter",
     "click .create-new-note": "openNewNote"
   },

   initialize: function() {
     this.input = this.$("#new-note");
     
     Notes.bind('add', this.addOne, this);
     Notes.bind('reset', this.addAll, this);
     Notes.bind('all', this.render, this);

     //this.footer = this.$('footer');
     //this.main = $('#main');

     Notes.fetch();
     //console.log(Notes);
   },

   render: function() {
   },
   
   openNewNote: function(){
         var view = new NoteEdit();
         view.show(); 
   },

   addOne: function(note) {
     var view = new NoteView({model: note});
     this.$("#notes").prepend(view.render().el);
   },

   addAll: function() {
     Notes.each(this.addOne);
   },

   createOnClick: function(e){
    if (!this.input.val()) return;
    Notes.create({note: this.input.val()});
    this.input.val('');
   },
   
   createOnEnter: function(e) {
     if (e.keyCode != 13) return;
     if (!this.input.val()) return;
     Notes.create({note: this.input.val()});
     this.input.val('');
   },

 });    
    
    window.App = new AppView;
});

