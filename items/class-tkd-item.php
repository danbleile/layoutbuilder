<?php
abstract class TKD_Item {
	
	protected $id;
	
	protected $slug;
	
	protected $settings;
	
	protected $content;
	
	protected $is_editor;
	
	protected $allowed_childen = array();
	
	protected $default_children = false;
	
	protected $children = array();
	
	public function __construct( $settings = array() , $content = '' , $is_editor = true  ){
		
		$this->set_id();
		
		$this->set_settings( $settings );
		
		$this->set_content( $content );
		
		$this->is_editor = $is_editor;
		
	} // end __construct
	
	
	public function set_settings( $settings ){
		
		$this->settings = $settings;
		
	} // end set_settings
	
	
	public function set_content( $content ){
		
		$this->content = $content;
		
	} // end set_content
	
	
	public function set_children( $children , $items_factory ){
		
		$this->children = $children;
		
	} // end set_children
	
	
	public function set_id( $id = false ){
		
		if ( $id ){
			
			$this->id = $id;
			
		} else {
			
			$this->id = uniqid( $this->get_slug() . '_' );
			
		} // end if
		
	} // end set_id
	
	
	public function get_id(){
		
		return $this->id;
		
	} // end get_id
	
	
	public function get_slug(){
		
		return $this->slug;
		
	} // end get_slug
	
	public function get_content(){
		
		return $this->content;
		
	} // end get_content
	
	
	public function get_settings(){
		
		return $this->settings;
		
	} // end get_settings
	
	
	public function get_allowed_children(){
		
		return $this->allowed_childen;
		
	}
	
	
	public function get_default_children(){
		
		return $this->default_children;
		
	}
	
	
	public function get_children(){
		
		return $this->children;
		
	}
	
	
	public function get_editor_content(){
		
		return $this->get_content();
		
	}
	
	public function get_editor_html( $inner_content ){
		
		if ( method_exists( $this , 'the_editor' ) ){
			
			$html = $this->the_editor( $this->get_settings(), $inner_content );
			
		} else {
			
			$html = $this->get_content();
			
		} // end if
		
		return $html;
		
	} // end get_editor_html
	
	
	
}