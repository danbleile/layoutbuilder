<?php
/*
Plugin Name: TKD Layout Builder
Plugin URI: tektondev.com
Description: Builds customizable layouts
Author: Danial Bleile
Author URI: tektondev.com
Version: 0.0.1
*/

class TKD_Layout_Builder {
	
	public static $instance;
	

	/**
	 * Get the current instance or set it an return
	 * @return object current instance of CAHNRSWP_Forester_Directory
	 */
	 public static function get_instance(){
		 
		 if ( null == self::$instance ) {
			 
            self::$instance = new self;
			
			self::$instance->init();
			
        } // end if
 
        return self::$instance;
		 
	 } // end get_instance
	
	
	protected function init(){
		
		require_once 'items/class-tkd-item.php';
		
		require_once 'classes/class-tkd-shortcodes.php';
		$shortcodes = new TKD_Shortcodes();
		
		require_once 'classes/class-tkd-items-factory.php';
		$items_factory = new TKD_Items_Factory( $shortcodes );
		
		if ( is_admin() ){
			
			require_once 'classes/class-tkd-post-editor.php';
			$editor = new TKD_Post_Editor( $items_factory );
			$editor->init();
			
		} // end if
		
	}
	
} // end TKD_Layout_Builder

$tk_builder = TKD_Layout_Builder::get_instance();