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
	
	public static $version = '0.0.1';
	
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
		
		require_once 'classes/class-tkd-forms.php';
		$forms = new TKD_Forms();
		
		require_once 'classes/class-tkd-items-factory.php';
		$items_factory = new TKD_Items_Factory( $shortcodes , $forms );
		
		add_action( 'init' , array( $this , 'add_tkd_the_content' ), 1 );
		
		if ( is_admin() ){
			
			require_once 'classes/class-tkd-post-editor.php';
			$editor = new TKD_Post_Editor( $items_factory , $forms );
			$editor->init();
			
			require_once 'classes/class-tkd-ajax.php';
			$ajax = new TKD_Ajax( $items_factory , $editor );
			$ajax->init();
			
			if ( isset( $_POST[ $forms->get_prefix() ] ) ){
			
				require_once 'classes/class-tkd-save.php';
				$save = new TKD_Save( $items_factory , $shortcodes );
				$save->init();
			
			} // end if
			
		} // end if
		
	} // end init
	
	/**
	 * Create custom filter to mirror the_content
	 */
	public function add_tkd_the_content(){
		
		add_filter( 'tkd_the_content', 'wptexturize'        );
		add_filter( 'tkd_the_content', 'convert_smilies'    );
		add_filter( 'tkd_the_content', 'convert_chars'      );
		add_filter( 'tkd_the_content', 'wpautop'            );
		add_filter( 'tkd_the_content', 'shortcode_unautop'  );
		add_filter( 'tkd_the_content', 'prepend_attachment' );
		
	} // end add_tk_the_content
	
} // end TKD_Layout_Builder

$tk_builder = TKD_Layout_Builder::get_instance();