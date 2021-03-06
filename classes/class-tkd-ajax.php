<?php

class TKD_Ajax {
	
	private $items_factory;
	
	private $editor;
	
	
	public function __construct( $items_factory , $editor ){
		
		$this->items_factory = $items_factory;
		
		$this->editor = $editor;
		
	} // end __construct
	
	
	public function init(){
		
		if ( is_admin() ){
		
			add_action( 'wp_ajax_tk_editor_get_part', array( $this , 'get_editor_part' ) );
			
			add_action( 'wp_ajax_tk_editor_get_content', array( $this , 'get_editor_content' ) );
		
		} // end if
		
		if ( isset( $_GET['tkd-get-editor-css'] ) ){
			
			add_filter( 'template_include', array( $this , 'get_editor_css_template' ) , 99 );
			
		} // end if
		
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
	
	public function get_editor_content(){
		
		$json = array();
		
		$id = sanitize_text_field( $_POST['tkd_item_id'] );
		
		$slug = sanitize_text_field( $_POST['tkd_item_slug'] ); 
		
		$settings = ( ! empty( $_POST['_tkd_builder'][$id]['settings'] ) ) ? $_POST['_tkd_builder'][$id]['settings'] : array();
		
		$content = ( ! empty( $_POST['_tkd_content_' . $id ] ) ) ? $_POST['_tkd_content_' . $id ] : '';
		
 		$content = stripslashes( $content ); 
		
		$item = $this->items_factory->get_item( $slug , $settings , $content );
		
		if ( $item ){
			
			$json['id'] = $id;
			
			$json['slug'] = $slug;
			
			$json['html'] = $item->get_the_item( true );
			
		} else {
			
			$json['id'] = false;
			
		}// end if
		
		echo json_encode( $json );
		
		die();
		
	} // end get_editor_content
	
	
	public function get_editor_css_template( $template ){
		
		$template = plugin_dir_path( dirname( __FILE__ ) ) . '/templates/editor-css.php';
		
		return $template;
		
	} // end if
	
}