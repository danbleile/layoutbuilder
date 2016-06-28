<?php

class TKD_Shortcodes {
	
	protected $shortcodes;
	
	
	public function __construct(){
		
		$this->set_shortcodes();
		
	} // end __construct
	
	
	public function get_shortcode( $slug ){
		
		$shortcodes = $this->get_shortcodes();
		
		if ( array_key_exists( $slug , $shortcodes ) ){
			
			return $shortcodes[ $slug ];
			
		} else {
			
			return false;
			
		} // end if
		
	} // end get_shortcode
	
	
	public function get_shortcodes(){
		
		return $this->shortcodes;
		
	} // end get_shortcodes
	
	
	public function set_shortcodes(){
		
		$sc = array(
			'row' => array(
				'class'    => 'TKD_Item_Row',
				'path'     => plugin_dir_path( dirname( __FILE__ ) ) . 'items/class-tkd-item-row.php',
				'register' => true,
			),
		
		);
		
		$this->shortcodes = $sc;
		
	} // end set_shortcodes
	
} // end TKD_Post_Editor