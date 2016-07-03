// JavaScript Document 
tkd_editor = {
	
	wrap : false,
	
	init: function(){
		
		tkd_editor.wrap = jQuery('#tkd_editor');
		
		tkd_editor.layout.init();
		
		tkd_editor.ajax.init();
		
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
			
		}, // end bind events
		
		set_layout: function(){
			
			tkd_editor.layout.s_frame_h();
			
			tkd_editor.layout.eq_columns();
			
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
			
		} // end response
		
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
					
					tkd_editor.layout[ callback ]( response );
					
				},
				'json'
			);
			
		}, // end query
		
	}, // end ajax
	
	
} // end tkd_editor

tkd_editor.init();