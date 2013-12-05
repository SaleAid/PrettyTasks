Date.prototype.toLocaleFormat = function(format) {
	var f = {y : this.getYear() + 1900,m : this.getMonth() + 1,d : this.getDate(),H : this.getHours(),M : this.getMinutes(),S : this.getSeconds()}
	for(k in f)
		format = format.replace('%' + k, f[k] < 10 ? "0" + f[k] : f[k]);
    return format;
};

///////////////////////////////////////////////////////////////////////////////////////////
/*global jQuery, underscore */
jQuery(function( $ ) {
	'use strict';

	var countAJAX = 0;
    var connError = false;
    
    var Utils = {
		displayLoadAjax: function( count ){
            if(!+count){
                $('.ajaxLoader').addClass('hide');
            }else{
                $('.ajaxLoader').removeClass('hide');
            }
        },
        
        mesgShow: function( message, type ){
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
        },
        
        toListValidationErrorAll: function( errors ){
            var listError = '';
            $.each(errors, function( index, value ) {
                if( $.isArray(value )){
                    listError += '<ul>';
                    $.each( value, function(index, val) {
                        listError += '<li>' + val + '</li>';
                    });
                    listError += '</ul>';
                }
            });
            return listError;
        },
        arrErrorToList: function(errors){
            var str = '';
            if(!+errors.length){return;}
            $.each(errors, function(index, value) {
                str += value;
            });
            return str;
        },
        
        reload: function(){
            location.reload();
        },

        showErrorConnection: function( status ){
            if( !status ){
                setTimeout( this.checkStatus, +GLOBAL_CONFIG.intervalCheckStatus );
                $('.connError').addClass('hide');
                if( connError ){
                    this.reload();
                }
                
            }else{
                setTimeout( this.checkStatus, +GLOBAL_CONFIG.intervalCheckStatusError );
                $('.connError').removeClass('hide');
                connError = true;
            }
        },
        
        initAjax: function(){
            $.ajaxSetup({ 
                beforeSend: function(xhr, settings) {  
                    var csrfToken = $("meta[name='csrf-token']").attr('content');
                    if (csrfToken) { 
                        xhr.setRequestHeader("X-CSRFToken", csrfToken ); 
                    } 
                } 
            }); 
        },
        superAjax: function( url, data, responseHandler ){
             var that = this;
             var result = null;
             countAJAX++;
             this.displayLoadAjax( countAJAX );
             $.ajax({
                    url: '/'+GLOBAL_CONFIG.lang + url,
                    type: 'POST',
                    data: data,
                    success: function(data, textStatus, jqXHR) {
                        responseHandler(data);
                        countAJAX--;
                        that.displayLoadAjax( countAJAX ); 
                        
                        if (typeof _gaq != "undefined"){
                            _gaq.push(["_trackEvent", "Notes", url]);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        if(xhr.status == '404' || xhr.status == 0){
                            that.showErrorConnection( true );
                        }else{
                            that.reload();
                        }
                    }
             });
        },
        convertToHtml: function( str ){
          //Encode Entities
          return $("<div/>").text(str).html();
        },
        
        wrapTags: function( title, tags ){
            var that = this;
            title = that.convertToHtml(title);
            if(tags){
                $.each(tags, function(index, value) {
                    if( value ){
                        value = that.convertToHtml(value);
                        title = title.split('#'+value).join('<span class="tags" data-tag="'+value+'">&#x23;'+value+'</span>');    
                    }
                });
            }
            return title;
        },
                
        convertToText: function( str ){
            //Dencode Entities
            return $("<div/>").html(str).text();
        },
        
        usetDateTime: function(dateTime, format){
          var TimezoneOffset = GLOBAL_CONFIG.timezone;
          var localTime = new Date();
          if(TimezoneOffset == ''){
                TimezoneOffset = localTime.getTimezoneOffset() * -60;
          }
          var a = dateTime.split(" ");
          var d = a[0].split("-");
          var t = a[1].split(":");
          var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
          var d1 = new Date(date.getTime() + (1000*TimezoneOffset)); 
          return d1.toLocaleFormat(format);
        }
    };

	var AppNotes = {
		init: function() {
			this.cacheElements();
			this.bindEvents();
            AppNotes.$new_note.focus();
            Utils.initAjax();
            this.currentPage = 1;
            this.stopPagination = false;
            
		},
		cacheElements: function() {
			this.noteTemplate = _.template(templates.notes.preview);
            this.noteEditTemplate = _.template(templates.notes.modal_edit_note);
			this.$newNote = $('#new-note');
            this.$new_note = $('#new-note');
			this.$noteList = $('#notes');
            
		},
		bindEvents: function() {
			var list = this.$noteList;
			$('.add-note').on('click', this.create );
            $('.new-note').on('keyup', this.create );
            $('.btn-note').on('click', this.showNewForm );
            this.blurIntput();
            $('.create-new-note').on('click', this.show );
            list.on( 'click', '.note-edit', this.show );
            list.on( 'click', '.note-edit-form', this.showViaForm );
            list.on( 'click', '.note-view', this.view );
            this.inlineConfirmation('.note-remove');
            //this.deleteViaForm('.note-remove-form');
            list.on( 'click', '.note-remove-form', this.deleteViaForm );
            list.on( 'click', '#save-note', this.update );
            list.on( 'click', '.tags', this.clickTags );
            $('.btn-see-more').on('click', this.getNotes );
        },
		blurIntput: function(){
		  AppNotes.$new_note.blur(function(){
		      if($(this).hasClass('errorEdit')){
    		      $(this).removeClass('errorEdit');
    		  }
		  });
    	},
        modalForm: function(){
            $('#edit-note').modal({
                backdrop: true,
                keyboard: true
            }).css({
                width: '70%',
                'margin-left': function () {
                    return -($(this).width() / 2);
                }
            });
          var heightNoteText = $(window).height()/2 - 25;
          if(heightNoteText < 200){
            heightNoteText = 200;
          }
          $('#edit-note').find('.text-note').css('height', heightNoteText);
          
          $('#edit-note').on('shown', function () {
              $(this).find('#text-note').focus();
          });
          $('#edit-note').on('hidden', function () {
              $(this).remove();
              AppNotes.$new_note.focus();
          });    
        },
        
        getNotes: function(){
            AppNotes.currentPage++;
            AppNotes.userEvent('getNotes', {page: AppNotes.currentPage});
        },
        
        showNewForm: function() {
		  AppNotes.$noteList.append(AppNotes.noteEditTemplate({title: '', id: undefined}));
          AppNotes.modalForm();   
        },
                
        show: function() {
		  var id = $(this).parents('li.note-box').data('id');
          AppNotes.userEvent('getNote', {id: id}); 
        },
        
        showViaForm: function(){
            var modal = $(this).parents('#edit-note');
            var id = modal.data('id');
            $('#edit-note').modal('hide');
            $('#edit-note').remove();
            AppNotes.userEvent('getNote', {id: id });
        },
        
        view: function() {
		  var id = $(this).parents('li.note-box').data('id');
          AppNotes.userEvent('getNote', {id: id, view: true }); 
        },
        
        create: function(e) {
		    var $input = AppNotes.$new_note,
				val = $.trim( $input.val() );
            if((e.ctrlKey && e.keyCode == 13) || e.type == 'click'){
                if (!val ){
                    $input.addClass('errorEdit');
                    $input.focus();
                    return;
    			}
                $input.removeClass('errorEdit');   
    			AppNotes.userEvent('create', {title: val });
    			$input.val('');
                    
            }
            $input.focus();
            
		},
		update: function() {
			var title = $.trim( $('#edit-note').find('#text-note').val() );
            var id = $.trim($('#edit-note').data('id'));
            
            if (id != "undefined"){
                AppNotes.userEvent('update', {id: id, title: title });
            }else {
                AppNotes.userEvent('create', {title: title});    
            }
            
        },
		destroy: function() {
		    var that = this;
			var id = $(this).parents('li.note-box').data('id');
            if( !id ){
                return false;
            }
            
            
        },
        inlineConfirmation: function(el){
            $(el).inlineConfirmation({
              //reverse: true,
              confirm: "<a href='#'><i class='icon-trash icon-white n-del'></i></a>",
              cancel: "",
              separator: "",
              expiresIn: 300,
              hideOriginalAction: false,
              bindsOnEvent: "click",
              confirmCallback: function(el) {
                 var id = $(el).parents('li.note-box').data('id');
                 AppNotes.userEvent('delete', {id: id });
              },
              cancelCallback: function(el) {
                 //mesg('Отмена удаления .');
              },
           });
           
        },
        deleteViaForm: function(){
           var modal = $(this).parents('#edit-note');
           var id = modal.data('id');
           AppNotes.userEvent('delete', {id: id });
           $('#edit-note').modal('hide');
           $('#edit-note').remove();
        },
        
        clickTags: function(){
            var tag = $(this).attr('data-tag');
            if(tag){
                window.location = '/'+GLOBAL_CONFIG.lang+'/tasks#list-'+tag;    
            }
            return false;
        },
        
        
        //--------------------------------------------
        userEvent: function( action, data ){
            switch( action ){
                case 'create':
                    this.noteCreate(data.title);
                break;
                case 'update':
                    this.noteUpdate(data.id, data.title);
                break;
                case 'delete':
                    this.noteDelete(data.id);
                break;
                case 'getNote':
                    this.noteGet(data.id, data.view);
                break;
                case 'getNotes':
                    this.notesGet(data.page, data.count);
                break;
            }
        },
        
        responseHandler: function( data ){
            switch( data.action ){
                case 'create':
                     AppNotes.onCreate(data);
                break;
                case 'update':
                    AppNotes.onUpdate(data);
                break;
                case 'delete':
                    AppNotes.onDelete(data);
                break;
                case 'getNote':
                    AppNotes.onGetNote(data);
                break;
                case 'getNoteView':
                    AppNotes.onGetNote(data, true);
                break;
                case 'getNotes':
                    AppNotes.onGetNotes(data);
                break;
            }
        },
        
        //get notes
        notesGet: function(page, count){
            this.srvGetNotes(page, count);
        },
        onGetNotes: function( data ){
            if( data.success ){
                if(data.data.hide){
                    $('.btn-see-more').hide();
                }
                this.renderGetNotes( data.data.list );
            }else{
                Utils.mesgShow(data.message.message+'<hr/>'+ Utils.toListValidationErrorAll(data.message.errors), data.message.type);
            }
        },
        srvGetNotes: function( page, count ){
            Utils.superAjax('/notes/getNotes.json', {page: page, count: count }, AppNotes.responseHandler);
        },
        renderGetNotes: function( data ){
              var delay = 0;
              $.each( data, function(index, note) {
                  AppNotes.$noteList.append(AppNotes.noteTemplate({ id: note.id, title: Utils.wrapTags(note.title, note.tags), modified: Utils.usetDateTime(note.modified, '%y-%m-%d %H:%M') }))
                  ;
                  AppNotes.$noteList.find('li[data-id='+note.id+']').hide();
                  AppNotes.$noteList.find('li[data-id='+note.id+']').delay(delay).slideDown(600);
                  //delay += 500;  
                  AppNotes.inlineConfirmation('li[data-id='+note.id+'] .note-remove')  
              });
        },

        //get note
        noteGet: function(id, view){
            this.srvGetNote(id, view);
        },
        onGetNote: function( data, view ){
            if( data.success ){
                this.renderGetNote( data.data, view );
            }else{
                Utils.mesgShow(data.message.message+'<hr/>'+ Utils.toListValidationErrorAll(data.message.errors), data.message.type);
            }
        },
        srvGetNote: function( id, view ){
            Utils.superAjax('/notes/getNote.json', {id: id, view: view }, AppNotes.responseHandler);
        },
        renderGetNote: function( data, view ){
              var list = AppNotes.$noteList;
              list.append(AppNotes.noteEditTemplate({title: data.title, id: data.id, created: Utils.usetDateTime(data.created, '%y-%m-%d %H:%M:%S'), modified: Utils.usetDateTime(data.modified, '%y-%m-%d %H:%M:%S'), view: view}));
              AppNotes.modalForm(); 
        },
        
        // create 
        noteCreate: function(title){
            this.srvCreate(title);
        },
        onCreate: function( data ){
            if( data.success ){
                this.renderCreate( data.data );
                $('#edit-note').modal('hide');
                
            }else{
                Utils.mesgShow(data.message.message+'<hr/>'+ Utils.toListValidationErrorAll(data.message.errors), data.message.type);
                //this.showTooltipError(data.message.errors);  
                    
            }
        },
        srvCreate: function( title ){
            Utils.superAjax('/notes/create.json', {title: title }, AppNotes.responseHandler);
        },
        renderCreate: function( data ){
            this.$noteList.prepend(this.noteTemplate({ id: data.id, title: Utils.wrapTags(data.title, data.tags), modified: Utils.usetDateTime(data.modified, '%y-%m-%d %H:%M') }))
                          ;
            AppNotes.$noteList.find('li[data-id='+data.id+']').hide();
            AppNotes.$noteList.find('li[data-id='+data.id+']').slideDown(600);
            this.inlineConfirmation('li[data-id='+data.id+'] .note-remove');
            if(AppNotes.$noteList.length > 0){
                 $('.emptyList').addClass('hide');
            }
        },
        //delete
        noteDelete: function( id ){
            this.srvDelete( id );
            this.renderDelete( id );
        },
        onDelete: function(data){
            if(!data.success){
                Utils.mesgShow(data.message.message, data.message.type);
            }    
        },
        srvDelete: function( id ){
            Utils.superAjax('/notes/delete.json', {id: id}, AppNotes.responseHandler);
        },
        renderDelete: function( id ){
            
            $("li[data-id='"+id+"']").hide( "drop", { direction: "left" }, "slow", function(){
                $(this).remove();
                if(AppNotes.$noteList.children('li').length < 1){
                     $('.emptyList').removeClass('hide');
                }
            });
        },
        //update
        noteUpdate: function( id, title ){
            this.srvUpdate( id, title );
        },
        onUpdate: function(data){
            if( data.success ){
                this.renderUpdate( data.data );
                $('#edit-note').modal('hide');
            }else{
            	Utils.mesgShow(data.message.message+'<hr/>'+Utils.toListValidationErrorAll(data.message.errors), data.message.type);
                //this.showTooltipError(data.message.errors);   
            } 
        },
        srvUpdate: function( id, title ){
            Utils.superAjax('/notes/update.json', {id: id, title: title}, AppNotes.responseHandler);
        },
        renderUpdate: function( data ){
            var list = this.$noteList;
            $("li[data-id='"+data.id+"']").hide( "drop", { direction: "left" }, "slow", function(){
                list.prepend(this);
                $(this).show();
                $(this).find('.title-note').html( Utils.wrapTags(data.title, data.tags) );
                $(this).find('.modified').html( Utils.usetDateTime(data.modified, '%y-%m-%d %H:%M') );
            } ); 
        },
        getUpdateElement: function (name){
            var element = '';
            switch(name){
                case 'title':
                    element = $('#text-note');
                break;
            }
            return element;
        },
        showTooltipError: function( data ){
            var that = this;
            $('.errorEdit').removeClass('errorEdit')
                           .removeAttr('rel')
                           .removeAttr('title')
                           .removeAttr('data-original-title')
                           .off('tooltip');
            if(data !== undefined){
                $.each(data, function(index, value) {
                    if(that.getUpdateElement( index )){
                        that.getUpdateElement( index )
                            .addClass('errorEdit')
                            .attr('rel', 'tooltip')
                            .attr('data-original-title', Utils.arrErrorToList(value))
                            .tooltip({placement:'right',
                                      delay: { show: 500, hide: 100 },
                                      //trigger: 'focus',
                                      template: '<div class="tooltip errorTooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                            }); 
                    }
                });
            }
            
        }
    };

	AppNotes.init();
    
    
    window.onbeforeunload = function(e) {
        if(+countAJAX && !connError){
            e = e || window.event;
            if (e) {
                e.returnValue = GLOBAL_CONFIG.onbeforeunloadMessage;
            }
            return GLOBAL_CONFIG.onbeforeunloadMessage;
        }
    };


}); 	

