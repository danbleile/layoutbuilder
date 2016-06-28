<?php
class TK_AJAX {
	
	protected $items_factory;
	
	protected $editor;
	
	public function __construct( $items_factory , $editor ){
		
		$this->items_factory = $items_factory;
		
		$this->editor = $editor;
		
	} // end __construct
	
	public function get_part_json(){
		
		$json = array();
		
		if ( ! empty( $_POST[ 'slug' ]  ) ){
			
			$slug = sanitize_text_field( $_POST[ 'slug' ] );
			
			if ( ! empty( $_POST[ 'settings' ] ) ){
				
				$settings = $_POST[ 'settings' ];
				
			} else {
				
				$settings = array();
				
			}// end if
			
			if ( ! empty( $_POST[ 'content' ] ) ){
				
				$content = $_POST[ 'content' ] ;
				
			} else {
				
				$content = '';
				
			}// end if
			
			$item = $this->items_factory->get_item( $slug , $settings , $content , false , true , true );
			
			if ( $item ){
				
				$json['id'] = $item->get_id();
				
				$json['editor'] = $item->get_editor_html_recursive();
				
				$forms = $this->editor->get_items_forms_recursive( array( $item ) );
				
				foreach( $forms as $form_array ){
					
					$form_array['form'] = $this->editor->get_form_html( $form_array );
				
					$json['forms'][ $form_array['id'] ] = $form_array;
					
				} // end foreach
				
				
			} // end if
			
		} // end if
		
		echo json_encode( $json );
		
		die();
		
	} // end get_part_ajax
	
}