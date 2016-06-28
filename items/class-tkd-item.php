<?php
abstract class TKD_Item {
	
	protected $settings;
	
	protected $content;
	
	protected $is_editor;
	
	protected $allowed_childen = array();
	
	protected $default_children = array();
	
	public function __construct( $settings = array() , $content = '' , $is_editor = true  ){
		
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
	
	public function get_allowed_children(){
		
		return $this->allowed_childen;
		
	}
	
	public function get_default_children(){
		
		return $this->default_children;
		
	}
	
}