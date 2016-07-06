<?php

class TKD_Ajax {
	
	private $items_factory;
	
	private $editor;
	
	
	public function __construct( $items_factory , $editor ){
		
		$this->items_factory = $items_factory;
		
		$this->editor = $editor;
		
	} // end __construct
	
	
	public function init(){
		
		add_action( 'wp_ajax_tk_editor_get_part', array( $this , 'get_editor_part' ) );
		
	} // end init
	
	
	public function get_editor_part(){
		
		$json = array();
		
		$slug = ( ! empty ( $_POST['tkd_slug'] ) ) ? sanitize_text_field( $_POST['tkd_slug'] ) : false;
		
		$settings = ( isset( $_POST['tkd_setting'] ) && is_array( $_POST['tkd_setting'] ) ) ? $_POST['tkd_setting'] : array();
		
		if ( $slug ){
			
			$json['slug'] = $slug;
			
			$item = $this->items_factory->get_item( $slug , $settings );
			
			$json['id'] = $item->get_id();
			
			$json['editor'] = $this->editor->get_editor_items_html( array( $item ) );
			
			$json['forms'] = $this->editor->get_items_forms( array( $item ) , true );
			
		} // end if
		
		echo json_encode( $json );
		
		die();
		
	} // end get_editor_part
	
}