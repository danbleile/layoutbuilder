<?php
/*
Plugin Name: LayoutBuilder
Plugin URI: tektondev.com
Description: Builds customizable layouts
Author: Danial Bleile
Author URI: tektondev.com
Version: 0.0.1
*/

class TK_Layout_Builder {
	
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
		
		require_once 'classes/class-lb-item.php';
		
		require_once 'classes/class-lb-items-factory.php';
		$items_factory = new LB_Items_Factory();
		
		require_once 'classes/class-lb-shortcode-factory.php';
		$shortcode_factory = new LB_Shortcode_Factory( $items_factory );
		

		add_action( 'init' , array( $shortcode_factory , 'register_item_shortcodes' ) );
		
		add_action( 'init' , array( $this , 'add_tk_the_content' ), 1 );
		
		if ( is_admin() ){
			
			$this->init_admin( $items_factory , $shortcode_factory );
			
		} else {
			
			$this->init_public( $items_factory , $shortcode_factory );
			
		} // end if
		
	}
	
	
	protected function init_admin( $items_factory , $shortcode_factory  ){
		
		require_once 'classes/class-lb-form.php';
		$forms = new LB_Form();
		
		require_once 'classes/class-lb-options.php';
		
		require_once 'classes/class-lb-editor.php';
		
		require_once 'classes/class-lb-save.php';
		
		require_once 'classes/class-tk-ajax.php';
		
		$options = new LB_Options();
		
		//$options->set_options();
		
		$editor = new LB_Editor( $options , $items_factory , $forms );
		
		$ajax = new TK_AJAX( $items_factory , $editor );
		
		$save = new LB_Save( $items_factory , $shortcode_factory );
		
		add_action( 'edit_form_after_title' , array( $editor , 'the_editor_html' ) );
		
		add_action( 'admin_enqueue_scripts', array( $editor, 'add_editor_scripts' ) );
		
		add_filter( 'content_save_pre' , array( $save , 'save_content' ) , 99 );
		
		add_action( 'wp_ajax_tk_editor_get_part', array( $ajax , 'get_part_json' ) );
		
	} // end init_admin
	
	
	protected function init_public( $items_factory , $shortcode_factory  ){
	}
	
	/**
	 * Create custom filter to mirror the_content
	 */
	public function add_tk_the_content(){
		
		add_filter( 'tk_the_content', 'wptexturize'        );
		add_filter( 'tk_the_content', 'convert_smilies'    );
		add_filter( 'tk_the_content', 'convert_chars'      );
		add_filter( 'tk_the_content', 'wpautop'            );
		add_filter( 'tk_the_content', 'shortcode_unautop'  );
		add_filter( 'tk_the_content', 'prepend_attachment' );
		
	} // end add_tk_the_content
	
	
}
$tk_layoutbuilder = TK_Layout_Builder::get_instance();