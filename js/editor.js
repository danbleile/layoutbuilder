// JavaScript Document 
tkd_editor = {
	
	wrap : false,
	
	init: function(){
		
		tkd_editor.wrap = jQuery('#tkd_editor');
		
		tkd_editor.layout.init();
		
		tkd_editor.ajax.init();
		
		tkd_editor.forms.init();
		
	}, // end init
	
	layout: {
		
		wrap: false,
		
		init: function(){
			
			tkd_editor.layout.wrap = jQuery( '#tkd-layout-editor' );
			
			tkd_editor.layout.bind_events( false );
			
			tkd_editor.layout.s_content( false );
			
			tkd_editor.layout.set_layout();
			
			tkd_editor.layout.apply_sort( false );
			
		}, // end init
		
		bind_events: function( container ){
			
			if ( ! container ) container = tkd_editor.layout.wrap;
			
			jQuery( window ).resize('resize' , function(){ tkd_editor.layout.set_layout(); });
			
			container.on('click' , '.tkd-remove-item-action' , function( event ) {
				
				event.preventDefault();
				
				tkd_editor.layout.remove_item( jQuery( this ) );
				
			});
			
		}, // end bind events
		
		
		set_layout: function(){
			
			tkd_editor.layout.s_frame_h();
			
			tkd_editor.layout.eq_columns();
			
			tkd_editor.layout.s_items();
			
		}, // end set_layout
		
		s_content: function( container ){
			
			if ( ! container ) container = tkd_editor.layout.wrap;
			
			container.find('textarea.tkd-the-content').each( function(){
				
				var c = jQuery( this );
				
				var itm = c.closest('.tkd-builder-item');
				
				var frm = itm.find('iframe.tkd-the-content-frame');
				
				frm.contents().find('body').html('<main id="tkd-frame-wrap">' + c.val() + '</main>');
				
			}); // end each
			
		},
		
		s_items: function(){
			
			tkd_editor.layout.wrap.find('.items-set').each( function(){
				
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
			
			tkd_editor.layout.wrap.find('iframe.tkd-the-content-frame').each( function(){
				
				var c = jQuery( this );
				
				var h = c.contents().find('#tkd-frame-wrap').outerHeight();
				
				c.height( h + 30 );
				
			});
			
		},
		
		eq_columns: function(){
			
			tkd_editor.layout.wrap.find('.tkd-row').each( function(){
				
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
			
			if ( ! container ) container = tkd_editor.layout.wrap;
			
			container.find('.items-set.tkd-layout-items').sortable({
				stop: function( event , ui ){
					tkd_editor.layout.s_content( false );
					tkd_editor.layout.set_layout();
				}
			});
			
			container.find('.tkd-column > .items-set').sortable({
				connectWith: '.tkd-column > .items-set',
				stop: function( event , ui ){
					tkd_editor.layout.s_content( false );
					tkd_editor.layout.set_layout();
				}
			});
			
			
		}, // end apply sort
		
		insert_row: function( response ){
			
			tkd_editor.layout.wrap.find('.tkd-layout-items').append( response.editor );	
			
			var itm = jQuery('#' + response.id );
			
			tkd_editor.layout.s_content( itm );	
			
			tkd_editor.layout.set_layout();
			
			tkd_editor.layout.apply_sort( itm );
			
			tkd_editor.forms.insert_forms( response.forms );
			
		}, // end response
		
		remove_item: function( ic ){
			
			ic.closest('.tkd-builder-item').slideUp('fast' , function(){
				
				jQuery( this ).remove();
				
				tkd_editor.layout.set_layout();
			
			});
			
		}, // end remove item
		
	}, // end layout
	
	ajax: {
		
		init:function(){
			
			tkd_editor.ajax.bind_events();
			
		}, // end init
		
		bind_events: function(){
			
			jQuery( 'body' ).on('click' , '.tkd-ajax-item' , function( event ){ 
				event.preventDefault(); 
				tkd_editor.ajax.do_ajax( jQuery( this ) ) 
			});
			
		}, // end bind_events
		
		do_ajax: function( itm ){
			
			var type = itm.data('ajaxtype');
			
			switch( type ){
				
				case 'add-row':
					tkd_editor.ajax.add_row( itm );
					break;
				
			} // end switch
			
		}, // end do ajax
		
		add_row: function( itm ){
			
			var data = tkd_editor.ajax.serial( itm );
			
			tkd_editor.ajax.query( data , 'tk_editor_get_part' , 'insert_row' );
			
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
					
					tkd_editor.layout[ callback ]( response );
					
				},
				'json'
			);
			
		}, // end query
		
	}, // end ajax
	
	forms : {
		
		wrap: false,
		
		init: function(){
			
			tkd_editor.forms.wrap = jQuery('#tkd-settings-editor');
			
		}, // end init
		
		insert_forms: function( forms ){
			
			for ( var key in forms ) {
				
				// skip loop if the property is from prototype
    			if ( ! forms.hasOwnProperty( key ) ) continue;
				
				var form = forms[ key ];
				
				if ( 'text' == form.type ){ // uses wpeditor
					
					
				} else {
					
					tkd_editor.forms.wrap.find('.tkd-forms-set').append( form.html );
					
				} // end if
				
				console.log( form );
				
				/*for( var f_key in form ){
					
    				if ( ! form.hasOwnProperty( f_key ) ) continue;
					
					console.log( form
					
				} // end for*/
				
			} // end for
			
		} // end insert forms;
		
		
	}, // end forms
	
	
} // end tkd_editor

tkd_editor.init();