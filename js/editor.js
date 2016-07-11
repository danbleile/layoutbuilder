// JavaScript Document 
var TKD_Editor = {
	
	wrap : false,
	
	init: function(){
		
		TKD_Editor.wrap = jQuery('#TKD_Editor');
		
		TKD_Editor.layout.init();
		
		TKD_Editor.ajax.init();
		
		TKD_Editor.forms.init();
		
		TKD_Editor.modal.init();
		
	}, // end init
	
	layout: {
		
		wrap: false,
		
		init: function(){
			
			TKD_Editor.layout.wrap = jQuery( '#tkd-layout-editor' );
			
			TKD_Editor.layout.bind_events( false );
			
			TKD_Editor.layout.s_content( false );
			
			TKD_Editor.layout.set_layout();
			
			TKD_Editor.layout.apply_sort( false );
			
		}, // end init
		
		bind_events: function( container ){
			
			if ( ! container ) container = TKD_Editor.layout.wrap;
			
			jQuery( window ).resize('resize' , function(){ TKD_Editor.layout.set_layout(); });
			
			container.on('click' , '.tkd-remove-item-action' , function( event ) {
				
				event.preventDefault();
				
				TKD_Editor.layout.remove_item( jQuery( this ) );
				
			});
			
			container.on('click' , '.tkd-edit-item-action' , function( e ) {
				
				e.preventDefault();
				
				TKD_Editor.forms.show_item_form( jQuery( this ).closest( '.tkd-builder-item' ).attr( 'id') );
				
			});
			
		}, // end bind events
		
		
		set_layout: function(){
			
			TKD_Editor.layout.s_frame_h();
			
			TKD_Editor.layout.eq_columns();
			
			TKD_Editor.layout.s_items();
			
		}, // end set_layout
		
		s_content: function( container ){
			
			if ( ! container ) container = TKD_Editor.layout.wrap;
			
			container.find('textarea.tkd-the-content').each( function(){
				
				var c = jQuery( this );
				
				var itm = c.closest('.tkd-builder-item');
				
				var frm = itm.find('iframe.tkd-the-content-frame');
				
				frm.contents().find('body').html('<main id="tkd-frame-wrap">' + c.val() + '</main>');
				
			}); // end each
			
		},
		
		s_items: function(){
			
			TKD_Editor.layout.wrap.find('.items-set').each( function(){
				
				var items = new Array();
				
				var c = jQuery( this );
				
				var inpt = c.siblings('.tkd-child-items-input');
				
				c.children('.tkd-builder-item').each( function(){
					
					items.push( jQuery( this ).attr('id') );
					
				});
				
				inpt.val( items.join(',') );
				
			}) // end each
			
		}, // end s_items
		
		s_frame_h: function(){
			
			TKD_Editor.layout.wrap.find('iframe.tkd-the-content-frame').each( function(){
				
				var c = jQuery( this );
				
				var h = c.contents().find('#tkd-frame-wrap').outerHeight();
				
				c.height( h + 30 );
				
			});
			
		},
		
		eq_columns: function(){
			
			TKD_Editor.layout.wrap.find('.tkd-row').each( function(){
				
				var c = jQuery( this );
				
				var h = 100;
				
				var cols = c.find('.tkd-column > .items-set');
				
				cols.each( function(){
					
					var s = jQuery( this );
					
					cols.css('min-height' , 0 );
					
					if ( s.outerHeight() > h ){
						
						h = s.outerHeight();
						
					} // end if
					
				}); // end each
				
				cols.css('min-height' , h );
				
			});
		},
		
		apply_sort: function( container ){
			
			if ( ! container ) container = TKD_Editor.layout.wrap;
			
			container.find('.items-set.tkd-layout-items').sortable({
				stop: function( event , ui ){
					TKD_Editor.layout.s_content( false );
					TKD_Editor.layout.set_layout();
				}
			});
			
			container.find('.tkd-column > .items-set').sortable({
				connectWith: '.tkd-column > .items-set',
				stop: function( event , ui ){
					TKD_Editor.layout.s_content( false );
					TKD_Editor.layout.set_layout();
				}
			});
			
			
		}, // end apply sort
		
		insert_row: function( response ){
			
			TKD_Editor.layout.wrap.find('.tkd-layout-items').append( response.editor );	
			
			var itm = jQuery('#' + response.id );
			
			TKD_Editor.layout.s_content( itm );	
			
			TKD_Editor.layout.set_layout();
			
			TKD_Editor.layout.apply_sort( itm );
			
			TKD_Editor.forms.insert_forms( response.forms );
			
		}, // end response
		
		remove_item: function( ic ){
			
			ic.closest('.tkd-builder-item').slideUp('fast' , function(){
				
				jQuery( this ).remove();
				
				TKD_Editor.layout.set_layout();
			
			});
			
		}, // end remove item
		
	}, // end layout
	
	ajax: {
		
		init:function(){
			
			TKD_Editor.ajax.bind_events();
			
		}, // end init
		
		bind_events: function(){
			
			jQuery( 'body' ).on('click' , '.tkd-ajax-item' , function( event ){ 
				event.preventDefault(); 
				TKD_Editor.ajax.do_ajax( jQuery( this ) ) 
			});
			
		}, // end bind_events
		
		do_ajax: function( itm ){
			
			var type = itm.data('ajaxtype');
			
			switch( type ){
				
				case 'add-row':
					TKD_Editor.ajax.add_row( itm );
					break;
				
			} // end switch
			
		}, // end do ajax
		
		add_row: function( itm ){
			
			var data = TKD_Editor.ajax.serial( itm );
			
			TKD_Editor.ajax.query( data , 'tk_editor_get_part' , 'insert_row' );
			
		}, // end add row
		
		serial: function( wrap ){
			
			var s = wrap.find( 'input,select,textarea').serialize();
			
			return s;
			
		}, // end serial
		
		query: function( data , action , callback ){
			
			data = data + '&action=' + action;
			
			jQuery.post(
				ajaxurl,
				data,
				function( response ){
					
					console.log( response );
					
					TKD_Editor.layout[ callback ]( response );
					
				},
				'json'
			);
			
		}, // end query
		
	}, // end ajax
	
	forms : {
		
		wrap: false,
		
		init: function(){
			
			TKD_Editor.forms.wrap = jQuery('#tkd-settings-editor');
			
			TKD_Editor.forms.bind_events();
			
		}, // end init
		
		bind_events: function(){
			
		}, // end bind_events
		
		insert_forms: function( forms ){
			
			for ( var key in forms ) {
				
				// skip loop if the property is from prototype
    			if ( ! forms.hasOwnProperty( key ) ) continue;
				
				var form = forms[ key ];
				
				if ( 'text' == form.type ){ // uses wpeditor
					
					
				} else {
					
					TKD_Editor.forms.wrap.find('.tkd-forms-set').append( form.html );
					
				} // end if
				
				console.log( form );
				
				/*for( var f_key in form ){
					
    				if ( ! form.hasOwnProperty( f_key ) ) continue;
					
					console.log( form
					
				} // end for*/
				
			} // end for
			
		}, // end insert forms;
		
		show_item_form: function( item_id ){
			
			var form = TKD_Editor.forms.get_form_by_item_id( item_id );
			
			TKD_Editor.modal.show( form.closest('.tkd-modal') );
			
		}, // end show_item_form
		
		get_form_by_item_id: function( id ){
			
			var form = jQuery('.tkd-form').filter('#tkd-form-' + id ).first();
			
			return form;
			
		}, //get_form_by_item_id
		
		
	}, // end forms
	
	
	modal: {
		
		bg: false,
		
		init: function(){
			
			TKD_Editor.modal.insert_bg();
			
			TKD_Editor.modal.bg = jQuery( '#tkd-modal-bg');
			
			TKD_Editor.modal.bind_events();
			
		}, // end init
		
		
		bind_events: function(){
			
			jQuery('body').on('click', '.tkd-close-modal-action' , function( e ){
				
				e.preventDefault();
				
				TKD_Editor.modal.hide();
				
			});
			
		}, // end bind_events
		
		insert_bg: function(){
			
			jQuery('body').append( '<div id="tkd-modal-bg" class="tkd-close-modal-action"></div>' );
			
		}, // end insert_bg
		
		show: function( m ){
			
			TKD_Editor.modal.bg.fadeIn( 'fast' , function(){
				
				TKD_Editor.modal.set_height( m );
				
			});
			
		}, // end show
		
		hide: function(){
			
			jQuery('.tkd-modal').css('top' , '-9999px');
			
			TKD_Editor.modal.bg.fadeOut( 'fast' );
			
		}, // end hid
		
		set_height: function( m ){
			
			win_h = jQuery(window).scrollTop();
			
			par_off = m.offsetParent().offset().top;
			
			frm_h = ( win_h - par_off ) + 60;
			
			m.css('top', frm_h ); 
			
		}, // end form_set_height
	}, // end modal
	
	
} // end TKD_Editor

TKD_Editor.init();